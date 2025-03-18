<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Proposta Comercial</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/propostaComercial.css') }}">
</head>

<body>
    @include('layouts.sidebar')
    
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
            <!-- <div class="form-group" id="perfil-group" style="display: none;">
                <label>Perfis Disponíveis</label>
                <select class="form-control" id="availableProfiles">
                    <option value="">Selecione um perfil</option>
                </select>
            </div> -->
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


            <br>
            <br>


            <p>Após realização da análise crítica dos pedidos, propostas e contratos, realizada pelo gerente técnico,
                verificamos que estamos aptos a atender sua solicitação.</p>
            <p>A Chaminé é responsável pela gestão de todas as informações obtidas ou criadas durante a realização de
                atividades de laboratório. Nenhuma informação será colocada em domínio público. Exceto para informações
                que o cliente disponibilize ao público, ou quando acordado entre a chaminé e o cliente, todas as outras
                informações são consideradas propriedade do cliente e são tratadas como confidenciais.</p>
            <br>
            <h3>Declaração de Conformidade:</h3>
            <br>
            <p>A Chaminé possui como regra de decisão, não considerar as incertezas de medição dos ensaios na elaboração
                da Declaração de Conformidade. A Regra de Decisão para a declaração da conformidade dos resultados do
                relatório será aplicada sem levar em conta a incerteza de cada parâmetro avaliado, sendo considerado o
                nível de risco associado à essa regra.</p>
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
                <td><input type="text" value="Chaminé da caldeira a lenha"></td>
                <td><input type="text" value="1" oninput="this.value = this.value.replace(/\D/g, '')"></td>
                <td><input type="text" value="MP / CO / NOx"></td>
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
        <textarea class="form-control" placeholder="Digite suas observações aqui..."></textarea>

        <div class="button-group">
            <button class="btn btn-secondary">Cancelar</button>
            <button class="btn btn-primary">Salvar Proposta</button>
            <button class="btn btn-success">Aprovar e Gerar OS</button>
        </div>
    </div>

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
                                    document.getElementById('clientName').value = data.nome;
                                    document.getElementById('nome-group').style.display = 'block';

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
                    input.oninput = function() { calculateTotal(input); };
                    newCell.appendChild(input);
                }
            });
        }
    </script>
    <style>
        /* Existing styles */
        /* New styles for Equipamento section */
        .equipment-section {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .equipment-image {
            width: 150px;
            height: auto;
            margin-right: 20px;
        }

        .equipment-description {
            width: 100%;
            height: 150px;
            resize: none;
        }

        /* New styles for INFRAESTRUTURA section */
        .infrastructure-description {
            width: 100%;
            height: 100px;
            resize: none;
            margin-bottom: 20px;
        }

        .infrastructure-images {
            display: flex;
            justify-content: space-between;
        }

        .infrastructure-image {
            width: 48%;
            height: auto;
        }

        /* New styles for Serviços e Custos section */
        #servicesTable {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        #servicesTable th, #servicesTable td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #servicesTable th {
            background-color: #f2f2f2;
            text-align: left;
        }

        #servicesTable input[type="number"], #servicesTable input[type="text"] {
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</body>

</html>