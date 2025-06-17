<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Mpdf\Mpdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SalvarImagensController extends Controller
{
    public function salvar(Request $request)
    {
        if ($request->hasFile('imagem')) {
            $file = $request->file('imagem');

            // Garante que o diretório exista
            $path = $file->storeAs('privado/imagens', $file->getClientOriginalName());

            return response()->json([
                'status' => 'sucesso',
                'caminho' => storage_path("app/" . $path)
            ]);
        }

        return response()->json([
            'status' => 'erro',
            'mensagem' => 'Nenhuma imagem recebida'
        ], 400);
    }
}
