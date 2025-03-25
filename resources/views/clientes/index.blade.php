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

@include('layouts.sidebar')

<body>
    
    <div class="main-content clientes-page">
        <div class="clientes-container">
            <div class="clientes-wrapper">
                <h1 class="clientes-title">Lista de Clientes</h1>
                @if(session('success'))
                    <div class="clientes-alert clientes-alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <table class="clientes-table">
                    <thead class="clientes-thead">
                        <tr>
                            <th class="clientes-th clientes-th-id">ID</th>
                            <th class="clientes-th clientes-th-nome">Nome</th>
                            <th class="clientes-th clientes-th-documento">CNPJ/CPF</th>
                            <th class="clientes-th clientes-th-endereco">Endereço</th>
                            <th class="clientes-th clientes-th-email">Email</th>
                            <th class="clientes-th clientes-th-telefone">Telefone</th>
                            <th class="clientes-th clientes-th-acoes">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="clientes-tbody">
                        @foreach($clientes as $cliente)
                            <tr class="clientes-tr">
                                <td class="clientes-td clientes-td-id">#{{ str_pad($cliente->id_cliente, 3, '0', STR_PAD_LEFT) }}</td>
                                <td class="clientes-td clientes-td-nome">{{ $cliente->nome }}</td>
                                <td class="clientes-td clientes-td-documento">{{ $cliente->cnpj_cpf }}</td>
                                <td class="clientes-td clientes-td-endereco">{{ $cliente->endereco }}</td>
                                <td class="clientes-td clientes-td-email">{{ $cliente->email }}</td>
                                <td class="clientes-td clientes-td-telefone">{{ $cliente->telefone }}</td>
                                <td class="clientes-td clientes-td-acoes">
                                    <div class="clientes-actions">
                                        <a href="{{ route('clientes.edit', $cliente->id_cliente) }}" class="clientes-btn-icon clientes-icon-edit" title="Editar">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('clientes.destroy', $cliente->id_cliente) }}" method="POST" class="clientes-form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="clientes-btn-icon clientes-icon-delete" title="Excluir" onclick="return confirm('Tem certeza que deseja mover este cliente para a lixeira?')">
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
                    <p class="clientes-empty-message">Nenhum cliente cadastrado.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>