<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class PacienteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
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
                'cpf' => 'required|string|unique:pacientes,cpf|max:20',
                'celular' => 'required|string|max:20',
            ]);

            $paciente = Paciente::create($validacao);

            DB::commit();

            return response()->json($paciente->only([
                                                        'id',
                                                        'nome',
                                                        'cpf',
                                                        'celular',
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {

            $validacao = $request->validate([
                'nome' => 'sometimes|required|string|max:255',
                'celular' => 'sometimes|required|string|max:20',
            ]);


            if (! $paciente = Paciente::find($id)) {
                return response()->json([
                    'message' => 'Paciente não encontrado.',
                ], 404);
            }

            $paciente->update($validacao);

            DB::commit();

            return response()->json($paciente, 201);

        } catch (ValidationException $e) {
            DB::rollBack();

            return response()->json([
                'errors' => $e->errors(),
            ], 401);
        }
    }

}
