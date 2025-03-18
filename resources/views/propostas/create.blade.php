<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Proposta Comercial</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/propostaComercial.css') }}">
</head>


@include('layouts.sidebar')

<body>


    <form action="{{ route('propostas.store') }}" method="POST" onsubmit="prepararDados()">
        @csrf

        <input type="hidden" id="analiseCriticaInput" name="analise_critica">
        <input type="hidden" id="servicosCustosInput" name="servicos_custos">

        <input type="hidden" id="id_cliente" name="id_cliente" value="">
        <input type="hidden" id="id_empresa" name="id_empresa" value="">
        <input type="hidden" id="status" name="status" value="Em Análise"> <!-- Campo oculto para o status -->
        <!-- <input type="text" name="fonte_emissao" value="Chaminé da caldeira a lenha">
        <input type="text" name="numero_fontes" value="1">
        <input type="text" name="parametros" value="MP/CO/NOX"> -->

        <div class="form-section">
            <h2>Dados do Cliente</h2>
            <div class="form-group">
                <label>CPF</label>
                <input type="text" class="form-control" placeholder="000.000.000-00" id="cpf"
                    onblur="fetchClientData()">
            </div>
            <div class="form-group" id="nome-group" style="display: none;">
                <label>Nome do Cliente</label>
                <input type="text" class="form-control" placeholder="Digite o nome completo" id="clientName" readonly>
            </div>
            <div class="form-group" id="empresa-group" style="display: none;">
                <label>Empresas Vinculadas</label>
                <select class="form-control" id="linkedCompanies">
                    <option value="">Selecione uma empresa</option>
                </select>
                <p id="no-companies-message" style="display: none; color: red;">Nenhuma empresa vinculada a este
                    cliente.</p>
            </div>
            <div class="form-group" id="perfil-group" style="display: none;">
                <label>Perfis Disponíveis</label>
                <select class="form-control" id="availableProfiles">
                    <option value="">Selecione um perfil</option>
                </select>
            </div>
        </div>

        <br>
        <br>

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
                            <li><input type="checkbox"> Cloreto de Hidrogênio (HCl)</li>
                            <li><input type="checkbox"> Fluoreto de Hidrogênio (HF)</li>
                            <li><input type="checkbox"> Dioxinas e Furanos</li>
                            <li><input type="checkbox"> Compostos orgânicos voláteis (VOC)</li>
                            <li><input type="checkbox"> Compostos orgânicos semivoláteis (SVOC)</li>
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

            <h2>ESCOPO DOS TRABALHOS</h2>
            <table>
                <tr>
                    <th>Fonte de Emissão</th>
                    <th>Número de Fontes</th>
                    <th>Parâmetro</th>
                </tr>
                <tr>
                    <td><input type="text" name="fonte_emissao" value="Chaminé da caldeira a lenha"></td>
                    <td><input type="text" name="numero_fontes" value="1"
                            oninput="this.value = this.value.replace(/\D/g, '')"></td>
                    <td><input type="text" name="parametros" value="MP / CO / NOx"></td>
                </tr>
            </table>

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
                        <td><input type="text" class="form-control" value="Determinação de MP / CO / NOX"></td>
                        <td><input type="number" class="form-control" oninput="calculateTotal(this)"></td>
                        <td><input type="number" class="form-control" oninput="calculateTotal(this)"></td>
                        <td><input type="number" class="form-control" oninput="calculateTotal(this)"></td>
                        <td><input type="text" class="form-control" readonly></td>
                    </tr>
                    <tr>
                        <td><input type="text" class="form-control" value="Deslocamento"></td>
                        <td><input type="number" class="form-control" oninput="calculateTotal(this)"></td>
                        <td><input type="number" class="form-control" oninput="calculateTotal(this)"></td>
                        <td><input type="number" class="form-control" oninput="calculateTotal(this)"></td>
                        <td><input type="text" class="form-control" readonly></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align: right;"><strong>Total Geral:</strong></td>
                        <td><input type="text" class="form-control" id="grandTotal" readonly></td>
                    </tr>
                </tfoot>
            </table>
            <button type="button" class="btn btn-secondary" onclick="addRow()">Adicionar Linha</button>
        </div>

        <br>
        <br>

        <h3>Observações:</h3>
        <textarea class="form-control" name="observacoes" placeholder="Digite suas observações aqui..."></textarea>

        <div class="button-group">
            <button class="btn btn-secondary" type="submit" onclick="setStatus('Cancelado')">Cancelar</button>
            <button class="btn btn-primary" type="submit" onclick="setStatus('Em Análise')">Salvar Proposta</button>
            <button class="btn btn-success" type="submit" onclick="setStatus('Aprovado')">Aprovar e Gerar OS</button>
        </div>
    </form>

    <script>

        function setStatusAndSubmit(status) {
            document.getElementById('status').value = status;
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

        function fetchClientData() {
            const cpf = document.getElementById('cpf').value;
            if (cpf) {
                $.ajax({
                    url: '{{ route("clientes.checkCpf") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        cnpj_cpf: cpf
                    },
                    success: function (response) {
                        if (response.exists) {
                            $.ajax({
                                url: '{{ route("clientes.getClientData") }}',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    cnpj_cpf: cpf
                                },
                                success: function (data) {
                                    console.log("Dados retornados:", data);  // Adicione esta linha para ver o retorno no console

                                    document.getElementById('clientName').value = data.nome;
                                    document.getElementById('nome-group').style.display = 'block';

                                    document.querySelector('input[name="id_cliente"]').value = data.id;
                                    // caso "data.id" seja o ID do cliente retornado pela rota

                                    const empresaSelect = document.getElementById('linkedCompanies');
                                    const noCompaniesMessage = document.getElementById('no-companies-message');

                                    empresaSelect.innerHTML = '<option value="">Selecione uma empresa</option>';

                                    if (data.empresas.length > 0) {
                                        data.empresas.forEach(function (empresa) {
                                            const option = document.createElement('option');
                                            option.value = empresa.id;
                                            option.textContent = empresa.nome;
                                            empresaSelect.appendChild(option);
                                        });
                                        empresaSelect.style.display = 'block';
                                        noCompaniesMessage.style.display = 'none';
                                    } else {
                                        empresaSelect.style.display = 'none';
                                        noCompaniesMessage.style.display = 'block';
                                    }

                                    document.getElementById('empresa-group').style.display = 'block';

                                    empresaSelect.addEventListener("change", function () {
                                        const empresaNome = this.options[this.selectedIndex].text; // Pegando o nome da empresa selecionada
                                        const selectedOption = this.options[this.selectedIndex];
                                        document.querySelector('input[name="id_empresa"]').value = selectedOption.value;
                                        if (empresaNome) {
                                            $.ajax({
                                                url: "{{ route('perfis.getProfilesByEmpresa') }}",
                                                method: "POST", // Certifique-se de que o método é POST
                                                data: {
                                                    _token: "{{ csrf_token() }}",
                                                    empresa_nome: empresaNome, // Enviando o nome da empresa

                                                },
                                                success: function (response) {
                                                    console.log("Perfis recebidos:", response.perfis); // Log de depuração

                                                    const perfilSelect = document.getElementById("availableProfiles");
                                                    perfilSelect.innerHTML = '<option value="">Selecione um perfil</option>';

                                                    if (response.perfis.length > 0) {
                                                        response.perfis.forEach(function (perfil) {
                                                            const option = document.createElement("option");
                                                            option.value = perfil.id;
                                                            option.textContent = `${perfil.projeto} / ${perfil.empresa}`;
                                                            perfilSelect.appendChild(option);
                                                        });
                                                        document.getElementById("perfil-group").style.display = "block";
                                                        console.log("Select de perfis atualizado e visível"); // Log de depuração
                                                    } else {
                                                        document.getElementById("perfil-group").style.display = "none";
                                                        console.log("Nenhum perfil encontrado"); // Log de depuração
                                                    }
                                                },
                                                error: function (xhr, status, error) {
                                                    console.error("Erro na requisição AJAX:", error); // Log de depuração
                                                },
                                            });
                                        } else {
                                            document.getElementById("perfil-group").style.display = "none";
                                        }
                                    });

                                }
                            });
                        } else {
                            alert('CPF não encontrado.');
                        }
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

        function addRow() {
            const table = document.getElementById('servicesTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();

            const descriptions = ['Descrição', 'Quantidade de Coleta/ Fonte', 'Quantidade de Fontes', 'Valor Unitário/fonte', 'Total'];
            descriptions.forEach((desc, index) => {
                const newCell = newRow.insertCell(index);
                if (index === 0) {
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.className = 'form-control';
                    newCell.appendChild(input);
                } else if (index === 4) {
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.className = 'form-control';
                    input.readOnly = true;
                    newCell.appendChild(input);
                } else {
                    const input = document.createElement('input');
                    input.type = 'number';
                    input.className = 'form-control';
                    input.oninput = function () { calculateTotal(input); };
                    newCell.appendChild(input);
                }
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
</body>

</html>