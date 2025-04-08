<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Propostas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/propostaComercial.css') }}">
    <link rel="stylesheet" href="{{ asset('css/proposta-lista.css') }}">
</head>

<body>
    @include('layouts.sidebar')

    <div class="main-content">
        <div class="proposta-lista-container">
            <h1>Lista de Propostas</h1>

            <div class="btn-container">
                <a href="{{ route('propostas.create') }}" class="btn-add-proposta">
                    <i class="fas fa-plus"></i> Nova Proposta
                </a>
            </div>

            <div class="proposta-filters">
                <form method="GET" action="{{ route('propostas.index') }}" class="form-group" style="width: 100%;">
                    <label for="status">Filtrar por Status:</label>
                    <select name="status" id="status" class="form-control" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        <option value="Aprovado" {{ request('status') == 'Aprovado' ? 'selected' : '' }}>Aprovado</option>
                        <option value="Cancelado" {{ request('status') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                        <option value="Em Análise" {{ request('status') == 'Em Análise' ? 'selected' : '' }}>Em Análise</option>
                    </select>
                </form>
            </div>

            <div class="table-lista-propostas">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#ID</th>
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
                            <td>
                                <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $proposta->status)) }}">
                                    {{ $proposta->status }}
                                </span>
                            </td>
                            <td>
                                @php
                                $servicosCustos = $proposta->servicos_custos;
                                @endphp
                                @if(isset($servicosCustos['tableData']))
                                <ul>
                                    @foreach($servicosCustos['tableData'] as $servico)
                                    <li>{{ $servico['descricao'] }} - <span class="proposta-valor">R$ {{ $servico['total'] }}</span></li>
                                    @endforeach
                                </ul>
                                @endif
                            </td>
                            <td class="proposta-valor">
                                R$ {{ $servicosCustos['totalGeral'] ?? 'N/A' }}
                            </td>
                            <td class="action-cell">
                                @if($proposta->status == 'Aprovado')
                                <a href="{{ route('os.form', $proposta->os->id) }}" class="btn btn-info">
                                    <i class="fas fa-eye"></i> Ver OS
                                </a>
                                <a href="{{ route('propostas.edit', $proposta->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('propostas.destroy', $proposta->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja cancelar esta proposta?')">
                                        <i class="fas fa-times"></i> Cancelar
                                    </button>
                                </form>
                                
                                @elseif($proposta->status == 'Cancelado')
                                <a href="{{ route('propostas.show', $proposta->id) }}" class="btn btn-info">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                                <a href="{{ route('propostas.edit', $proposta->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('propostas.destroy', $proposta->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta proposta?')">
                                        <i class="fas fa-trash"></i> Excluir
                                    </button>
                                </form>
                                
                                @elseif($proposta->status == 'Em Análise')
                                <form action="{{ route('propostas.update', $proposta->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Aprovado">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check"></i> Aprovar
                                    </button>
                                </form>
                                <form action="{{ route('propostas.update', $proposta->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Cancelado">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-times"></i> Cancelar
                                    </button>
                                </form>
                                <a href="{{ route('propostas.edit', $proposta->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>