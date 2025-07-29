<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Proposta de Prestação de Serviço</title>
    <style>
        body {
                font-family: DejaVu Sans, sans-serif;
                font-size: 11px;
                line-height: 1.1;
                margin: 1px;
            }

            .header {
                width: 100%;
                text-align: center;
                margin-bottom: 10px;
            }

            .top-header-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 10px;
            }

            .top-header-table td {
                vertical-align: top;
            }

            .logo {
                max-height: 60px;
            }

            .text-below-logo {
                font-weight: bold;
                text-align: right;
                margin-top: 5px;
            }

            .center-titles {
                text-align: center;
                margin: 5px 0;
            }

                .bottom-row {
                    display: flex;
                    justify-content: space-between;
                    font-size: 11px;
                    margin-top: 10px;
                    width: 100%;
                }

                .bottom-row div {
                    width: 50%;
                }

                .bottom-row div:first-child {
                    text-align: left;
                }

                .bottom-row div:last-child {
                    text-align: right;
                }
        .logo { max-height: 600px; }
        h1, h2, h3 { text-align: center; margin: 10px 0; }
        .section { margin: 1px 0; }
        .info-block { margin-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 1px solid #000; padding: 5px; text-align: left; }
        .page-break { page-break-after: always; }
        .contact-container {
        display: table;
        width: 100%;
        }

        .left-section, .right-section, .middle-section {
        display: table-cell;
        width: 33%;
        vertical-align: top;
        padding-right: 10px;
        }

        .section {
        margin-bottom: 15px;
        line-height: 1.3;
        }
        .sectionC {
        margin-bottom: 1px;
        line-height: 1.3;
        }
        .equipamento-container {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .equipamento-imagem {
            width: 40%;
            max-width: 200px;
            margin-right: 15px;
        }

        .equipamento-texto {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .equipamento-nome {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .equipamento-descricao {
            font-size: 12px;
        }
        .empresa-logo {
            max-width: 120px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    @php use Illuminate\Support\Str; @endphp
    <div class="header">
        <table class="top-header-table" style="width: 100%;">
            <tr>
                <td style="width: 40%; text-align: right;">
                   <img src="{{ public_path('storage/imagens/proposta/logo-20180522144628.png') }}" alt="Logo" class="logo">

                    
                </td>
                <td style="width: 30%;">PROPOSTA DE PRESTAÇÃO DE SERVIÇO</td>
                <td style="width: 20%; text-align: right;">
                    FOR 16 Revisão: 06<br>
                    <strong>Página: 1/5</strong>
                </td>
            </tr>
        </table>

       <table style="width: 100%; font-size: 11px; margin-top: 10px;">
            <tr>
                <td style="text-align: left;">
                    Belo Horizonte, 26 de maio de 2025
                </td>
                <td style="text-align: right;">
                    <strong>NÚMERO DA PROPOSTA:</strong> {{ $proposta->id ?? '0' }}
                </td>
            </tr>
        </table>
    </div>
    <div class="section">
        <table>
            <thead>
                <tr>
                    <th colspan="3" style="text-align: center;">Análise Crítica dos Pedidos, Propostas e Contratos</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>O serviço solicitado consta na relação de serviços prestados?</td>
                    @if($proposta->servico_solicitado == "sim")
                        <td>☐ Não</td>
                        <td>☒ Sim</td>
                    @else
                        <td>☒ Não</td>
                        <td>☐ Sim</td>
                    @endif
                </tr>
                <tr>
                    <td>O método utilizado supre às solicitações do cliente?</td>
                     @if($proposta->metodo_utilizado == "sim")
                        <td>☐ Não</td>
                        <td>☒ Sim</td>
                    @else
                        <td>☒ Não</td>
                        <td>☐ Sim</td>
                    @endif
                </tr>
                <tr>
                    <td>Possuímos capacidade e os recursos para atender aos requisitos?</td>
                     @if($proposta->capacidade_recursos == "sim")
                        <td>☐ Não</td>
                        <td>☒ Sim</td>
                    @else
                        <td>☒ Não</td>
                        <td>☐ Sim</td>
                    @endif
                </tr>
                <tr>
                    <td rowspan="2">Serão utilizados provedores externos?</td>
                     @if($proposta->provedores_externos != "")
                        <td>☐ Não</td>
                        <td>☒ Sim</td>
                    @else
                        <td>☒ Não</td>
                        <td>☐ Sim</td>
                    @endif
                </tr>
                <tr>
                    <td colspan="2">
                        @php $externos = $proposta->provedores_externos; @endphp

                        {!! Str::contains($externos, 'Cloreto de Hidrogênio (HCl)') ? '☒' : '☐' !!} Cloreto de Hidrogênio (HCl)<br>
                        {!! Str::contains($externos, 'Fluoreto de Hidrogênio (HF)') ? '☒' : '☐' !!} Fluoreto de Hidrogênio (HF)<br>
                        {!! Str::contains($externos, 'Dioxinas e Furanos') ? '☒' : '☐' !!} Dioxinas e Furanos<br>
                        {!! Str::contains($externos, 'Compostos orgânicos voláteis (VOC)') ? '☒' : '☐' !!} Compostos orgânicos voláteis (VOC)<br>
                        {!! Str::contains($externos, 'Compostos orgânicos semivoláteis (SVOC)') ? '☒' : '☐' !!} Compostos orgânicos semivoláteis (SVOC)
                    </td>
                </tr>
                <tr>
                    <td>Alteração de proposta de prestação de serviço?</td>
                     @if($proposta->alteracao_proposta == "sim")
                        <td>☐ Não</td>
                        <td>☒ Sim</td>
                    @else
                        <td>☒ Não</td>
                        <td>☐ Sim</td>
                    @endif
                </tr>
            </tbody>
        </table>
    </div>

    <div class="sectionC">
        Após realização da análise crítica dos pedidos, propostas e contratos, realizada pelo gerente técnico, verificamos que estamos aptos a atender sua solicitação.
    </div>

    <div class="sectionC">
        A Chaminé é responsável pela gestão de todas as informações obtidas ou criadas durante a realização de atividades de laboratório. Nenhuma informação será colocada em domínio público. Exceto para informações que o cliente disponibilize ao público, ou quando acordado entre a chaminé e o cliente, todas as outras informações são consideradas propriedade do cliente e são tratadas como confidenciais.
    </div>

    <div class="sectionC">
        <strong>Declaração de Conformidade:</strong><br>
        A Chaminé possui como regra de decisão, não considerar as incertezas de medição dos ensaios na elaboração da Declaração de Conformidade. A Regra de Decisão para a declaração da conformidade dos resultados do relatório será aplicada sem levar em conta a incerteza de cada parâmetro avaliado, sendo considerado o nível de risco associado à essa regra.
    </div>

    <div class="section">
        <strong>CHAMINÉ SOLUÇÕES EM MONITORAMENTO AMBIENTAL LTDA</strong><br>
        Rua João Gualberto do Santos 151, Céu Azul, CEP: 31580-500, Belo Horizonte / MG<br>
        Telefone: +55 31 3031-0406 — E-mail: chaminesolucoes@chaminesolucoes.com.br<br>
        CNPJ: 11.407.678.0001/00 — Isc. Estadual: Isento — Isc Municipal: 251.105/001-8<br>
        Cadastro na FEAM: Nº 546 / 2010 – 3
    </div>
    <div class="contact-container">
        <div class="left-section">
            <div class="sectionC">
            <strong>Contato Técnico:</strong><br>
            Arley Cantarino da Silva<br>
            +55 31 9 8636 2499<br>
            arley@chaminesolucoes.com.br
            </div>
            <div class="section">
            <strong>A/C:</strong> {{$proposta->empresa->nome_contato}}<br>
            Telefone: {{$proposta->empresa->telefone_contato}}<br>
            E-mail: {{$proposta->empresa->email_contato}}
            </div>
        </div>
        <div class="middle-section">
            <img src="{{ public_path('storage/imagens/empresa/empresa-' . $proposta->empresa['id'] . '.png') }}" alt="Empresa" class="empresa-logo">
        </div>
        <div class="right-section">
            <div class="sectionC">
            <strong>Contato Comercial:</strong><br>
            Eduardo Deslandes Aguiar<br>
            +55 31 3031-0406<br>
            comercial@chaminesolucoes.com.br
            </div>
            <div class="section">
            <strong>{{$proposta->empresa->nome ?? ''}}</strong><br>
            CNPJ: {{$proposta->empresa->cnpj  ?? ''}}<br>
            {{$proposta->empresa->endereco  ?? ''}}, <br>
            CEP: {{$proposta->empresa->cep  ?? ''}}<br>
            Telefone: {{$proposta->empresa->telefone  ?? ''}}<br>
            E-mail: {{$proposta->empresa->email  ?? ''}}
            </div>
        </div>
    </div>
    <div class="section">
        {{$proposta->propostatxt}}
    </div>
    {{-- page 1 acima --}}

    <!-- Página 2 -->
    <table class="top-header-table" style="width: 100%;">
            <tr>
                <td style="width: 40%; text-align: right;">
                    <img src="{{ public_path('storage/imagens/proposta/logo-20180522144628.png') }}" alt="Logo" class="logo">
                    
                </td>
                <td style="width: 30%;">PROPOSTA DE PRESTAÇÃO DE SERVIÇO</td>
                <td style="width: 20%; text-align: right;">
                    FOR 16 Revisão: 06<br>
                    <strong>Página: 2/5</strong>
                </td>
            </tr>
        </table>

    <div class="section">
        <strong>1. APRESENTAÇÃO</strong><br>
        {{$proposta->apresentacao}}
    </div>

    <div class="section">
        <strong>2. OBJETIVO</strong><br>
        {{$proposta->objetivo}}
    </div>

    <div class="section">
        <strong>3. METODOLOGIA</strong><br>
        As metodologias empregadas nas coletas e análises estão descritas nas normas, sob os seguintes números e títulos:
        <ul>
        @foreach ($proposta->grupos as $grupo ) 
            <li><strong>{{$grupo->nome}}:</strong>
                <ul>
                    @foreach($grupo->metodologias as $metodologia)
                        <li>
                            {{ $metodologia->nome }} 
                            @if($metodologia->acreditado)
                                <img src="{{ public_path('storage/imagens/proposta/creditado.jpg') }}" alt="Creditado" style="margin-top: 2px; vertical-align: middle; height: 1.2em;">
                            @else
                                *
                            @endif
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
        </ul>
        <p><em>Legenda: <img src="{{ public_path('storage/imagens/proposta/creditado.jpg') }}" alt="Creditado" class="creditado">
        Serviços acreditados, somente para esses serão emitidos relatórios com o símbolo da acreditação. 
        <br>* Serviços não acreditados.</em></p>
    </div>

    <div class="page-break"></div>
{{-- pagina 2 acima --}}
<!-- Página 3 -->
<table class="top-header-table" style="width: 100%;">
            <tr>
                <td style="width: 40%; text-align: right;">
                    <img src="{{ public_path('storage/imagens/proposta/logo-20180522144628.png') }}" alt="Logo" class="logo">
                    
                </td>
                <td style="width: 30%;">PROPOSTA DE PRESTAÇÃO DE SERVIÇO</td>
                <td style="width: 20%; text-align: right;">
                    FOR 16 Revisão: 06<br>
                    <strong>Página: 3/5</strong>
                </td>
            </tr>
        </table>

<div class="section">
    <strong>4. ESCOPO DOS TRABALHOS</strong><br><br>
    <table>
        <thead>
            <tr>
                <th>Fonte de emissão</th>
                <th>Número de Chaminé</th>
                <th>Parâmetro</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proposta->fontesEmissao as $emissao )
                <tr>
                    <td>{{$emissao->fonte}}</td>
                    <td>{{$emissao->numero_de_fontes}}</td>
                    <td>{{$emissao->parametros}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="section">
    <strong>5. EQUIPAMENTO</strong><br><br>

    @foreach ($proposta->equipamentos_detalhes as $equipamento)
     @if(file_exists(public_path('storage/imagens/equipamento/' . $equipamento['filename'])) && $equipamento['filename'] != '')
                   
        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td style="width: 40%;">
                    {{-- @php
                    $path = storage_path('app/public/imagens/equipamento/' . $equipamento['filename']);

                    // Converter para caminho URI compatível:
                    $path = str_replace('\\', '/', $path); // barras para frente
                    $path = 'file:///' . $path;
                    @endphp --}}
                    {{-- <img src="{{ public_path('storage/imagens/equipamento/' . $equipamento['filename']) }}" alt="Equipamento" style="width: 100%; max-width: 200px;"> --}}
                     <img src="{{ public_path('storage/imagens/equipamento/' . $equipamento['filename']) }}" alt="Equipamento" style="width: 100%; max-width: 200px;">
                   
                        {{-- <img src="{{ $path }}" style="max-width:200px;" />
                        <h2>{{$equipamento['filename']}}</h2>
                        <h2>{{$path}}</h2> --}}
                        {{-- <img src="{{ public_path('storage/imagens/equipamento/' . $equipamento['filename']) }}" alt="Equipamento" style="width: 100%; max-width: 200px;"> --}}
                    
                </td>
                <td style="vertical-align: top; padding-left: 10px;">
                    <p style="font-weight: bold; margin: 0;">{{ $equipamento['nome'] }}</p>
                    <p style="margin-top: 5px;">{{ $equipamento['descricao'] }}</p>
                </td>
            </tr>
        </table>
        @else
                        <p>Imagem não encontrada: {{ $equipamento['filename'] }}</p>
                    @endif
    @endforeach
</div>

<div class="section">
    <strong>5. INFRAESTRUTURA</strong><br><br>

    @foreach (collect($proposta->infraestruturas_detalhes)->sortBy('ordem') as $infraestrutura_conjuntos)
        @foreach ($infraestrutura_conjuntos as $infraestrutura)
            @if ($infraestrutura['tipo'] === 'imagem')
                            <img src="{{ public_path('storage/' . $infraestrutura['conteudo']) }}" alt="Infraestrutura Imagem" style="width: 100%; max-width: 200px;">
            @elseif ($infraestrutura['tipo'] === 'texto')
                <p style="margin-bottom: 20px;">{!! nl2br(e($infraestrutura['conteudo'])) !!}</p>
            @endif
                
        @endforeach
    @endforeach

</div>

{{-- <div class="section">
    <strong>6. INFRAESTRUTURA</strong><br><br>
    <strong>6.1 Condições para amostragem</strong><br>
    A chaminé deverá conter um diâmetro interno maior que trinta centímetros, possuir dois furos de quatro polegadas um a noventa graus do outro, possuir um trecho reto de no mínimo duas vezes o diâmetro antes dos furos e meio diâmetro depois dos furos conforme figura ilustrativa.
   <table width="100%" style="margin-top: 10px;">
        <tr>
            <td style="width: 50%; text-align: center;">
                <img src="{{ public_path('storage/imagens/proposta/infrae.jpg') }}" alt="Infra Esquerda" style="max-width: 100%; height: auto;">
            </td>
            <td style="width: 50%; text-align: center;">
                <img src="{{ public_path('storage/imagens/proposta/infrad.jpg') }}" alt="Infra Direita" style="max-width: 100%; height: auto;">
            </td>
        </tr>
    </table>

</div> --}}

<div class="section">
    <strong>7. RESPONSABILIDADE</strong><br><br>
    <strong>7.1 - CONTRATANTE</strong>
    <ul>
        <li>Fornecimento de croqui do empreendimento indicando os pontos de amostragem</li>
        <li>Infraestrutura dos pontos de amostragem</li>
    </ul>
    <strong>7.2 - CONTRATADA</strong>
    <ul>
        <li>Despesas com hospedagem e alimentação</li>
        <li>Emissão de relatório técnico em duas vias</li>
        <li>Impostos referentes aos serviços realizados</li>
    </ul>
</div>
  

<div class="page-break"></div>    
{{-- Pagina 4 --}}
<table class="top-header-table" style="width: 100%;">
            <tr>
                <td style="width: 40%; text-align: right;">
                    <img src="{{ public_path('storage/imagens/proposta/logo-20180522144628.png') }}" alt="Logo" class="logo">
                    
                </td>
                <td style="width: 30%;">PROPOSTA DE PRESTAÇÃO DE SERVIÇO</td>
                <td style="width: 20%; text-align: right;">
                    FOR 16 Revisão: 06<br>
                    <strong>Página: 4/5</strong>
                </td>
            </tr>
        </table>
<div class="section">
    <strong>8. PRAZO PARA REALIZAÇÃO DOS SERVIÇOS</strong><br><br>
    <strong>8.1 Início</strong><br>
    Após emissão do Aceite de Propostas de Prestação de Serviços em anexo, com a data combinada entre as partes, para que a infraestrutura para a amostragem descrita no item 06 esteja pronta de forma que a equipe ao chegar ao local possa iniciar imediatamente o trabalho.<br><br>

    <strong>8.2 Execução</strong><br>
    Estima-se necessitar de 01 (um) dia por fonte para execução dos trabalhos de campo, no horário diurno, de acordo com a programação de produção da empresa.<br><br>

    <strong>8.3 Finalização</strong><br>
    O relatório técnico será entregue em até 07 dias úteis após o encerramento dos trabalhos de campo e retorno da equipe.
</div>

<div class="section">
    <strong>9. PREÇO</strong><br><br>
    O valor total dos serviços é de R$ {{$proposta->soma_total_servicos}},00 ({{$proposta->valor_extenso}} reais), conforme tabela abaixo:

    <table>
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Quantidade de coleta/fonte</th>
                <th>Quantidade de fontes</th>
                <th>Valor Unitário/fonte</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
             @foreach ($proposta->servicosCustos as $custos )
                <tr>
                    <td>{{$custos->descricao}}</td>
                    <td>{{$custos->coletas_por_fontes}}</td>
                    <td>{{$custos->qtd_fontes}}</td>
                    <td>{{$custos->valor_por_fonte}}</td>
                    <td>{{$custos->total}}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4">Desconto</td>
                <td>R$ 0,00(fixo)</td>
            </tr>
            <tr>
                <td colspan="4"><strong>Total</strong></td>
                <td><strong>R$ {{$proposta->soma_total_servicos}},00</strong></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="section">
    <strong>9.1 Condições de Pagamento</strong><br>
    O pagamento deverá ser realizado em sete dias após a realização do serviço.
</div>

<div class="section">
    <strong>10. RELATÓRIO</strong><br>
    O relatório apresentará os seguintes conteúdos:<br>
    • Objetivo • Gráficos comparativos • Planilha de campo • ART<br>
    • Tabela de resultados • Conclusão • Certificado de calibração
</div>

<div class="section">
    <strong>11. VALIDADE</strong><br>
    Esta proposta tem validade de 30 (trinta) dias.
</div>

<div class="section">
    <strong>12. ANEXO</strong><br>
    Anexo I - Aceite de Propostas de Prestação de Serviços
</div>

<div class="page-break"></div>

<!-- Página 5 -->
<table class="top-header-table" style="width: 100%;">
            <tr>
                <td style="width: 40%; text-align: right;">
                    <img src="{{ public_path('storage/imagens/proposta/logo-20180522144628.png') }}" alt="Logo" class="logo">  
                </td>
                <td style="width: 30%;">PROPOSTA DE PRESTAÇÃO DE SERVIÇO</td>
                <td style="width: 20%; text-align: right;">
                    FOR 16 Revisão: 06<br>
                    <strong>Página: 5/5</strong>
                </td>
            </tr>
        </table>

<div class="section">
    <strong>AUTORIZAÇÃO DE SERVIÇOS</strong><br><br>
    Nº da Proposta enviada: _______________________________________<br><br>
    Enviar autorização de serviços para o e-mail: <strong>chaminesolucoes@chaminesolucoes.com.br</strong><br><br>
    <strong>Dados Cadastrais:</strong><br>
    Chaminé Soluções em Monitoramento Ambiental Ltda<br>
    Rua João Gualberto dos Santos 151, Céu Azul, CEP: 31748-492, Belo Horizonte / MG<br>
    CNPJ: 11.407.678/0001-00 — Inscrição Estadual: Isento
</div>

<div class="section">
    <strong>Fatura ou cobrança deve ser emitida para</strong><br>
    Razão Social: ___________________________________________<br>
    Endereço: ______________________________________________<br>
    Bairro: _________________________________________________<br>
    Cidade: ____________________ Estado: ________ CEP: ___________<br>
    CNPJ/CPF: _______________________ IE: ___________________<br>
    Fone: _____________________ Fax: _______________________<br>
    E-mail: _________________________________________________<br>
    Nome Completo de quem receberá a cobrança/fatura: __________________________
</div>

<div class="section">
    <strong>Relatório deve ser emitido para</strong><br>
    Razão Social: ___________________________________________<br>
    Endereço: ______________________________________________<br>
    Bairro: _________________________________________________<br>
    Cidade: ____________________ Estado: ________ CEP: ___________<br>
    CNPJ/CPF: _______________________ IE: ___________________<br>
    Nome Completo de quem receberá o relatório: __________________________<br>
    Departamento: ___________________________________________<br>
    Nome Completo do contato técnico: _________________________<br>
    Departamento: ___________________________________________<br>
    Fone: ___________________________________________
</div>

<div class="section">
    <strong>Autorizo a realização de todos os serviços da proposta em referência</strong><br>
    (     ) SIM  (     ) NÃO<br><br>
    Observações: ___________________________________________________________<br><br><br>

    ___/___/______<br><br>
    ___________________________________________<br>
    ASSINATURA<br><br>
    ___________________________________________<br>
    CARIMBO
</div>

</body>
</html>
