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
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'is_primary' => 'nullable|boolean',
        ]);

        $file = $request->file('file');

        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/uploads', $filename);

        // Se for marcado como principal, zera os outros
        if ($request->boolean('is_primary')) {
            Certificado::where('is_primary', true)->update(['is_primary' => false]);
        }

        Certificado::create([
            'filename'   => $filename,
            'path'       => Storage::url('uploads/' . $filename),
            'type'       => $file->getClientMimeType() === 'application/pdf' ? 'pdf' : 'image',
            'is_primary' => $request->boolean('is_primary'),
        ]);

        return redirect()->route('certificado.index')->with('success', 'Arquivo enviado com sucesso!');
    }

        public function destroy($id)
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

        return back()->with('success', 'Arquivo definido como principal.');
    }
}
