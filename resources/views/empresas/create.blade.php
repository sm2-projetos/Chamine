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
</head>
<body>
    @include('layouts.sidebar')

    <div class="main-content cliente-form-container">
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
                        <div class="form-group">
                            <label for="endereco">Endereço</label>
                            <input type="text" id="endereco" name="endereco" class="form-control" placeholder="Digite o endereço da empresa" required>
                        </div>
                        <div class="form-group">
                            <label for="telefone">Contato</label>
                            <input type="text" id="telefone" name="telefone" class="form-control" placeholder="Digite o telefone ou nome do contato" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ $empresa->email ?? '' }}" placeholder="Digite o e-mail da empresa">
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>