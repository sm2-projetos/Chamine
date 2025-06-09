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

        /* Ajuste responsivo para o container principal */
        .container.form-container {
            margin-left: 260px; /* Espaço fixo para a sidebar */
            width: calc(100% - 280px); /* Largura ajustada para considerar a margem */
            max-width: none; /* Remove limitação máxima para se ajustar melhor */
            padding: 20px;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        /* Media queries para diferentes tamanhos de tela */
        @media (max-width: 1200px) {
            .container.form-container {
                width: calc(100% - 280px);
                padding: 15px;
            }
        }

        @media (max-width: 992px) {
            .container.form-container {
                width: calc(100% - 270px);
                padding: 15px;
            }
        }

        @media (max-width: 768px) {
            .container.form-container {
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

        .template-buttons {
            margin-bottom: 20px;
        }
        .button-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .template-btn {
            padding: 10px 20px;
            border: 2px solid #007bff;
            background-color: white;
            color: #007bff;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .template-btn:hover {
            background-color: #007bff;
            color: white;
        }
        .template-btn.active {
            background-color: #007bff;
            color: white;
        }
        .form-section {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f8f9fa;
        }
        .form-section legend {
            font-weight: bold;
            padding: 0 10px;
            color: #333;
        }
        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
        }
        .image-preview-container {
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    @include('layouts.sidebar')

    <div class="container form-container">
        <h1>Formulário OS - ID: {{ $os->id }}</h1>

        <!-- Botões de seleção de template -->
        <div class="template-buttons mb-4">
            <h3>Selecione o tipo de relatório:</h3>
            <div class="button-group">
                @foreach($templates as $template)
                    <button type="button" 
                            class="btn btn-outline-primary template-btn" 
                            data-template="{{ $template }}"
                            onclick="selectTemplate(this)">
                        {{ str_replace('_', ' ', ucfirst($template)) }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Formulário (inicialmente oculto) -->
        <form id="documentForm" action="{{ route('generate.document') }}" method="POST" enctype="multipart/form-data" style="display: none;">
            @csrf
            <input type="hidden" name="template_name" id="selectedTemplate">
            
            <!-- Informações do Cliente -->
            <fieldset class="form-section">
                <legend>Informações do Cliente</legend>
                <div class="form-group">
                    <label for="nomeCliente">Nome do Cliente:</label>
                    <input type="text" name="data[nomeCliente]" id="nomeCliente" class="form-control" value="{{ $dadosAuto['nomeCliente'] ?? '' }}">
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

                <div class="form-group">
                    <label for="nRelatorio">Número do Relatório:</label>
                    <input type="text" name="data[nRelatorio]" id="nRelatorio" class="form-control" value="{{ $dadosAuto['nRelatorio'] ?? '' }}">
                </div>
            <!-- Container onde surgirão os blocos de relatórios + formulários -->
            <div id="profiles-reports-container"></div>

                <div class="form-group">
                    <label for="nomeDoProcesso">Nome do Processo:</label>
                    <input type="text" name="data[nomeDoProcesso]" id="nomeDoProcesso" class="form-control">
                </div>

                <div class="form-group">
                    <label for="empresaCliente">Empresa do Cliente:</label>
                    <input type="text" name="data[empresaCliente]" id="empresaCliente" class="form-control" value="{{ $dadosAuto['empresaCliente'] ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="cepEmpresa">CEP da Empresa:</label>
                    <input type="text" name="data[cepEmpresa]" id="cepEmpresa" class="form-control" value="{{ $dadosAuto['cepEmpresa'] ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="cnpjEmpresa">CNPJ da Empresa:</label>
                    <input type="text" name="data[cnpjEmpresa]" id="cnpjEmpresa" class="form-control" value="{{ $dadosAuto['cnpjEmpresa'] ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="cidadeCliente">Cidade do Cliente:</label>
                    <input type="text" name="data[cidadeCliente]" id="cidadeCliente" class="form-control" value="{{ $dadosAuto['cidadeCliente'] ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="dataColeta">Data da Coleta:</label>
                    <input type="date" name="data[dataColeta]" id="dataColeta" class="form-control">
                </div>
            </fieldset>

            <!-- Informações Técnicas -->
            <fieldset class="form-section">
                <legend>Informações Técnicas</legend>
                <div class="form-group">
                    <label for="tecnicos">Técnicos Responsáveis:</label>
                    <input type="text" name="data[tecnicos]" id="tecnicos" class="form-control">
                </div>

                <div class="form-group">
                    <label for="textDeObjetivoEspecifico">Objetivo Específico:</label>
                    <textarea name="data[textDeObjetivoEspecifico]" id="textDeObjetivoEspecifico" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="listaMetodologiasEmpregadas">Metodologias Empregadas:</label>
                    <textarea name="data[listaMetodologiasEmpregadas]" id="listaMetodologiasEmpregadas" class="form-control" rows="3"></textarea>
                </div>
            </fieldset>

            <!-- Informações do Processo -->
            <fieldset class="form-section">
                <legend>Informações do Processo</legend>
                <div class="form-group">
                    <label for="tituloTabelaProcessoIndustrial">Título da Tabela do Processo Industrial:</label>
                    <input type="text" name="data[tituloTabelaProcessoIndustrial]" id="tituloTabelaProcessoIndustrial" class="form-control">
                </div>

                <div class="form-group">
                    <label for="textoLegislacaoEmVigor1">Legislação em Vigor (Parte 1):</label>
                    <textarea name="data[textoLegislacaoEmVigor1]" id="textoLegislacaoEmVigor1" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="textoLegislacaoEmVigor2">Legislação em Vigor (Parte 2):</label>
                    <textarea name="data[textoLegislacaoEmVigor2]" id="textoLegislacaoEmVigor2" class="form-control" rows="3"></textarea>
                </div>
            </fieldset>

            <!-- Imagens -->
            <fieldset class="form-section">
                <legend>Imagens do Processo Industrial</legend>
                <div class="image-grid">
                    @for($i = 1; $i <= 3; $i++)
                        <div class="form-group">
                            <label for="imagem{{ $i }}">Imagem {{ $i }} (Processo Industrial):</label>
                            <input type="file" name="imagens[imagem{{ $i }}]" id="imagem{{ $i }}" class="form-control" accept="image/*">
                            <div class="image-preview-container" id="preview{{ $i }}-container" style="display: none; margin-top: 10px;">
                                <img id="preview{{ $i }}" style="max-width: 100%; border-radius: 4px;">
                            </div>
                        </div>
                    @endfor
                </div>
            </fieldset>

            <fieldset class="form-section">
                <legend>Imagens dos Equipamentos Utilizados</legend>
                <div class="image-grid">
                    @for($i = 4; $i <= 5; $i++)
                        <div class="form-group">
                            <label for="imagem{{ $i }}">Imagem {{ $i }} (Equipamentos Utilizados):</label>
                            <input type="file" name="imagens[imagem{{ $i }}]" id="imagem{{ $i }}" class="form-control" accept="image/*">
                            <div class="image-preview-container" id="preview{{ $i }}-container" style="display: none; margin-top: 10px;">
                                <img id="preview{{ $i }}" style="max-width: 100%; border-radius: 4px;">
                            </div>
                        </div>
                    @endfor
                </div>
            </fieldset>

            <fieldset class="form-section">
                <legend>Planilhas de Campo</legend>
                <div class="image-grid">
                    @for($i = 6; $i <= 10; $i++)
                        <div class="form-group">
                            <label for="imagem{{ $i }}">Imagem {{ $i }} (Planilha de Campo):</label>
                            <input type="file" name="imagens[imagem{{ $i }}]" id="imagem{{ $i }}" class="form-control" accept="image/*">
                            <div class="image-preview-container" id="preview{{ $i }}-container" style="display: none; margin-top: 10px;">
                                <img id="preview{{ $i }}" style="max-width: 100%; border-radius: 4px;">
                            </div>
                        </div>
                    @endfor
                </div>
            </fieldset>

            <fieldset class="form-section">
                <legend>Certificados de Calibração</legend>
                <div class="image-grid">
                    @for($i = 11; $i <= 23; $i++)
                        <div class="form-group">
                            <label for="imagem{{ $i }}">Imagem {{ $i }} (Certificado de Calibração):</label>
                            <input type="file" name="imagens[imagem{{ $i }}]" id="imagem{{ $i }}" class="form-control" accept="image/*">
                            <div class="image-preview-container" id="preview{{ $i }}-container" style="display: none; margin-top: 10px;">
                                <img id="preview{{ $i }}" style="max-width: 100%; border-radius: 4px;">
                            </div>
                        </div>
                    @endfor
                </div>
            </fieldset>

            <fieldset class="form-section">
                <legend>Relatório de Análise</legend>
                <div class="image-grid">
                    @for($i = 24; $i <= 25; $i++)
                        <div class="form-group">
                            <label for="imagem{{ $i }}">Imagem {{ $i }} (Relatório de Análise):</label>
                            <input type="file" name="imagens[imagem{{ $i }}]" id="imagem{{ $i }}" class="form-control" accept="image/*">
                            <div class="image-preview-container" id="preview{{ $i }}-container" style="display: none; margin-top: 10px;">
                                <img id="preview{{ $i }}" style="max-width: 100%; border-radius: 4px;">
                            </div>
                        </div>
                    @endfor
                </div>
            </fieldset>

            <fieldset class="form-section">
                <legend>Termo de Responsabilidade</legend>
                <div class="image-grid">
                    <div class="form-group">
                        <label for="imagem26">Imagem 26 (Termo de Responsabilidade):</label>
                        <input type="file" name="imagens[imagem26]" id="imagem26" class="form-control" accept="image/*">
                        <div class="image-preview-container" id="preview26-container" style="display: none; margin-top: 10px;">
                            <img id="preview26" style="max-width: 100%; border-radius: 4px;">
                        </div>
                    </div>
                </div>
            </fieldset>

            <!-- Resultados e Conclusões -->
            <fieldset class="form-section">
                <legend>Resultados e Conclusões</legend>
                <div class="form-group">
                    <label for="tituloTabelaResultados">Título da Tabela de Resultados:</label>
                    <input type="text" name="data[tituloTabelaResultados]" id="tituloTabelaResultados" class="form-control">
                </div>

                <div class="form-group">
                    <label for="textoObsConclusaoMaterialParticulado">Observações e Conclusão - Material Particulado:</label>
                    <textarea name="data[textoObsConclusaoMaterialParticulado]" id="textoObsConclusaoMaterialParticulado" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="textoObsConclusaoMonoxidoCarbono">Observações e Conclusão - Monóxido de Carbono:</label>
                    <textarea name="data[textoObsConclusaoMonoxidoCarbono]" id="textoObsConclusaoMonoxidoCarbono" class="form-control" rows="3"></textarea>
                </div>
            </fieldset>

            <button type="submit" class="btn btn-primary">Gerar Documento</button>
        </form>
    </div>

    <script>
        function selectTemplate(button) {
            // Remove a classe active de todos os botões
            document.querySelectorAll('.template-btn').forEach(btn => {
                btn.classList.remove('active');
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
            
            // Adiciona a classe active ao botão clicado
            button.classList.add('active');
            
            // Define o template selecionado
            document.getElementById('selectedTemplate').value = button.dataset.template;
            
            // Mostra o formulário
            document.getElementById('documentForm').style.display = 'block';
        }

        // Adiciona preview de imagem para todos os campos de imagem
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    const previewId = this.id.replace('imagem', 'preview');
                    const containerId = previewId + '-container';
                    
                    reader.onload = function(e) {
                        const preview = document.getElementById(previewId);
                        const container = document.getElementById(containerId);
                        preview.src = e.target.result;
                        container.style.display = 'block';
                    }
                    
                    reader.readAsDataURL(file);
                }
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
