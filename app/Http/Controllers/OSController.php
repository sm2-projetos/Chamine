<?php

namespace App\Http\Controllers;

use App\Models\OS;
use App\Models\PerfilChamine;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OSController extends Controller
{
    public function create()
    {
        return view('os.create');
    }

    public function store(Request $request)
    {
        // Lógica para armazenar a OS
        // Por exemplo:
        // OS::create($request->all());

        return redirect()->route('os.create')->with('success', 'OS criada com sucesso!');
    }

    public function showForm($id)
    {
        $os = OS::findOrFail($id);
        $proposta = $os->proposta; // Obter a proposta associada à OS
        $empresa = $proposta->empresa; // Buscar a empresa pelo relacionamento
        $cliente = $proposta->cliente; // Buscar o cliente pelo relacionamento
        $perfis = PerfilChamine::where('empresa_nome', $empresa->nome)->get(); // Buscar perfis pelo nome da empresa

        // Dados para preencher automaticamente
        $dadosAuto = [
            'nomeCliente' => $cliente->nome ?? '',
            'nRelatorio' => $os->id,
            'empresaCliente' => $empresa->nome ?? '',
            'cepEmpresa' => $empresa->endereco ?? '', // Supondo que o endereço contenha o CEP
            'cnpjEmpresa' => $empresa->cnpj ?? '',
            'cidadeCliente' => $cliente->endereco ?? '',
        ];

        // Caminho absoluto para a pasta de templates
        $templatesPath = storage_path('app/templates');
        if (!File::exists($templatesPath)) {
            File::makeDirectory($templatesPath, 0755, true);
        }
        $templates = collect(File::files($templatesPath))
            ->filter(function ($file) {
                return $file->getExtension() === 'docx';
            })
            ->map(function ($file) {
                return $file->getFilenameWithoutExtension();
            })
            ->values();

        return view('os.form', compact('os', 'perfis', 'templates', 'dadosAuto'));
    }
}
