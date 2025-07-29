<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Proposta Comercial</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/propostaComercial.css') }}">
    <style>
        /* Ajuste responsivo para o container principal */
        .form-section, .form-container, .obs-container {
            margin-left: 260px; /* Espaço fixo para a sidebar */
            width: calc(100% - 280px); /* Largura ajustada para considerar a margem */
            max-width: none; /* Remove limitação máxima para se ajustar melhor */
            padding: 20px;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        .grupo {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 15px;
        }
        .metodologia {
            margin-top: 5px;
        }

        .grupo-inline {
            display: flex;
            align-items: center;
            gap: 8px; /* espaçamento entre label e input */
            margin-bottom: 10px;
        }

        .grupo-inline label {
            white-space: nowrap;
        }

        /* Media queries para diferentes tamanhos de tela */
        @media (max-width: 1200px) {
            .form-section, .form-container {
                width: calc(100% - 280px);
                padding: 15px;
            }
        }

        @media (max-width: 992px) {
            .form-section, .form-container {
                width: calc(100% - 270px);
                padding: 15px;
            }
        }

        @media (max-width: 768px) {
            .form-section, .form-container {
                margin-left: 0;
                width: 100%;
                padding: 15px;
            }
        }

        /* Ajuste para conteúdo interno do formulário em telas menores */
        @media (max-width: 576px) {
            .form-group {
                margin-bottom: 10px;
            }
            
            .form-control {
                padding: 6px;
                font-size: 14px;
            }
            
            .report-block {
                padding: 10px;
            }
            
            .report-block fieldset {
                padding: 10px;
            }
            
            .checkbox-group {
                max-height: 150px;
            }
            
            .btn {
                padding: 8px 15px;
                font-size: 14px;
            }
        }
    </style>
</head>


@include('layouts.sidebar')

<body>


    <form action="{{ route('propostas.store') }}" method="POST" onsubmit="prepararDados()" enctype="multipart/form-data">
        @csrf

        <input type="hidden" id="analiseCriticaInput" name="analise_critica">
        <input type="hidden" id="servicosCustosInput" name="servicos_custos">

        <input type="hidden" id="id_cliente" name="id_cliente" value="">
        <input type="hidden" id="id_empresa" name="id_empresa" value="">
        <input type="hidden" id="status" name="status" value="Em Análise"> <!-- Campo oculto para o status -->
        <input type="hidden" id="perfil_id" name="perfil_id" value=""> <!-- Campo hidden para armazenar o ID do perfil selecionado -->

        <div class="form-section">
            <div class="form-group">
                <label>Número da Proposta</label>
                <input type="text" class="form-control" placeholder="Digite o número da proposta" name="numero_proposta" id="numero_proposta">
            </div>
            <h2>Dados da Empresa</h2>
            <div class="form-group">
                <label>CNPJ</label>
                <input type="text" class="form-control" placeholder="000.000.000-00" id="cnpj"
                    onblur="fetchEmpresaData()">
            </div>
            <div class="form-group" id="nome-group" style="display: none;">
                <label>Nome da Empresa</label>
                <input type="text" class="form-control" placeholder="Digite o nome completo" id="empresaName" readonly>
            </div>

            {{-- <div class="form-group" id="nome-group" style="display: none;">
                <label>Número do Projeto</label>
                <input type="text" class="form-control" placeholder="Digite o nome completo" id="projetoNumero" readonly>
            </div> --}}
{{-- 
            <div class="form-group" id="perfil-group" style="display: none;">
                <label for="perfil_id">Perfis Disponíveis</label>
                <select class="form-control" id="availableProfiles" name="perfil_id">
                    <option value="">Selecione um perfil</option>
                </select>
            </div> --}}
            
        </div>
        <div class="obs-container">
            <h3>Texto sobre a proposta:</h3>
            <textarea class="form-control" name="propostatxt" maxlength="1000">Vimos pelo presente apresentar nossa proposta técnica e comercial de prestação de serviços de amostragens em efluentes
atmosféricos. Estamos à disposição para maiores esclarecimentos.</textarea>
        </div>
        <div class="obs-container">
            <h3>Apresentação:</h3>
            <textarea class="form-control" name="apresentacao" maxlength="1000">A presente proposta refere-se a trabalho de coleta isocinética e análise dos efluentes gasosos nas fontes de emissão descritas
no escopo e foi elaborado com base nas informações fornecidas pelo cliente.
            </textarea>
        </div>

        <div class="obs-container">
            <h3>Objetivos:</h3>
            <textarea class="form-control" name="objetivo" maxlength="1000">Fornecer as condições técnicas e comerciais para avaliação da concentração de Material Particulado (MP), Óxidos de
Nitrogênio (NOX), Monóxido de carbono (CO) e taxa de emissão dos poluentes, bem como umidade, temperatura e vazão dos
gases das fontes de emissão.
            </textarea>
        </div>

        <div class="form-container">
            <div class="form-header">
                <div>
                    <h2>PROPOSTA DE PRESTAÇÃO DE SERVIÇO</h2>
                </div>
            </div>

            <p>Belo Horizonte, {{ \Carbon\Carbon::now()->locale('pt_BR')->isoFormat('LL') }}.</p>

            <table>
                <tr>
                    <th colspan="4">Análise Crítica dos Pedidos, Propostas e Contratos</th>
                </tr>
                <tr>
                    <td width="40%">O serviço solicitado consta na relação de serviços prestados?</td>
                    <td class="checkboxes">
                        <input type="radio" name="servico_solicitado" value="nao">
                        <span>Não</span>
                    </td>
                    <td class="checkboxes" colspan="2">
                        <input type="radio" name="servico_solicitado" value="sim">
                        <span>Sim</span>
                    </td>
                </tr>
                <tr>
                    <td>O método utilizado supre às solicitações do cliente?</td>
                    <td class="checkboxes">
                        <input type="radio" name="metodo_utilizado" value="nao">
                        <span>Não</span>
                    </td>
                    <td class="checkboxes" colspan="2">
                        <input type="radio" name="metodo_utilizado" value="sim">
                        <span>Sim</span>
                    </td>
                </tr>
                <tr>
                    <td>Possuímos capacidade e os recursos para atender aos requisitos?</td>
                    <td class="checkboxes">
                        <input type="radio" name="capacidade_recursos" value="nao">
                        <span>Não</span>
                    </td>
                    <td class="checkboxes" colspan="2">
                        <input type="radio" name="capacidade_recursos" value="sim">
                        <span>Sim</span>
                    </td>
                </tr>
                <tr>
                    <td>Serão utilizados provedores externos?</td>
                    <td class="checkboxes">
                        <input type="radio" name="provedores_externos" value="nao" onclick="toggleProviders(false)">
                        <span>Não</span>
                    </td>
                    <td class="checkboxes">
                        <input type="radio" name="provedores_externos" value="sim" onclick="toggleProviders(true)">
                        <span>Sim</span>
                    </td>
                    <td colspan="2">
                        <ul class="chemical-list" id="providersList" style="display: none;">
                            <li><input type="checkbox" name="provedores[]" value="Cloreto de Hidrogênio (HCl)"> Cloreto de Hidrogênio (HCl)</li>
                            <li><input type="checkbox" name="provedores[]" value="Fluoreto de Hidrogênio (HF)"> Fluoreto de Hidrogênio (HF)</li>
                            <li><input type="checkbox" name="provedores[]" value="Dioxinas e Furanos"> Dioxinas e Furanos</li>
                            <li><input type="checkbox" name="provedores[]" value="Compostos orgânicos voláteis (VOC)"> Compostos orgânicos voláteis (VOC)</li>
                            <li><input type="checkbox" name="provedores[]" value="Compostos orgânicos semivoláteis (SVOC)"> Compostos orgânicos semivoláteis (SVOC)</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Alteração de proposta de prestação de serviço?</td>
                    <td class="checkboxes">
                        <input type="radio" name="alteracao_proposta" value="nao">
                        <span>Não</span>
                    </td>
                    <td class="checkboxes" colspan="2">
                        <input type="radio" name="alteracao_proposta" value="sim">
                        <span>Sim</span>
                    </td>
                </tr>
            </table>
            <script>
                function toggleProviders(show) {
                    const providersList = document.getElementById('providersList');
                    if (show) {
                        providersList.style.display = 'block';
                    } else {
                        providersList.style.display = 'none';
                    }
                }
            </script>
        </div>

        <br>
        <br>
        <div class="form-container">
            <div class="form-header">
                <div>
                    <h2>Metodologias</h2>
                </div>
            </div>
            <div id="grupos-container"></div>

            <button type="button" class="btn btn-secondary" onclick="adicionarGrupo()">Adicionar Grupo</button>
        </div>
        <br>
        <br>
        <div class="form-container">
            <div class="form-header">
                <div>
                    <h2>Equipamentos</h2>
                </div>
            </div>
            <div class="form-check mb-2">
                <input type="checkbox" class="form-check-input" id="selecionarTodos">
                <label for="selecionarTodos" class="form-check-label">Selecionar Todos</label>
            </div>

            <!-- Lista de equipamentos com checkboxes -->
            @foreach($equipamentos as $equipamento)
                <div class="form-check">
                    <input
                        type="checkbox"
                        name="equipamentos[]"
                        value="{{ $equipamento->id }}"
                        class="form-check-input equipamento-checkbox"
                        id="equipamento-{{ $equipamento->id }}"
                    >
                    <label for="equipamento-{{ $equipamento->id }}" class="form-check-label">
                        {{ $equipamento->nome }}
                    </label>
                </div>
            @endforeach
        </div>

                <div class="form-container">
                    <div class="form-header">
                <div>
                    <h2>Infraestrutura</h2>
                </div>
            </div>
            <div class="form-check mb-2">
                <input type="checkbox" class="form-check-input" id="selecionarTodosInfra">
                <label for="selecionarTodos" class="form-check-label">Selecionar Todos</label>
            </div>

            <!-- Lista de equipamentos com checkboxes -->
            @foreach($infraestruturas as $infraestrutura)
                <div class="form-check">
                    <input
                        type="checkbox"
                        name="infraestruturas[]"
                        value="{{ $infraestrutura->conjunto_id }}"
                        class="form-check-input infraestrutura-checkbox"
                        id="infraestrutura-{{ $infraestrutura->conjunto_id }}"
                    >
                    <label for="infraestrutura-{{ $infraestrutura->conjunto_id }}" class="form-check-label">
                        {{ $infraestrutura->conjunto_nome }}
                    </label>
                </div>
            @endforeach
        </div>
        <div class="form-container">

            <h2>ESCOPO DOS TRABALHOS</h2>
            <table id="trabalhoTable">
                <thead>
                    <tr>
                        <th>Fonte de Emissão</th>
                        <th>Número de Fontes</th>
                        <th>Número de Coleta</th>
                        <th>Parâmetro</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" class="form-control" name="fonte_emissao[0][fonte]" value="Chaminé da caldeira a lenha"></td>
                        <td><input type="number" class="form-control" name="fonte_emissao[0][numero_fontes]" value="1"></td>
                        <td><input type="number" class="form-control" name="fonte_emissao[0][numero_coletas]" value="1"></td>
                        <td><input type="text" class="form-control" name="fonte_emissao[0][parametros]" value="MP / CO / NOx"></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-secondary" onclick="addRowTrabalho()">Adicionar Linha</button>
        </div>
        <br>
        <br>
        <div class="form-container">
            <h2>Serviços e Custos</h2>
            <table id="servicesTable">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Quantidade de Coleta/ Fonte</th>
                        <th>Quantidade de Fontes</th>
                        <th>Valor Unitário/fonte</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td><input type="text" class="form-control" name="servico[0][descricao]" value="Determinação de MP / CO / NOX"></td>
                        <td><input type="number" class="form-control" name="servico[0][coletas_por_fonte]" oninput="calculateTotal(this)"></td>
                        <td><input type="number" class="form-control" name="servico[0][qtd_fontes]" oninput="calculateTotal(this)"></td>
                        <td><input type="number" class="form-control" name="servico[0][valor_por_fonte]" oninput="calculateTotal(this)"></td>
                        <td><input type="text" class="form-control" name="servico[0][total]" readonly></td>
                    </tr>
                    <tr>
                        <td><input type="text" class="form-control" name="servico[1][descricao]" value="Deslocamento"></td>
                        <td><input type="number" class="form-control" name="servico[1][coletas_por_fonte]" oninput="calculateTotal(this)"></td>
                        <td><input type="number" class="form-control" name="servico[1][qtd_fontes]" oninput="calculateTotal(this)"></td>
                        <td><input type="number" class="form-control" name="servico[1][valor_por_fonte]" oninput="calculateTotal(this)"></td>
                        <td><input type="text" class="form-control" name="servico[1][total]" readonly></td>
                    </tr>

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align: right;"><strong>Total Geral:</strong></td>
                        <td><input type="text" class="form-control" id="grandTotal" readonly></td>
                    </tr>
                </tfoot>
            </table>
            <button type="button" class="btn btn-secondary" onclick="addRowServico()">Adicionar Linha</button>
        </div>

        <br>
        <br>
        
        <div class="obs-container">
            <h3>Observações:</h3>
            <textarea class="form-control" name="observacoes" placeholder="Digite suas observações aqui..."></textarea>
        </div>

        <div class="button-group">
            <button class="btn btn-secondary" type="submit" onclick="setStatus('Cancelado')">Cancelar</button>
            <button class="btn btn-primary" type="submit" onclick="setStatus('Em Análise')">Salvar Proposta</button>
            <button class="btn btn-success" type="submit" onclick="setStatus('Aprovado')">Aprovar e Gerar OS</button>
        </div>
    </form>

    <script>

        function setStatusAndSubmit(status) {
            document.getElementById('status').value = status;
            console.log('salada');
            document.querySelector('form').submit();
        }

        function prepararDados() {
            const analiseCriticaJson = getFormData();    // Retorno JS
            const servicosCustosJson = getTableData();   // Retorno JS

            document.getElementById('analiseCriticaInput').value = analiseCriticaJson;
            document.getElementById('servicosCustosInput').value = servicosCustosJson;
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#cpf').mask('000.000.000-00');
        });

        document.getElementById('selecionarTodos').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('.equipamento-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        document.getElementById('selecionarTodosInfra').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('.infraestrutura-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        let grupoIndex = 0;

        function adicionarGrupo() {
            const container = document.getElementById('grupos-container');

            const grupoDiv = document.createElement('div');
            grupoDiv.classList.add('grupo');
            grupoDiv.setAttribute('data-grupo-index', grupoIndex);

            grupoDiv.innerHTML = `
                <div class="grupo-inline">
                    <label>Grupo:</label>
                    <input type="text" class="form-control" name="grupos[${grupoIndex}][nome]" placeholder="Nome do grupo">
                </div>
                <div class="metodologias-container" id="metodologias-${grupoIndex}"></div>
                <button type="button" class="btn btn-secondary" onclick="adicionarMetodologia(${grupoIndex})">Adicionar Metodologia</button>
            `;

            container.appendChild(grupoDiv);
            grupoIndex++;
        }

        function adicionarMetodologia(grupoIndex) {
            const container = document.getElementById(`metodologias-${grupoIndex}`);
            const metodologiaIndex = container.children.length;

            const wrapper = document.createElement('div');
            wrapper.style.display = 'flex';
            wrapper.style.alignItems = 'center';
            wrapper.style.gap = '10px';
            wrapper.style.marginBottom = '8px';

            // Input de nome da metodologia
            const inputNome = document.createElement('input');
            inputNome.type = 'text';
            inputNome.name = `grupos[${grupoIndex}][metodologias][${metodologiaIndex}][nome]`;
            inputNome.placeholder = 'Metodologia';
            inputNome.classList.add('form-control');
            inputNome.style.flex = '1';

            // Hidden para garantir valor 0
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = `grupos[${grupoIndex}][metodologias][${metodologiaIndex}][acreditado]`;
            hidden.value = '0';

            // Checkbox
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.value = '1';
            checkbox.name = `grupos[${grupoIndex}][metodologias][${metodologiaIndex}][acreditado]`;
            checkbox.style.margin = '0 5px 0 0'; // margem direita pequena

            // Label para checkbox
            const label = document.createElement('label');
            label.textContent = 'Acreditado';
            label.style.margin = '0';
            label.style.userSelect = 'none';
            label.style.cursor = 'pointer';

            // Faz label clicar no checkbox
            const checkboxId = `acreditado-${grupoIndex}-${metodologiaIndex}`;
            checkbox.id = checkboxId;
            label.htmlFor = checkboxId;

            wrapper.appendChild(inputNome);
            wrapper.appendChild(hidden);
            wrapper.appendChild(checkbox);
            wrapper.appendChild(label);

            container.appendChild(wrapper);
        }




        function fetchEmpresaData() {
            const cnpj = document.getElementById('cnpj').value;

            if (cnpj) {
                $.ajax({
                    url: '{{ route("empresas.checkcnpj") }}',
                    method: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}',
                        cnpj: cnpj
                    },
                    success: function (data) {
                        console.log("Dados da empresa retornados:", data);  // Log de depuração

                        // Preencher nome da empresa
                        document.getElementById('empresaName').value = data.nome;
                        document.getElementById('nome-group').style.display = 'block';

                        // Preencher campo oculto com ID da empresa
                        document.querySelector('input[name="id_empresa"]').value = data.id;

                        // // Preencher select de perfis
                        // const perfilSelect = document.getElementById("availableProfiles");
                        // perfilSelect.innerHTML = '<option value="">Selecione um perfil</option>';

                        // if (data.perfis && data.perfis.length > 0) {
                        //     data.perfis.forEach(function (perfil) {
                        //         const option = document.createElement("option");
                        //         option.value = perfil.id_perfil;
                        //         option.textContent = `${perfil.projeto} / ${perfil.empresa_nome || ''}`;
                        //         perfilSelect.appendChild(option);
                        //     });
                        //     document.getElementById("perfil-group").style.display = "block";
                        // } else {
                        //     document.getElementById("perfil-group").style.display = "none";
                        // }
                    },
                    error: function (xhr, status, error) {
                        console.error("Erro na requisição AJAX:", error);
                        alert("Erro ao buscar dados da empresa. Verifique o CNPJ e tente novamente.");
                    }
                });
            }
        }


        function calculateTotal(input) {
            const row = input.closest('tr');
            const quantityColeta = row.cells[1].querySelector('input').value;
            const quantityFontes = row.cells[2].querySelector('input').value;
            const valorUnitario = row.cells[3].querySelector('input').value;
            const total = row.cells[4].querySelector('input');

            total.value = (quantityColeta * quantityFontes * valorUnitario).toFixed(2);
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            const table = document.getElementById('servicesTable').getElementsByTagName('tbody')[0];
            let grandTotal = 0;
            for (let row of table.rows) {
                const total = parseFloat(row.cells[4].querySelector('input').value) || 0;
                grandTotal += total;
            }
            document.getElementById('grandTotal').value = grandTotal.toFixed(2);
        }

 function addRowServico() {
    const table = document.getElementById('servicesTable').getElementsByTagName('tbody')[0];
    const rowCount = table.rows.length;
    const newRow = table.insertRow();

    const campos = ['descricao', 'coletas_por_fonte', 'qtd_fontes', 'valor_por_fonte', 'total'];
    campos.forEach((campo, index) => {
        const newCell = newRow.insertCell(index);
        const input = document.createElement('input');
        input.className = 'form-control';

        if (campo === 'total') {
            input.type = 'text';
            input.readOnly = true;
        } else {
            input.type = campo === 'descricao' ? 'text' : 'number';
            input.oninput = function () { calculateTotal(input); };
        }

        input.name = `servico[${rowCount}][${campo}]`;
        newCell.appendChild(input);
    });
}

function addRowTrabalho() {
    const table = document.getElementById('trabalhoTable').getElementsByTagName('tbody')[0];
    const rowCount = table.rows.length;
    const newRow = table.insertRow();

    const campos = ['fonte', 'numero_fontes', 'numero_coletas', 'parametros'];
    campos.forEach((campo, index) => {
        const newCell = newRow.insertCell(index);
        const input = document.createElement('input');
        input.className = 'form-control';

        input.type = (campo === 'numero_fontes' || campo === 'numero_coletas') ? 'number' : 'text';

        input.name = `fonte_emissao[${rowCount}][${campo}]`;
        newCell.appendChild(input);
    });
}
    </script>
    <script>
        function getFormData() {
            const formData = {
                servico_solicitado: document.querySelector('input[name="servico_solicitado"]:checked').value,
                metodo_utilizado: document.querySelector('input[name="metodo_utilizado"]:checked').value,
                capacidade_recursos: document.querySelector('input[name="capacidade_recursos"]:checked').value,
                provedores_externos: document.querySelector('input[name="provedores_externos"]:checked').value,
                alteracao_proposta: document.querySelector('input[name="alteracao_proposta"]:checked').value,
                provedores: []
            };

            if (formData.provedores_externos === 'sim') {
                const providersList = document.querySelectorAll('#providersList input[type="checkbox"]:checked');
                providersList.forEach(provider => {
                    formData.provedores.push(provider.parentElement.textContent.trim());
                });
            }

            const jsonData = JSON.stringify(formData);
            console.log(jsonData);
            return jsonData;
        }
    </script>
    <script>
        function getTableData() {
            const table = document.getElementById('servicesTable').getElementsByTagName('tbody')[0];
            const tableData = [];

            for (let row of table.rows) {
                const rowData = {
                    descricao: row.cells[0].querySelector('input').value,
                    quantidadeColeta: row.cells[1].querySelector('input').value,
                    quantidadeFontes: row.cells[2].querySelector('input').value,
                    valorUnitario: row.cells[3].querySelector('input').value,
                    total: row.cells[4].querySelector('input').value
                };
                tableData.push(rowData);
            }

            const totalGeral = document.getElementById('grandTotal').value;
            const jsonData = JSON.stringify({ tableData, totalGeral });
            console.log(jsonData);
            return jsonData;
        }
    </script>
    <script>
        function setStatus(status) {
            document.getElementById('status').value = status;
        }
    </script>
    <script>
        document.getElementById('availableProfiles').addEventListener('change', function () {
            const selectedPerfilId = this.value; // Obtém o ID do perfil selecionado
            document.getElementById('perfil_id').value = selectedPerfilId; // Atualiza o campo hidden
        });

        function atualizarPerfis(perfis) {
            const perfilSelect = document.getElementById('availableProfiles');
            perfilSelect.innerHTML = '<option value="">Selecione um perfil</option>';

            perfis.forEach(function (perfil) {
                const option = document.createElement('option');
                option.value = perfil.id_perfil; // Usar id_perfil como valor
                option.textContent = `${perfil.projeto} / ${perfil.empresa_nome || ''}`; // Exibir projeto e empresa_nome (se disponível)
                perfilSelect.appendChild(option);
            });

            perfilSelect.addEventListener('change', function () {
                const selectedPerfilId = this.value;
                document.getElementById('perfil_id').value = selectedPerfilId; // Atualiza o campo hidden
            });
        }
    </script>
</body>

</html>