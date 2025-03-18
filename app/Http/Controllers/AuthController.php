<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Mostrar o formulário de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Processar o login
    public function login(Request $request)
    {
        // Validar os dados do formulário
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);

        // Tentar autenticar o usuário
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('/home'); // Redireciona para a home (ou qualquer outra página após login)
        }

        // Se falhar, retorna com erro
        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login'); // Redireciona para a página de login após logout
    }



}
