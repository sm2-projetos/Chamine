<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/clientes.css') }}">
</head>
<body>
@include('layouts.sidebar')

<div class="main-content clientes-lista-container">
    <div class="table-lista-clientes">
        <h1>Lista de Clientes</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CNPJ/CPF</th>
                    <th>Endereço</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientes as $cliente)
                    <tr>
                        <td>#{{ str_pad($cliente->id_cliente, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $cliente->nome }}</td>
                        <td>{{ $cliente->cnpj_cpf }}</td>
                        <td>{{ $cliente->endereco }}</td>
                        <td>{{ $cliente->email }}</td>
                        <td>{{ $cliente->telefone }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('clientes.edit', $cliente->id_cliente) }}" class="btn-icon icon-edit" title="Editar">
                                    <i class="fas fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('clientes.destroy', $cliente->id_cliente) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon icon-delete" title="Excluir" onclick="return confirm('Tem certeza que deseja mover este cliente para a lixeira?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($clientes->isEmpty())
            <p class="no-clientes">Nenhum cliente cadastrado.</p>
        @endif
    </div>
</div>
</body>
</html>