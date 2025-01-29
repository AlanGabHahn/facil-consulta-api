<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'listarUsuarios', 'unauthorized']]);
    }

    public function login(Request $request)
    {
        $credenciais = request(['email', 'password']);

        if (! $token = auth()->attempt($credenciais)) {
            return response()->json(['error' => 'E-mail e/ou senha inválidos'], 401);
        }

        return ['token' => $token];
    }

    public function listarUsuarios()
    {
        $users = User::select(['id', 'name', 'email'])->get();
        return response()->json($users, 200);
    }

    public function unauthorized()
    {
        return response()->json([
            'error' => 'Você não está logado.'
        ], 401);
    }
}
