<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>

@include('layouts.sidebar')
<body>
<div class="container">
    <h2>Lista de Ordens de Serviço</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Número do Projeto</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($os as $ordem)
                <tr>
                    <td>{{ $ordem->numero_projeto }}</td>
                    <td>
                        <a href="{{ route('os.showos', $ordem->id) }}">
                            <button type="button" class="btn btn-success">Ver OS</button>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">Nenhuma OS encontrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

</div>
</body>
</html>