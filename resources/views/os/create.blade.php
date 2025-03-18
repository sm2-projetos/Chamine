<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar OS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/propostaComercial.css') }}">
</head>

<body>
    @include('layouts.sidebar')

    <div class="container">
        <h1>Ordem de Serviço - Proposta #{{ $os->proposta->id }}</h1>
        <p><strong>Cliente:</strong> {{ $os->proposta->id_cliente }}</p>
        <p><strong>Empresa:</strong> {{ $os->proposta->id_empresa }}</p>
        <p><strong>Status:</strong> {{ $os->status }}</p>
        <h2>Serviços</h2>
        @php
        $servicosCustos = $os->proposta->servicos_custos;
        @endphp
        @if(isset($servicosCustos['tableData']))
        <ul>
            @foreach($servicosCustos['tableData'] as $servico)
            <li>{{ $servico['descricao'] }} - {{ $servico['total'] }}</li>
            @endforeach
        </ul>
        @endif
        <p><strong>Total Geral:</strong> {{ $servicosCustos['totalGeral'] ?? 'N/A' }}</p>
    </div>
</body>

</html>