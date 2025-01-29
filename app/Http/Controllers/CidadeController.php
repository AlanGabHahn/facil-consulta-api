<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{Cidade, Medico};

class CidadeController extends Controller
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

        $query =  Cidade::select('id', 'nome', 'estado');

        if (!empty($nome)) {
            $query->where('nome', 'like', '%' . $nome . '%');
        }

        $cidades = $query->orderBy('nome', 'asc')->get();

        return response()->json($cidades, 200);

    }

    public function listarMedicosCidade(Request $request, int $id_cidade)
    {
        $nome = $request->query('nome');

        $query = Medico::select('id', 'nome', 'especialidade', 'cidade_id')
                        ->where('cidade_id', $id_cidade);

        if (!empty($nome)) {
            $query->whereRaw('LOWER(nome) LIKE ?', ['%' . strtolower(str_replace(['dr.', 'dra.', 'dra', 'dr'], '', $nome)) . '%']);
        }
        
        $medicos = $query->orderBy('nome', 'asc')->get();

        return response()->json($medicos, 200);
    }

}
