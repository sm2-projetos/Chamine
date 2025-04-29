<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empresa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cliente-cadastro.css') }}">
    <style>
        /* Estilos específicos baseados no cliente-cadastro.css */
        .empresa-form-container {
            max-width: 1800px;
            margin-left: 250px;
            width: calc(100% - 270px);
            padding: 20px;
            display: flex;
            justify-content: center;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
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

        .empresa-form-container .empresa-section h2 {
            color: #2e7d32;
            font-size: 22px;
            margin: 30px 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #00a65a;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .empresa-form-container .empresa-section h2::before {
            content: '\f0c0'; /* Ícone de grupo de empresas */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 26px;
            color: #00a65a;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
            min-width: 250px;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            border-color: #00a65a;
            box-shadow: 0 0 0 3px rgba(0, 166, 90, 0.2);
            outline: none;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            font-size: 16px;
            flex: 1 1 auto;
        }

        .btn-primary {
            background: #00a65a;
            color: white;
            min-width: 120px;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
            min-width: 120px;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
            min-width: 120px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .mt-4 {
            margin-top: 1.5rem;
        }

        /* Responsividade conforme cliente-cadastro.css */
        @media (max-width: 992px) {
            .empresa-form-container h1 {
                font-size: 22px;
            }
            
            .empresa-form-container h1::before {
                font-size: 26px;
            }

            .form-container {
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .empresa-form-container {
                margin-left: 0;
                width: 100%;
            }

            .empresa-form-container h1 {
                font-size: 20px;
            }
            
            .empresa-form-container h1::before {
                font-size: 24px;
            }
            
            .form-control {
                padding: 8px 10px;
                font-size: 15px;
            }
            
            .btn {
                padding: 8px 16px;
                font-size: 15px;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            .form-container {
                padding: 15px;
            }
            
            .form-row {
                flex-direction: column;
                gap: 10px;
            }
        }

        @media (max-width: 576px) {
            .empresa-form-container h1 {
                font-size: 18px;
                margin-bottom: 15px;
            }
            
            .empresa-form-container h1::before {
                font-size: 20px;
            }
            
            .form-group {
                margin-bottom: 15px;
            }
            
            label {
                margin-bottom: 5px;
                font-size: 14px;
            }
            
            .form-control {
                padding: 7px;
                font-size: 14px;
            }
            
            .form-container {
                padding: 10px;
                margin: 0 10px;
            }
        }
    </style>
</head>
<body>
    @include('layouts.sidebar')

    <div class="main-content empresa-form-container">
        <div class="form-container">
            <h1>Editar Empresa</h1>
            
            <form action="{{ route('empresas.update', $empresa->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="empresa-section">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nome">Nome da Empresa</label>
                            <input type="text" id="nome" name="nome" class="form-control" value="{{ $empresa->nome }}" placeholder="Digite o nome da empresa" required>
                        </div>

                        <div class="form-group">
                            <label for="cnpj">CNPJ</label>
                            <input type="text" id="cnpj" name="cnpj" class="form-control cnpj-mask" value="{{ $empresa->cnpj }}" placeholder="Digite o CNPJ da empresa" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="endereco">Endereço</label>
                        <input type="text" id="endereco" name="endereco" class="form-control" value="{{ $empresa->endereco }}" placeholder="Digite o endereço da empresa" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ $empresa->email ?? '' }}" placeholder="Digite o e-mail da empresa">
                        </div>

                        <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="text" id="telefone" name="telefone" class="form-control telefone-mask" value="{{ $empresa->telefone ?? $empresa->contato }}" placeholder="Digite o telefone da empresa" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="cliente_id">Cliente Vinculado</label>
                        <select id="cliente_id" name="cliente_id" class="form-control">
                            <option value="">Selecione um cliente (opcional)</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id_cliente }}">{{ $cliente->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Atualizar Empresa</button>
                    <a href="{{ route('empresas.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
            
            <div class="mt-4">
                <form action="{{ route('empresas.destroy', $empresa->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja mover esta empresa para a lixeira?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir Empresa</button>
                </form>
            </div>
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
    </script>
</body>
</html>
