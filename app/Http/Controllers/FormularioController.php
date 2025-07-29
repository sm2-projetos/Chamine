<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use Illuminate\Http\Request;
use \Mpdf\Mpdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FormularioController extends Controller
{
   public function index()
    {
        return view('formulario2');
    }

    public function certificado()
    {
        $certificados = Certificado::all();
        return view('certificado', compact('certificados'));
    }

public function storeCertificado(Request $request)
{
    $request->validate([
        'name'        => 'required|string|max:255',
        'files'       => 'required|array',
        'files.*'     => 'file|mimes:jpg,jpeg,png,pdf|max:40960',
        'is_primary'  => 'nullable|boolean',
    ]);

    $name = $request->input('name');
    $folderPath = "public/uploads/{$name}";

    // Salva todos os arquivos com seus nomes originais
    foreach ($request->file('files') as $file) {
        $file->storeAs($folderPath, $file->getClientOriginalName());
    }

    // Se for marcado como principal, zera os outros
    if ($request->boolean('is_primary')) {
        Certificado::where('is_primary', true)->update(['is_primary' => false]);
    }

    // Cria o conjunto no banco
    Certificado::create([
        'name'       => $name,
        'path'       => Storage::url("uploads/{$name}"),
        'is_primary' => $request->boolean('is_primary'),
    ]);

    return redirect()->route('certificado.index')->with('success', 'Conjunto enviado com sucesso!');
}


        public function destroyCertificado($id)
    {
        $doc = Certificado::findOrFail($id);

        Storage::delete(str_replace('/storage/', 'public/', $doc->path));
        $doc->delete();

        return back()->with('success', 'Arquivo atualizado com sucesso!');
    }

    public function makePrimary($id)
    {
        // Zera todos
        Certificado::where('is_primary', true)->update(['is_primary' => false]);

        // Atualiza o escolhido
        Certificado::where('id', $id)->update(['is_primary' => true]);

        return response()->json([
        'message' => 'Definido como principal',
        'redirect' => route('certificado.index'),
        ]);
    }
}
