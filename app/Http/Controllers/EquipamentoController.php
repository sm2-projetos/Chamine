<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipamento;

class EquipamentoController extends Controller
{
    public function create()
    {
        return view('equipamentos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        if ($request->hasFile('imagem')) {
            $file = $request->file('imagem');
            $filename = uniqid('equipamento_') . '.' . $file->getClientOriginalExtension();

            // Salva em storage/app/public/imagens/equipamento
            $file->storeAs('imagens/equipamento', $filename, 'public');

            $data['imagem'] = "storage/imagens/equipamento/{$filename}";
            $data['filename'] = $filename;
        }

        Equipamento::create($data);

        return redirect()->back()->with('success', 'Equipamento cadastrado com sucesso!');
    }
}
