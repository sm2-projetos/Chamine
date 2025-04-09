<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário OS</title>

    <!-- Font Awesome (ícones) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/propostaComercial.css') }}">

    <style>
        /* Estilos específicos para o formulário */
        .form-container {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .checkbox-group {
            max-height: 200px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f8f9fa;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 5px;
            border-bottom: 1px solid #ddd;
        }

        .checkbox-item:last-child {
            border-bottom: none;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .perfil-reports-block {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .report-check-group label {
            display: inline-block;
            margin-right: 20px;
        }

        .report-block {
            padding: 15px;
            border: 1px solid #ccc;
            margin: 10px 0;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .report-block h4 {
            margin-bottom: 15px;
            font-size: 18px;
            color: #333;
        }

        .report-block form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .report-block fieldset {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background-color: #f8f8f8;
        }

        .report-block legend {
            font-weight: bold;
            font-size: 16px;
            color: #555;
            padding: 0 10px;
        }

        .reports-forms-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
    </style>

</head>

<body>
    @include('layouts.sidebar')

    <div class="container form-container">
        <h1>Formulário OS - ID: {{ $os->id }}</h1>

        <form action="{{ route('os.update', $os->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Campo Descrição -->
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <input type="text" name="descricao" id="descricao" class="form-control" value="{{ $os->descricao }}">
            </div>

            <!-- Checkboxes de Perfil -->
            <div class="form-group">
                <label>Selecione o(s) Perfil(is):</label>
                <div class="checkbox-group">
                    @foreach($perfis as $perfil)
                        <div class="checkbox-item">
                            <input 
                                type="checkbox" 
                                class="perfil-checkbox" 
                                id="perfil_{{ $perfil->id_perfil }}" 
                                value="{{ $perfil->id_perfil }}"
                                data-perfil-id="{{ $perfil->id_perfil }}"
                            >
                            <label for="perfil_{{ $perfil->id_perfil }}">
                                Perfil {{ $perfil->id_perfil }} - {{ $perfil->empresa_nome }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Container onde surgirão os blocos de relatórios + formulários -->
            <div id="profiles-reports-container"></div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const perfilCheckboxes = document.querySelectorAll('.perfil-checkbox');
            const profilesReportsContainer = document.getElementById('profiles-reports-container');

            perfilCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const perfilId = this.getAttribute('data-perfil-id');
                    if (this.checked) {
                        // Criar bloco de relatórios para este perfil
                        createReportsBlock(perfilId);
                    } else {
                        // Se desmarcar, remover bloco inteiro do perfil
                        removeReportsBlock(perfilId);
                    }
                });
            });

            // Cria um bloco com as 4 opções de relatório para o perfil
            function createReportsBlock(perfilId) {
                // Se já existe, não duplicar
                if (document.getElementById('reports-block-' + perfilId)) {
                    return;
                }

                const block = document.createElement('div');
                block.classList.add('perfil-reports-block');
                block.id = 'reports-block-' + perfilId;

                block.innerHTML = `
                    <h3>Perfil ${perfilId}: Selecione os relatórios</h3>
                    <div class="report-check-group">
                        <label><input type="checkbox" class="relatorio-checkbox" value="analise" data-perfil-id="${perfilId}"> Análise e Amostragem</label>
                        <label><input type="checkbox" class="relatorio-checkbox" value="ruido" data-perfil-id="${perfilId}"> Ruído</label>
                        <label><input type="checkbox" class="relatorio-checkbox" value="vibracao" data-perfil-id="${perfilId}"> Vibração</label>
                        <label><input type="checkbox" class="relatorio-checkbox" value="qualidade_ar" data-perfil-id="${perfilId}"> Qualidade do Ar</label>
                        <label><input type="checkbox" class="relatorio-checkbox" value="relatorio_tecnico" data-perfil-id="${perfilId}"> Relatório Técnico</label>
                    </div>
                    <div class="reports-forms-container" id="reports-forms-${perfilId}"></div>
                `;
                profilesReportsContainer.appendChild(block);

                // Capturar os checkboxes recém-criados e adicionar evento
                const relatorioCheckboxes = block.querySelectorAll('.relatorio-checkbox');
                relatorioCheckboxes.forEach(rcb => {
                    rcb.addEventListener('change', updateReportForm);
                });
            }

            // Remove o bloco de relatórios de um perfil
            function removeReportsBlock(perfilId) {
                const block = document.getElementById('reports-block-' + perfilId);
                if (block) {
                    profilesReportsContainer.removeChild(block);
                }
            }

            // Exibe ou remove o formulário do relatório correspondente
            function updateReportForm() {
                const perfilId = this.getAttribute('data-perfil-id');
                const reportValue = this.value; // "analise", "ruido", "vibracao", "qualidade_ar", etc.

                const formsContainer = document.getElementById('reports-forms-' + perfilId);
                if (!formsContainer) return;

                if (this.checked) {
                    // Criar o form do relatório se não existir
                    const existingForm = document.getElementById(`report-block-${perfilId}-${reportValue}`);
                    if (!existingForm) {
                        const reportBlock = document.createElement('div');
                        reportBlock.classList.add('report-block');
                        reportBlock.id = `report-block-${perfilId}-${reportValue}`;
                        reportBlock.innerHTML = getReportForm(reportValue, perfilId);
                        formsContainer.appendChild(reportBlock);
                    }
                } else {
                    // Se desmarca, remover o formulário
                    const formToRemove = document.getElementById(`report-block-${perfilId}-${reportValue}`);
                    if (formToRemove) {
                        formsContainer.removeChild(formToRemove);
                    }
                }
            }

            // Função para retornar o formulário específico com base no tipo de relatório
            function getReportForm(reportValue, perfilId) {
                switch (reportValue) {
                    case 'analise':
                        return getAnaliseForm(perfilId);
                    case 'ruido':
                        return getRuidoForm(perfilId);
                    case 'vibracao':
                        return getVibracaoForm(perfilId);
                    case 'qualidade_ar':
                        return getQualidadeArForm(perfilId);
                    case 'relatorio_tecnico':
                        return getRelatorioTecnicoForm(perfilId);
                    default:
                        return getDefaultForm(reportValue, perfilId);
                }
            }

            // Formulário específico para "Análise e Amostragem"
            function getAnaliseForm(perfilId) {
                return `
                    <h4>Formulário de Análise e Amostragem</h4>
                    <form>
                        <fieldset>
                            <legend>1. Informações da Amostragem</legend>
                            <div class="form-group">
                                <label for="data-amostragem-${perfilId}">Data da Amostragem:</label>
                                <input type="date" id="data-amostragem-${perfilId}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="local-amostragem-${perfilId}">Local da Amostragem:</label>
                                <input type="text" id="local-amostragem-${perfilId}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="tipo-amostra-${perfilId}">Tipo de Amostra:</label>
                                <input type="text" id="tipo-amostra-${perfilId}" class="form-control">
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>2. Resultados da Análise</legend>
                            <div class="form-group">
                                <label for="parametros-analise-${perfilId}">Parâmetros Analisados:</label>
                                <textarea id="parametros-analise-${perfilId}" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="resultados-analise-${perfilId}">Resultados Obtidos:</label>
                                <textarea id="resultados-analise-${perfilId}" class="form-control" rows="3"></textarea>
                            </div>
                        </fieldset>
                    </form>

                    <div>
                    <p>Olá Mundo </p>
                `;
            }

            // Formulário específico para "Ruído"
            function getRuidoForm(perfilId) {
                return `
                    <h4>Formulário de Ruído</h4>
                    <form>
                        <fieldset>
                            <legend>1. Informações Gerais</legend>
                            <div class="form-group">
                                <label for="data-relatorio-${perfilId}">Data do Relatório:</label>
                                <input type="date" id="data-relatorio-${perfilId}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="local-coleta-${perfilId}">Local da Coleta:</label>
                                <input type="text" id="local-coleta-${perfilId}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="responsavel-tecnico-${perfilId}">Responsável Técnico:</label>
                                <input type="text" id="responsavel-tecnico-${perfilId}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="empresa-responsavel-${perfilId}">Empresa Responsável:</label>
                                <input type="text" id="empresa-responsavel-${perfilId}" class="form-control">
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>2. Condições Climáticas no Momento da Coleta</legend>
                            <div class="form-group">
                                <label for="temperatura-${perfilId}">Temperatura (°C):</label>
                                <input type="number" id="temperatura-${perfilId}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="umidade-${perfilId}">Umidade Relativa (%):</label>
                                <input type="number" id="umidade-${perfilId}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="vento-${perfilId}">Velocidade do Vento (m/s):</label>
                                <input type="number" id="vento-${perfilId}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="pressao-${perfilId}">Pressão Atmosférica (hPa):</label>
                                <input type="number" id="pressao-${perfilId}" class="form-control">
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>3. Parâmetros Analisados</legend>
                            <div class="form-group">
                                <label for="mp-${perfilId}">Material Particulado (MP10, MP2.5):</label>
                                <input type="number" id="mp-${perfilId}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="so2-${perfilId}">Dióxido de Enxofre (SO₂):</label>
                                <input type="number" id="so2-${perfilId}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="co-${perfilId}">Monóxido de Carbono (CO):</label>
                                <input type="number" id="co-${perfilId}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="o3-${perfilId}">Ozônio (O₃):</label>
                                <input type="number" id="o3-${perfilId}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="no2-${perfilId}">Dióxido de Nitrogênio (NO₂):</label>
                                <input type="number" id="no2-${perfilId}" class="form-control">
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>4. Metodologia e Equipamentos</legend>
                            <div class="form-group">
                                <label for="equipamentos-${perfilId}">Equipamentos Utilizados:</label>
                                <input type="text" id="equipamentos-${perfilId}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="normas-${perfilId}">Normas Técnicas Aplicadas:</label>
                                <input type="text" id="normas-${perfilId}" class="form-control">
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>5. Resultados e Comparações</legend>
                            <div class="form-group">
                                <label for="resultados-${perfilId}">Valores Medidos:</label>
                                <textarea id="resultados-${perfilId}" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="comparacao-${perfilId}">Comparação com Padrões:</label>
                                <select id="comparacao-${perfilId}" class="form-control">
                                    <option value="">Selecione uma referência normativa</option>
                                    <option value="norma1">Norma 1</option>
                                    <option value="norma2">Norma 2</option>
                                </select>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>6. Conclusão e Recomendações</legend>
                            <div class="form-group">
                                <label for="analise-${perfilId}">Análise Crítica dos Dados:</label>
                                <textarea id="analise-${perfilId}" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="acoes-${perfilId}">Ações Sugeridas:</label>
                                <textarea id="acoes-${perfilId}" class="form-control" rows="3"></textarea>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>7. Anexos e Evidências</legend>
                            <div class="form-group">
                                <label for="anexos-${perfilId}">Anexar Arquivos:</label>
                                <input type="file" id="anexos-${perfilId}" class="form-control" multiple>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>8. Assinaturas</legend>
                            <div class="form-group">
                                <label for="assinatura-${perfilId}">Assinatura Digital do Responsável Técnico:</label>
                                <input type="text" id="assinatura-${perfilId}" class="form-control" placeholder="Assinatura Digital">
                            </div>
                        </fieldset>
                    </form>
                `;
            }

            // Formulário específico para "Vibração"
            function getVibracaoForm(perfilId) {
                return `
                    <h4>Formulário de Vibração</h4>
                    <form>
                        <fieldset>
                            <legend>1. Informações Gerais</legend>
                            <div class="form-group">
                                <label for="data-vibracao-${perfilId}">Data da Medição:</label>
                                <input type="date" id="data-vibracao-${perfilId}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="local-vibracao-${perfilId}">Local da Medição:</label>
                                <input type="text" id="local-vibracao-${perfilId}" class="form-control">
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>2. Parâmetros Medidos</legend>
                            <div class="form-group">
                                <label for="frequencia-${perfilId}">Frequência (Hz):</label>
                                <input type="number" id="frequencia-${perfilId}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="amplitude-${perfilId}">Amplitude (mm):</label>
                                <input type="number" id="amplitude-${perfilId}" class="form-control">
                            </div>
                        </fieldset>
                    </form>
                `;
            }

            // Formulário específico para "Qualidade do Ar"
            function getQualidadeArForm(perfilId) {
                return `
                    <h4>Formulário de Qualidade do Ar</h4>
                    <form>
                        <fieldset>
                            <legend>1. Informações Gerais</legend>
                            <div class="form-group">
                                <label for="data-ar-${perfilId}">Data da Medição:</label>
                                <input type="date" id="data-ar-${perfilId}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="local-ar-${perfilId}">Local da Medição:</label>
                                <input type="text" id="local-ar-${perfilId}" class="form-control">
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>2. Parâmetros Medidos</legend>
                            <div class="form-group">
                                <label for="co2-${perfilId}">Dióxido de Carbono (CO₂):</label>
                                <input type="number" id="co2-${perfilId}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="pm25-${perfilId}">Material Particulado (PM2.5):</label>
                                <input type="number" id="pm25-${perfilId}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="pm10-${perfilId}">Material Particulado (PM10):</label>
                                <input type="number" id="pm10-${perfilId}" class="form-control">
                            </div>
                        </fieldset>
                    </form>
                `;
            }

            // Formulário específico para "Relatório Técnico"
            function getRelatorioTecnicoForm(perfilId) {
                return `
                    <h4>Relatório Técnico</h4>
                    <form id="relatorioForm-${perfilId}">
                        <!-- Cabeçalho -->
                        <fieldset>
                            <legend>1. Identificação do Relatório</legend>
                            <div class="form-group">
                                <label for="relatorioNum-${perfilId}">RELATÓRIO TÉCNICO Nº:</label>
                                <input type="text" id="relatorioNum-${perfilId}" class="form-control" placeholder="XX/XX">
                            </div>
                            <div class="form-group">
                                <label for="naturezaTrabalho-${perfilId}">NATUREZA DO TRABALHO:</label>
                                <textarea id="naturezaTrabalho-${perfilId}" class="form-control" rows="2">AVALIAÇÃO DAS EMISSÕES ATMOSFÉRICAS ORIUNDAS DA NOME DO PROCESSO</textarea>
                            </div>
                        </fieldset>

                        <!-- Seção Cliente -->
                        <fieldset>
                            <legend>2. Informações do Cliente</legend>
                            <div class="form-group">
                                <label for="cliente-${perfilId}">CLIENTE:</label>
                                <textarea id="cliente-${perfilId}" class="form-control" rows="3">NOME, ENDEREÇO, CNPJ</textarea>
                            </div>
                        </fieldset>

                        <!-- Seção Autor -->
                        <fieldset>
                            <legend>3. Autor do Relatório</legend>
                            <div class="form-group">
                                <label for="autor-${perfilId}">AUTOR:</label>
                                <textarea id="autor-${perfilId}" class="form-control" rows="4">CHAMINÉ SOLUÇÕES EM MONITORAMENTO AMBIENTAL LTDA
CNPJ: 11.407.678/0001-00
INSCRIÇÃO MUNICIPAL: 0251105/001-8</textarea>
                            </div>
                        </fieldset>

                        <!-- Seção Equipe Técnica -->
                        <fieldset>
                            <legend>4. Equipe Técnica</legend>
                            <div class="form-group">
                                <label for="equipeTecnica-${perfilId}">EQUIPE TÉCNICA:</label>
                                <textarea id="equipeTecnica-${perfilId}" class="form-control" rows="3">ARLEY CANTARINO DA SILVA
TÉCNICO 1
TÉCNICO 2</textarea>
                            </div>
                        </fieldset>

                        <!-- Seção Data -->
                        <fieldset>
                            <legend>5. Data da Coleta</legend>
                            <div class="form-group">
                                <label for="dataColeta-${perfilId}">DATA:</label>
                                <input type="date" id="dataColeta-${perfilId}" class="form-control">
                            </div>
                        </fieldset>

                        <!-- Seção Imagens -->
                        <fieldset>
                            <legend>6. Imagens do Processo</legend>
                            <div class="form-group">
                                <label for="imagemChamine-${perfilId}">Imagem da Chaminé:</label>
                                <input type="file" id="imagemChamine-${perfilId}" class="form-control" accept="image/*">
                                <div class="image-preview-container" id="previewChamine-container-${perfilId}" style="display: none; margin-top: 10px;">
                                    <img id="previewChamine-${perfilId}" style="max-width: 100%; border-radius: 4px;">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="imagemEquipamento-${perfilId}">Imagem do Equipamento (CIPA):</label>
                                <input type="file" id="imagemEquipamento-${perfilId}" class="form-control" accept="image/*">
                                <div class="image-preview-container" id="previewEquipamento-container-${perfilId}" style="display: none; margin-top: 10px;">
                                    <img id="previewEquipamento-${perfilId}" style="max-width: 100%; border-radius: 4px;">
                                </div>
                            </div>
                        </fieldset>

                        <!-- Seção Resultados (Tabela Dinâmica) -->
                        <fieldset>
                            <legend>7. Resultados das Amostragens</legend>
                            <div class="form-group">
                                <button type="button" class="btn btn-secondary" onclick="addParametroRow(${perfilId})">+ Adicionar Parâmetro</button>
                                <table class="table" id="tabelaResultados-${perfilId}">
                                    <thead>
                                        <tr>
                                            <th>Parâmetros</th>
                                            <th>1ª Coleta</th>
                                            <th>2ª Coleta</th>
                                            <th>3ª Coleta</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" class="form-control" value="Material Particulado (mg/Nm³)"></td>
                                            <td><input type="number" class="form-control" value="37.7"></td>
                                            <td><input type="number" class="form-control" value="37.3"></td>
                                            <td><input type="number" class="form-control" value="44.3"></td>
                                            <td><button type="button" class="btn btn-danger" onclick="removeParametroRow(this)">Remover</button></td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="form-control" value="Monóxido de Carbono (ppm)"></td>
                                            <td><input type="number" class="form-control" value="8.8"></td>
                                            <td><input type="number" class="form-control" value="6.7"></td>
                                            <td><input type="number" class="form-control" value="5.4"></td>
                                            <td><button type="button" class="btn btn-danger" onclick="removeParametroRow(this)">Remover</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>

                        <!-- Seção Conclusão -->
                        <fieldset>
                            <legend>8. Conclusão</legend>
                            <div class="form-group">
                                <label for="conclusao-${perfilId}">Conclusão da Análise:</label>
                                <textarea id="conclusao-${perfilId}" class="form-control" rows="5">Os resultados estão abaixo dos limites da Resolução CONAMA 316/2002.</textarea>
                            </div>
                        </fieldset>

                        <!-- Seção Anexos -->
                        <fieldset>
                            <legend>9. Anexos</legend>
                            <div class="form-group">
                                <label for="certificados-${perfilId}">Certificados de Calibração:</label>
                                <input type="file" id="certificados-${perfilId}" class="form-control" accept=".pdf,image/*">
                            </div>
                            <div class="form-group">
                                <label for="planilhas-${perfilId}">Planilhas de Campo:</label>
                                <input type="file" id="planilhas-${perfilId}" class="form-control" accept=".pdf,.xlsx,.xls">
                            </div>
                        </fieldset>
                        
                        <div class="form-group mt-4">
                            <button type="button" class="btn btn-primary" onclick="visualizarRelatorio(${perfilId})">Pré-visualizar</button>
                            <button type="button" class="btn btn-success" onclick="gerarPDFRelatorio(${perfilId})">Gerar PDF</button>
                        </div>
                    </form>

                    <!-- Área para exibir a pré-visualização -->
                    <div id="previewRelatorio-${perfilId}" class="preview-container" style="display: none; margin-top: 20px; padding: 15px; background-color: #f8f9fa; border: 1px solid #ddd; border-radius: 4px;"></div>
                `;
            }

            // Formulário genérico para outros relatórios
            function getDefaultForm(reportValue, perfilId) {
                return `
                    <h4>Formulário para ${reportValue}</h4>
                    <form>
                        <div class="form-group">
                            <label for="${reportValue}-input-${perfilId}">Campo para ${reportValue}:</label>
                            <input type="text" id="${reportValue}-input-${perfilId}" class="form-control" placeholder="Digite algo...">
                        </div>
                    </form>
                `;
            }
        });
    </script>

</body>

</html>
