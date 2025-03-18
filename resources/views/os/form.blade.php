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
            /* Altura máxima da lista com rolagem */
            overflow-y: auto;
            /* Adiciona rolagem vertical */
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

        .checkbox-item input[type="checkbox"] {
            margin-right: 5px;
        }

        .checkbox-item label {
            margin: 0;
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

        .inline-group {
            display: flex;
            gap: 10px;
        }

        .inline-group .form-group {
            flex: 1;
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

            <!-- Alternativa com Checkboxes (Descomente esta parte para usar checkboxes) -->
            <div class="form-group">
                <label>Perfil:</label>
                <div class="checkbox-group">
                    @foreach($perfis as $perfil)
                        <div class="checkbox-item">
                            <input type="checkbox" name="perfil[]" id="perfil_{{ $perfil->id_perfil }}"
                                value="{{ $perfil->id_perfil }}" class="perfil-checkbox" data-projeto="{{ $perfil->projeto }}" data-equipe="{{ $perfil->equipe }}" data-parametros="{{ $perfil->parametros_medidos }}">
                            <label for="perfil_{{ $perfil->id_perfil }}">{{ $perfil->id_perfil }} -
                                {{ $perfil->empresa_nome }} - {{ $perfil->projeto }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div id="dynamic-forms"></div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.perfil-checkbox');
            const dynamicFormsContainer = document.getElementById('dynamic-forms');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const checkedCheckboxes = document.querySelectorAll('.perfil-checkbox:checked');
                    if (checkedCheckboxes.length > 2) {
                        this.checked = false;
                        alert('Só podemos vincular 2 relatórios');
                    } else {
                        updateDynamicForms(checkedCheckboxes);
                    }
                });
            });

            function updateDynamicForms(checkedCheckboxes) {
                dynamicFormsContainer.innerHTML = '';
                checkedCheckboxes.forEach(checkbox => {
                    const perfilId = checkbox.value;
                    const projeto = checkbox.getAttribute('data-projeto');
                    const equipe = checkbox.getAttribute('data-equipe');
                    const parametros = checkbox.getAttribute('data-parametros');
                    
                    const formHtml = `
                    <div class="form-container">
                        <div class="dynamic-form">
                            <div class="inline-group">
                                <div class="form-group">
                                    <label for="form_${perfilId}_projeto_numero">Projeto N°:</label>
                                    <input type="text" name="form_${perfilId}_projeto_numero" id="form_${perfilId}_projeto_numero" class="form-control" value="${projeto}">
                                </div>
                                <div class="form-group">
                                    <label for="form_${perfilId}_relatorio_analise_numero">Relatório de análise N°:</label>
                                    <input type="text" name="form_${perfilId}_relatorio_analise_numero" id="form_${perfilId}_relatorio_analise_numero" class="form-control">
                                </div>
                            </div>
                            <div class="inline-group">
                                <div class="form-group">
                                    <label for="form_${perfilId}_proposta">Proposta:</label>
                                    <input type="text" name="form_${perfilId}_proposta" id="form_${perfilId}_proposta" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="form_${perfilId}_plano_amostragem_numero">Plano de Amostragem N°:</label>
                                    <input type="text" name="form_${perfilId}_plano_amostragem_numero" id="form_${perfilId}_plano_amostragem_numero" class="form-control">
                                </div>
                            </div>
                            <div class="inline-group">
                                <div class="form-group">
                                    <label for="form_${perfilId}_servico">Serviço:</label>
                                    <input type="text" name="form_${perfilId}_servico" id="form_${perfilId}_servico" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="form_${perfilId}_objetivos">Objetivos:</label>
                                    <input type="text" name="form_${perfilId}_objetivos" id="form_${perfilId}_objetivos" class="form-control">
                                </div>
                            </div>
                            <div class="inline-group">
                                <div class="form-group">
                                    <label for="form_${perfilId}_equipe">Equipe:</label>
                                    <input type="text" name="form_${perfilId}_equipe" id="form_${perfilId}_equipe" class="form-control" value="${equipe}">
                                </div>
                                <div class="form-group">
                                    <label for="form_${perfilId}_empresa">Empresa:</label>
                                    <input type="text" name="form_${perfilId}_empresa" id="form_${perfilId}_empresa" class="form-control">
                                </div>
                            </div>
                            <div class="inline-group">
                                <div class="form-group">
                                    <label for="form_${perfilId}_endereco">Endereço:</label>
                                    <input type="text" name="form_${perfilId}_endereco" id="form_${perfilId}_endereco" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="form_${perfilId}_contato">Contato:</label>
                                    <input type="text" name="form_${perfilId}_contato" id="form_${perfilId}_contato" class="form-control">
                                </div>
                            </div>
                            <div class="inline-group">
                                <div class="form-group">
                                    <label for="form_${perfilId}_data_amostragem">Data da amostragem:</label>
                                    <input type="date" name="form_${perfilId}_data_amostragem" id="form_${perfilId}_data_amostragem" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="form_${perfilId}_fonte_emissao">Fonte de emissão:</label>
                                    <input type="text" name="form_${perfilId}_fonte_emissao" id="form_${perfilId}_fonte_emissao" class="form-control">
                                </div>
                            </div>
                            <div class="inline-group">
                                <div class="form-group">
                                    <label for="form_${perfilId}_numero_fontes">Número de Fontes:</label>
                                    <input type="number" name="form_${perfilId}_numero_fontes" id="form_${perfilId}_numero_fontes" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="form_${perfilId}_numero_coletas">Número de Coletas:</label>
                                    <input type="number" name="form_${perfilId}_numero_coletas" id="form_${perfilId}_numero_coletas" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="form_${perfilId}_parametros">Parâmetros:</label>
                                <input type="text" name="form_${perfilId}_parametros" id="form_${perfilId}_parametros" class="form-control" value="${parametros}">
                            </div>
                            <div class="form-group">
                                <label for="form_${perfilId}_metodologia_documentos">Metodologia e Documentos Necessários:</label>
                                <textarea name="form_${perfilId}_metodologia_documentos" id="form_${perfilId}_metodologia_documentos" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="form_${perfilId}_equipamentos_necessarios">Equipamentos Necessários para realização das atividades:</label>
                                <textarea name="form_${perfilId}_equipamentos_necessarios" id="form_${perfilId}_equipamentos_necessarios" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="form_${perfilId}_observacoes">Observações:</label>
                                <textarea name="form_${perfilId}_observacoes" id="form_${perfilId}_observacoes" class="form-control"></textarea>
                            </div>
                            <button type="button" class="btn btn-secondary" onclick="generatePDF(${perfilId})">Gerar Relatório</button>
                        </div>
                    </div>
                <br>
                <hr>
                <br>
                    `;
                    dynamicFormsContainer.insertAdjacentHTML('beforeend', formHtml);
                });
            }

            window.generatePDF = function(perfilId) {
                console.log('generatePDF called with perfilId:', perfilId); // Adicionando console.log
                const form = document.querySelector('form');
                console.log('Form action before setting:', form.action); // Adicionando console.log
                form.action = `/os/${perfilId}/generatePDF`;
                console.log('Form action after setting:', form.action); // Adicionando console.log
                form.method = "POST";
                form.submit();
            }
        });
    </script>

</body>

</html>