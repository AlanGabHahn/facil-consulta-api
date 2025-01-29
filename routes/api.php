<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    AuthController,
    CidadeController,
    MedicoController,
    PacienteController
};

/* Não Autorizado */
Route::get('/401', [AuthController::class, 'unauthorized'])->name('login');

/* Autenticação */
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'listarUsuarios']);

/* Cidades */
Route::get('/cidades', [CidadeController::class, 'index']);
Route::get('/cidades/{cidade_id}/medicos', [CidadeController::class, 'listarMedicosCidade']);

/* Medicos */
Route::get('/medicos', [MedicoController::class, 'index']);
Route::post('/medicos', [MedicoController::class, 'store']);
Route::post('/medicos/consulta', [MedicoController::class, 'agendarConsulta']);
Route::get('/medicos/{medico_id}/pacientes', [MedicoController::class, 'listarPacientesMedicos']);

Route::put('/pacientes/{id_paciente}', [PacienteController::class, 'update']);
Route::post('/pacientes', [PacienteController::class, 'store']);