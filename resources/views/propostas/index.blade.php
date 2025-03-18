<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Propostas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/propostaComercial.css') }}">
</head>

<body>
    @include('layouts.sidebar')

    <div class="container">
        <h1>Lista de Propostas</h1>

        <form method="GET" action="{{ route('propostas.index') }}">
            <div class="form-group">
                <label for="status">Filtrar por Status:</label>
                <select name="status" id="status" class="form-control" onchange="this.form.submit()">
                    <option value="">Todos</option>
                    <option value="Aprovado" {{ request('status') == 'Aprovado' ? 'selected' : '' }}>Aprovado</option>
                    <option value="Cancelado" {{ request('status') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                    <option value="Em Análise" {{ request('status') == 'Em Análise' ? 'selected' : '' }}>Em Análise</option>
                </select>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Empresa</th>
                    <th>Status</th>
                    <th>Serviços</th>
                    <th>Total Geral</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($propostas as $proposta)
                <tr>
                    <td>{{ $proposta->id }}</td>
                    <td>{{ $proposta->id_cliente }}</td>
                    <td>{{ $proposta->id_empresa }}</td>
                    <td>{{ $proposta->status }}</td>
                    <td>
                        @php
                        $servicosCustos = $proposta->servicos_custos;
                        @endphp
                        @if(isset($servicosCustos['tableData']))
                        <ul>
                            @foreach($servicosCustos['tableData'] as $servico)
                            <li>{{ $servico['descricao'] }} - {{ $servico['total'] }}</li>
                            @endforeach
                        </ul>
                        @endif
                    </td>
                    <td>{{ $servicosCustos['totalGeral'] ?? 'N/A' }}</td>
                    <td>
                        @if($proposta->status == 'Aprovado')
                        <a href="{{ route('os.form', $proposta->os->id) }}" class="btn btn-info">Visualizar OS</a>
                        <a href="{{ route('propostas.edit', $proposta->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('propostas.destroy', $proposta->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Cancelar</button>
                        </form>
                        @elseif($proposta->status == 'Cancelado')
                        <a href="{{ route('propostas.show', $proposta->id) }}" class="btn btn-info">Ver</a>
                        <a href="{{ route('propostas.edit', $proposta->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('propostas.destroy', $proposta->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                        @elseif($proposta->status == 'Em Análise')
                        <form action="{{ route('propostas.update', $proposta->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="Aprovado">
                            <button type="submit" class="btn btn-success">Aprovar</button>
                        </form>
                        <form action="{{ route('propostas.update', $proposta->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="Cancelado">
                            <button type="submit" class="btn btn-danger">Cancelar</button>
                        </form>
                        <a href="{{ route('propostas.edit', $proposta->id) }}" class="btn btn-warning">Editar</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>