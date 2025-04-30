<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Empresa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cliente-cadastro.css') }}">
    <style>
        /* Estilos específicos para empresas, mantendo consistência com clientes */
        .empresa-form-container {
            max-width: 1800px;
            margin-left: 100px;
            width: calc(100% - 270px);
            padding: 20px;
            display: flex;
            justify-content: center;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        .form-container {
            padding: 30px;
            border-radius: 8px;
            /* box-shadow: 0 3px 10px rgba(0,0,0,0.1); */
            width: 100%;
            max-width: 1200px;
            margin-bottom: 20px;
        }

        .empresa-form-container h1 {
            color: #2e7d32;
            font-size: 24px;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #00a65a;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .empresa-form-container h1::before {
            content: '\f0c0'; /* Ícone de grupo de empresas */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 30px;
            color: #00a65a;
        }

        /* Estilos de formulário melhorados para combinar com o cadastro de clientes */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px 20px;
        }

        .form-group {
            flex: 1;
            min-width: 250px;
            padding: 0 10px;
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #00a65a;
            box-shadow: 0 0 0 3px rgba(0, 166, 90, 0.2);
            outline: none;
        }

        /* Estilos para a seção de contatos */
        .contatos-section h2 {
            color: #2e7d32;
            font-size: 20px;
            margin: 30px 0 20px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e0e0e0;
            font-weight: 500;
        }

        /* Estilização dos botões */
        .action-buttons {
            display: flex;
            gap: 10px;
            margin: 20px 0;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 15px;
            min-width: 130px;
        }

        .btn i {
            font-size: 16px;
        }

        .btn-primary {
            background-color: #00a65a;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0,0,0,0.15);
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        /* Classes utilitárias */
        .mt-4 {
            margin-top: 25px;
        }

        hr {
            border: 0;
            height: 1px;
            background: #e0e0e0;
            margin: 20px 0;
        }

        /* Estilos responsivos */
        @media (max-width: 992px) {
            .form-row {
                margin: 0 -5px 15px;
            }
            
            .form-group {
                padding: 0 5px;
            }
            
            .btn {
                padding: 8px 16px;
            }
        }

        @media (max-width: 768px) {
            .empresa-form-container {
                margin-left: 0;
                width: 100%;
                padding: 15px;
            }
            
            .form-container {
                padding: 20px;
            }
            
            .form-row {
                flex-direction: column;
                margin: 0 0 15px;
            }
            
            .form-group {
                padding: 0;
            }
            
            .action-buttons, .button-group {
                flex-direction: column;
                width: 100%;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    @include('layouts.sidebar')

    <div class="main-content empresa-form-container">
        <div class="form-container">
            <h1>Cadastrar Empresa</h1>
            
            <form action="{{ route('empresas.store') }}" method="POST">
                @csrf
                
                <div class="empresa-section">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nome">Nome da Empresa</label>
                            <input type="text" id="nome" name="nome" class="form-control" placeholder="Digite o nome da empresa" required>
                        </div>

                        <div class="form-group">
                            <label for="cnpj">CNPJ</label>
                            <input type="text" id="cnpj" name="cnpj" class="form-control cnpj-mask" placeholder="Digite o CNPJ da empresa" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group" style="flex: 1 0 100%;">
                            <label for="endereco">Endereço</label>
                            <input type="text" id="endereco" name="endereco" class="form-control" placeholder="Digite o endereço da empresa" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Digite o e-mail da empresa">
                        </div>

                        <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="text" id="telefone" name="telefone" class="form-control telefone-mask" placeholder="Digite o telefone da empresa" required>
                        </div>
                    </div>
                </div>

                <div id="contatos-forms" class="contatos-section">
                    <h2>Contatos da Empresa</h2>
                    <!-- Formulários de contatos serão adicionados aqui -->
                </div>

                <div class="action-buttons">
                    <button type="button" id="add-contato" class="btn btn-secondary">
                        <i class="fas fa-user-plus"></i> Adicionar Contato
                    </button>
                    <button type="button" id="remove-contato" class="btn btn-danger" style="display: none;">
                        <i class="fas fa-user-minus"></i> Remover Contato
                    </button>
                </div>

                <div class="form-group mt-4">
                    <label for="cliente_id">Vincular a Cliente (opcional)</label>
                    <select id="cliente_id" name="cliente_id" class="form-control">
                        <option value="">Selecione um cliente...</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id_cliente }}">{{ $cliente->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cadastrar Empresa
                    </button>
                    <a href="{{ route('empresas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            // Aplicar máscaras
            $('.telefone-mask').mask('(00) 00000-0000');
            $('.cnpj-mask').mask('00.000.000/0000-00');
        });

        // Adicionar formulário de contato
        document.getElementById('add-contato').addEventListener('click', function() {
            const contatosForms = document.getElementById('contatos-forms');
            const newForm = document.createElement('div');
            newForm.classList.add('contato-form');
            
            // ID único para este contato
            const contatoId = Date.now();
            
            newForm.innerHTML = `
                <div class="form-row">
                    <div class="form-group">
                        <label for="contato_nome_${contatoId}">Nome do Contato</label>
                        <input type="text" id="contato_nome_${contatoId}" name="contato_nome[]" class="form-control" placeholder="Nome do contato" required>
                    </div>
                    <div class="form-group">
                        <label for="contato_cargo_${contatoId}">Cargo</label>
                        <input type="text" id="contato_cargo_${contatoId}" name="contato_cargo[]" class="form-control" placeholder="Cargo do contato">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="contato_email_${contatoId}">E-mail</label>
                        <input type="email" id="contato_email_${contatoId}" name="contato_email[]" class="form-control" placeholder="E-mail do contato">
                    </div>
                    <div class="form-group">
                        <label for="contato_telefone_${contatoId}">Telefone</label>
                        <input type="text" id="contato_telefone_${contatoId}" name="contato_telefone[]" class="form-control telefone-mask" placeholder="Telefone do contato" required>
                    </div>
                </div>
                <hr>
            `;
            
            contatosForms.appendChild(newForm);
            document.getElementById('remove-contato').style.display = 'inline-block';

            // Aplicar máscaras aos novos campos
            $('.telefone-mask').mask('(00) 00000-0000');
        });

        // Remover formulário de contato
        document.getElementById('remove-contato').addEventListener('click', function() {
            const contatosForms = document.getElementById('contatos-forms');
            const contatoFormsList = contatosForms.getElementsByClassName('contato-form');
            
            if (contatoFormsList.length > 0) {
                contatosForms.removeChild(contatoFormsList[contatoFormsList.length - 1]);
            }
            
            if (contatoFormsList.length === 0) {
                document.getElementById('remove-contato').style.display = 'none';
            }
        });
    </script>
</body>
</html>