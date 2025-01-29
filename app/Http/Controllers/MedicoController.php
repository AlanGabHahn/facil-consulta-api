<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Medico, Consulta};
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class MedicoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $nome = $request->query('nome');

        $query = Medico::select('id', 'nome', 'especialidade', 'cidade_id');

        if (!empty($nome)) {
            $query->whereRaw('LOWER(nome) LIKE ?', ['%' . strtolower(str_replace(['dr.', 'dra.', 'dra', 'dr'], '', $nome)) . '%']);
        }
        
        $medicos = $query->orderBy('nome', 'asc')->get();

        return response()->json($medicos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validacao = $request->validate([
                'nome' => 'required|string|max:255',
                'especialidade' => 'required|string|max:255',
                'cidade_id' => 'required|integer|exists:cidades,id',
            ]);
    
            $medico = Medico::create($validacao);

            DB::commit();
    
            return response()->json($medico->only([
                                                    'id',
                                                    'nome',
                                                    'especialidade',
                                                    'cidade_id',
                                                    'created_at',
                                                    'updated_at',
                                                    'deleted_at'
                                                ]), 201);
        } catch (ValidationException $e) {
            DB::rollBack();

            return response()->json([
                'errors' => $e->errors(),
            ], 401);
        }
    }

    public function agendarConsulta(Request $request)
    {
        DB::beginTransaction();
        try {
            $validacao = $request->validate([
                'medico_id' => 'required|exists:medicos,id',
                'paciente_id' => 'required|exists:pacientes,id',
                'data' => 'required|date_format:Y-m-d H:i:s|after:now',
            ]);

            $consulta = Consulta::create([
                'medico_id' => $validacao['medico_id'],
                'paciente_id' => $validacao['paciente_id'],
                'data' => $validacao['data'],
            ]);

            DB::commit();

            return response()->json($consulta->only([
                                                        'id',
                                                        'medico_id',
                                                        'paciente_id',
                                                        'data',
                                                        'created_at',
                                                        'updated_at',
                                                        'deleted_at'
                                                    ]), 201);

        } catch (ValidationException $e) {
            DB::rollBack();

            return response()->json([
                'errors' => $e->errors(),
            ], 401);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function listarPacientesMedicos(Request $request, int $medico_id)
    {
        $apenas_agendadas = $request->query('apenas-agendadas', false);
        $nome = $request->query('nome');

        $query = Consulta::where('medico_id', $medico_id)
            ->with(['paciente'])
            ->orderBy('data', 'asc');

        if ($apenas_agendadas) {
            $query->where('data', '>=', now());
        }

        if (!empty($nome)) {
            $query->whereHas('paciente', function ($subQuery) use ($nome) {
                $subQuery->where('nome', 'like', '%' . $nome . '%');
            });
        }

        $consultas = $query->get();

        $pacientes_consulta = $consultas->map(function ($consulta) {
            return [
                'id' => $consulta->paciente->id,
                'nome' => $consulta->paciente->nome,
                'cpf' => $this->formatarCpf($consulta->paciente->cpf),
                'celular' => $consulta->paciente->celular,
                'created_at' => $consulta->paciente->created_at,
                'updated_at' => $consulta->paciente->updated_at,
                'deleted_at' => $consulta->paciente->deleted_at,
                'consulta' => [
                    'id' => $consulta->id,
                    'data' => $consulta->data,
                    'created_at' => $consulta->created_at,
                    'updated_at' => $consulta->updated_at,
                    'deleted_at' => $consulta->deleted_at,
                ],
            ];
        });

        return response()->json($pacientes_consulta, 200);
    }

    private function formatarCpf($cpf)
    {
        // Aplica a máscara XXX.XXX.XXX-XX
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
    }
}
