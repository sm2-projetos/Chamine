<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Ordem de Serviço Interna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .header-table, .main-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td, .main-table td, .main-table th {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: middle;
            text-align: left;
        }
        .nowrap{
            white-space: nowrap;
            overflow-x: auto
        }
        .main-table th {
            background-color: #d9d9d9;
            font-weight: bold;
            text-align: center;
            
        }
        .logo {
            height: 50px;
        }
        .section-title {
            background-color: #d9d9d9;
            font-weight: bold;
            text-align: center;
            border: 1px solid #000;
            padding: 4px;
        }
        .observacoes {
            font-size: 10px;
            padding: 10px;
        }
        .no-border td {
            border: none !important;
        }
        .align-center {
            text-align: center;
        }
        .gray {
            background-color: #d9d9d9;
        }
    </style>
</head>
<body>

<table class="header-table">
    <tr>
        <td style="width: 20%;">
            <img src="{{ public_path('storage/imagens/proposta/logo-20180522144628.png') }}" alt="Logo" class="logo">
        </td>
        <td class="align-center" style="font-size:14px; font-weight:bold;">
            ORDEM DE SERVIÇO INTERNA
        </td>
        <td style="width: 20%; font-size:11px; text-align:right;">
            FOR 18<br>
            Revisão: 05<br>
            Página: 1/1
        </td>
    </tr>
</table>

<table class="main-table nowrap">
    <tr>
        <th>PROJETO N°</th>
        <td>{{ $ordem->numero_projeto }}</td>

        <th>RELATÓRIO DE ANÁLISE N°</th>
        <td>{{ $ordem->numero_relatorio }}</td>
    </tr>
    <tr>
        <th>PROPOSTA</th>
        <td>{{ $ordem->proposta->numero_proposta ?? 'NA' }}</td>

        <th>PLANO DE AMOSTRAGEM N°</th>
        <td>{{ $ordem->numero_plano }}</td>
    </tr>
    <tr>
        <th>SERVIÇO</th>
        <td>{{ $ordem->servico }}</td>

        <th></th>
        <td></td>
    </tr>
</table>

<div class="section-title"></div>

<table class="main-table">
    <tr>
        <td colspan="8"><strong>Objetivo(s):</strong> {{$ordem->proposta->objetivo}}</td>
    </tr>
</table>

<div class="section-title">CRONOGRAMA DE REALIZAÇÃO DA AMOSTRAGEM</div>

<table class="main-table">
    <tr>
        <th>EQUIPE</th>
        <td>SÉRGIO SOUZA</td>
        <th>EMPRESA</th>
        <td colspan="5">{{$ordem->proposta->empresa->nome}}</td>
    </tr>
    <tr>
        <th>ENDEREÇO</th>
        <td colspan="4">{{$ordem->proposta->empresa->endereco}}</td>
        <th>DATA DA AMOSTRAGEM</th>
        <td colspan="2">{{$ordem->data_amostragem}}</td>
    </tr>
    <tr>
        <th>CONTATO</th>
        <td colspan="7">{{$ordem->proposta->empresa->telefone}}</td>
    </tr>
</table>

<div class="section-title">ESCOPO DO TRABALHO</div>

<table class="main-table">
    <tr>
        <td>Fonte de emissão</td>
        <td>Número de Fontes</td>
        <td>Número de coletas</td>
        <td>Parâmetro(s)</td>
    </tr>
    @foreach ($ordem->proposta->fontesEmissao as $emissao )
        <tr>
            <td>{{$emissao->fonte}}</td>
            <td class="align-center">{{$emissao->numero_de_fontes}}</td>
            <td class="align-center">{{$emissao->numero_de_coletas}}</td>
            <td class="align-center">{{$emissao->parametros}}</td>
        </tr>
     @endforeach
</table>

<div class="section-title">METODOLOGIA E DOCUMENTOS NECESSÁRIOS</div>

<table class="main-table">
    <tr>
        <td>P 01 - Amostragem em Chaminé</td>
        <td>ABNT NBR 11967:1989</td>
    </tr>
    <tr>
        <td>P 16 - Análise dos gases de combustão através do aparelho Orsat</td>
        <td>CETESB L9.222:1992</td>
    </tr>
    <tr>
        <td>P 18 - Análise dos gases de combustão através do aparelho CHEMIST 500</td>
        <td>CETESB L9.210:1990</td>
    </tr>
    <tr>
        <td>FOR 18 Ordem de Serviço Interna</td>
        <td>CETESB L9.225:1995</td>
    </tr>
    <tr>
        <td>FOR 28 Planilha de campo amostragem em chaminé</td>
        <td>CETESB L9.221:1990</td>
    </tr>
    <tr>
        <td>FOR 29 Checklist</td>
        <td>CETESB L9.224:1993</td>
    </tr>
    <tr>
        <td>FOR 35 Cadeia de custódia</td>
        <td>CETESB L9.223: 1992</td>
    </tr>
    <tr>
        <td>ABNT NBR 11966:1989</td>
        <td>USEPA Method CTM-030:1997</td>
    </tr>
    <tr>
        <td>ABNT NBR 12019: 1990</td>
        <td>USEPA Method 3A: 2017</td>
    </tr>
</table>

<div class="section-title">EQUIPAMENTOS NECESSÁRIOS PARA REALIZAÇÃO DAS ATIVIDADES</div>

<table class="main-table">
    @php
        $count = 0;
    @endphp

    @foreach ($ordem->proposta->equipamentos_detalhes as $equipamento)
        @if ($count % 3 === 0)
            <tr>
        @endif

        <td>{{ $equipamento['nome'] }}</td>

        @php $count++; @endphp

        @if ($count % 3 === 0)
            </tr>
        @endif
    @endforeach

    {{-- Fecha a última linha se a quantidade não for múltiplo de 3 --}}
    @if ($count % 3 !== 0)
        @for ($i = 0; $i < 3 - ($count % 3); $i++)
            <td></td>
        @endfor
        </tr>
    @endif
    {{-- <tr>
        <td>Coletor Isocinético de Poluentes Atmosféricos - CIPA</td>
        <td>Barômetro</td>
        <td>Balança Eletrônica</td>
    </tr>
    <tr>
        <td>Analisador de gases</td>
        <td>Transformador 110/220</td>
        <td>Filtros</td>
    </tr>
    <tr>
        <td>Notebook</td>
        <td>Pisseta</td>
        <td>Nível Goniométrico</td>
    </tr>
    <tr>
        <td>EPI</td>
        <td>Proveta</td>
        <td>Corda</td>
    </tr>
    <tr>
        <td>Água deionizada</td>
        <td>Frascos de 500ml</td>
        <td>Escada</td>
    </tr>
    <tr>
        <td></td>
        <td>Silica gel</td>
        <td>Caixa térmica / Caixa de ferramentas</td>
    </tr> --}}
</table>

<div class="section-title">OBSERVAÇÕES</div>

<table class="main-table">
    <tr>
        <td>{{$ordem->observacao}}
        </td>
    </tr>
</table>

<br>

<table class="main-table">
    <tr>
        <td class="align-center" style="font-size:14px; font-weight:bold;">Chaminé Soluções em Monitoramento Ambiental</td>
    </tr>
</table>

</body>
</html>
