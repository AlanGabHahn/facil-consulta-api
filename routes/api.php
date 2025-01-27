<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    AuthController,
    CidadeController,
    MedicoController,
    PacienteController
};

Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'user']);

Route::get('/cidades', [CidadeController::class, 'index']);
Route::get('/cidades/{id_cidade}/medicos', [CidadeController::class, 'listarMedicosCidade']);

Route::get('/medicos', [MedicoController::class, 'index']);
Route::post('/medicos', [MedicoController::class, 'store']);
Route::post('/medicos/consulta', [MedicoController::class, 'agendarConsulta']);
Route::get('/medicos/{id_medico}/pacientes', [CidadeController::class, 'listarPacientesMedicos']);

Route::post('/pacientes', [PacienteController::class, 'store']);
Route::put('/pacientes/{id_paciente}', [PacienteController::class, 'update']);