<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImagemController extends Controller
{
    public function store(Request $request)
    {
        // Validação simples
        if (!$request->hasFile('imagem')) {
            return response()->json(['erro' => 'Nenhuma imagem recebida.'], 400);
        }
        // Autenticação via Bearer Token
        if ($request->bearerToken() !== config('api.chave_vba')) {
            return response()->json(['erro' => 'Não autorizado.'], 401);
        }

        $file = $request->file('imagem');
        $filename = $file->getClientOriginalName();

        // Armazenar na pasta pública 'storage/app/public/imagens'
        $path = $file->storeAs('public/imagens', $filename);

        return response()->json([
            'mensagem' => 'Imagem salva com sucesso',
            'caminho' => $path,
        ]);
    }
}