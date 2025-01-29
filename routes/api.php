<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    CidadeController,
    MedicoController,
    PacienteController
};

/* Rotas Públicas (Sem Autenticação) */
Route::get('/401', [AuthController::class, 'unauthorized'])->name('login');

/* Autenticação */
Route::post('auth/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'listarUsuarios']);

/* Cidades */
Route::prefix('cidades')->group(function () {
    Route::get('/', [CidadeController::class, 'index']);
    Route::get('/{cidade_id}/medicos', [CidadeController::class, 'listarMedicosCidade']);
});

/* Médicos */
Route::prefix('medicos')->group(function () {
    Route::get('/', [MedicoController::class, 'index']);
    Route::post('/', [MedicoController::class, 'store']);
    Route::post('/consulta', [MedicoController::class, 'agendarConsulta']);
    Route::get('/{medico_id}/pacientes', [MedicoController::class, 'listarPacientesMedicos']);
});

/* Pacientes */
Route::prefix('pacientes')->group(function () {
    Route::post('/', [PacienteController::class, 'store']);
    Route::put('/{id_paciente}', [PacienteController::class, 'update']);
});
