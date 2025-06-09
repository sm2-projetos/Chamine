<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Empresas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/empresas.css') }}">
</head>
<body>
    @include('layouts.sidebar')
    <div class="main-content empresas-lista-container">
        <div class="table-lista-empresas">
            <h1>Lista de Empresas</h1>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CNPJ</th>
                        <th>Endereço</th>
                        <th>Contato</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($empresas as $empresa)
                        <tr>
                            <td>{{ $empresa->nome }}</td>
                            <td>{{ $empresa->cnpj }}</td>
                            <td>{{ $empresa->endereco }}</td>
                            <td>{{ $empresa->contato }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('empresas.edit', $empresa->id) }}" class="btn-icon icon-edit" title="Editar">
                                        <i class="fas fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('empresas.destroy', $empresa->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon icon-delete" title="Excluir" onclick="return confirm('Tem certeza que deseja mover esta empresa para a lixeira?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($empresas->isEmpty())
                <p class="no-empresas">Nenhuma empresa cadastrada.</p>
            @endif
        </div>
    </div>
</body>
</html>
