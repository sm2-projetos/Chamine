<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório OS</title>
    <style>
        /* Adicione seus estilos aqui */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px; /* Diminuir o tamanho da fonte */
        }
        th, td {
            border: 1px solid #000;
            padding: 4px; /* Diminuir o padding */
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Relatório OS - Perfil ID: {{ $data['perfilId'] }}</h1>
    <p>Projeto: {{ $data['perfil']->projeto }}</p>
    <p>Equipe: {{ $data['perfil']->equipe }}</p>
    <!-- Adicione mais campos conforme necessário -->

    <h2>Valores das Coletas</h2>
    <table>
        <thead>
            <tr>
                <th>Parâmetros</th>
                <th>Unidades</th>
                <th>1° Coleta</th>
                <th>2° Coleta</th>
                <th>3° Coleta</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['valoresColetas'] as $valorColeta)
                <tr>
                    <td>{{ $valorColeta->nome_parametro }}</td>
                    <td>{{ $valorColeta->unidade }}</td>
                    <td>{{ $valorColeta->numero_coleta == 1 ? $valorColeta->valor : '' }}</td>
                    <td>{{ $valorColeta->numero_coleta == 2 ? $valorColeta->valor : '' }}</td>
                    <td>{{ $valorColeta->numero_coleta == 3 ? $valorColeta->valor : '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>