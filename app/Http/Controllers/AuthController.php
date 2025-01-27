<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $credenciais = request(['email', 'password']);

        if (! $token = auth()->attempt($credenciais)) {
            return response()->json(['error' => 'E-mail e/ou senha inválidos'], 401);
        }
        
        return ['token' => $token];
    }
}
