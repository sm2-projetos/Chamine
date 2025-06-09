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
                </div>

                <div class="form-group">
                    <label for="nRelatorio">Número do Relatório:</label>
                    <input type="text" name="data[nRelatorio]" id="nRelatorio" class="form-control" value="{{ $dadosAuto['nRelatorio'] ?? '' }}">
                </div>

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
        });
    </script>
</body>

</html>
