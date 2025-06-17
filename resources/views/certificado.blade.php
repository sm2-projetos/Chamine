<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

@include('layouts.sidebar')
<h2>Upload de Arquivo</h2>

<form action="{{ route('certificado.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="file" name="file" accept=".jpg,.jpeg,.png,.pdf" required><br><br>

    <label>
        <input type="checkbox" name="is_primary" value="1">
        Marcar como principal
    </label>

    <br><br>
    <button type="submit">Enviar</button>
</form>

<script>
document.querySelector('input[name="files[]"]').addEventListener('change', function(e) {
    const select = document.querySelector('select[name="primary_file_index"]');
    select.innerHTML = '<option value="">-- Nenhum --</option>';

    for (let i = 0; i < e.target.files.length; i++) {
        const option = document.createElement('option');
        option.value = i;
        option.text = e.target.files[i].name;
        select.appendChild(option);
    }
});
</script>


<hr>

<h2>Documentos Salvos</h2>

@if($certificados->count())
    <ul>
        @foreach($certificados as $doc)
            <li>
                @if($doc->type === 'image')
                    <img src="{{ $doc->path }}" alt="{{ $doc->filename }}" width="100">
                @else
                    <a href="{{ $doc->path }}" target="_blank">📄 {{ $doc->filename }}</a>
                @endif

                @if($doc->is_primary)
                    <strong> (Principal) </strong>
                @else
                    <form action="{{ route('certificado.makePrimary', $doc->id) }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit">Tornar Principal</button>
                    </form>
                @endif

                <form action="{{ route('certificado.destroy', $doc->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Excluir</button>
                </form>
            </li>
        @endforeach
    </ul>
@else
    <p>Nenhum documento enviado ainda.</p>
@endif
