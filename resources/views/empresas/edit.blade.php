<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empresa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/empresa-form.css') }}">
</head>
<body>
    @include('layouts.sidebar')
    <div class="main-content empresa-form-container">
        <div class="container">
            <div class="form-container">
                <div class="cliente-info">
                    <h2>Dados do Cliente</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="cliente_nome">Nome do Cliente</label>
                            <input type="text" id="cliente_nome" class="form-control" value="{{ $cliente->nome }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="cliente_cnpj_cpf">CPF/CNPJ do Cliente</label>
                            <input type="text" id="cliente_cnpj_cpf" class="form-control" value="{{ $cliente->cnpj_cpf }}" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cliente_endereco">Endereço do Cliente</label>
                        <input type="text" id="cliente_endereco" class="form-control" value="{{ $cliente->endereco }}" readonly>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="cliente_email">E-mail do Cliente</label>
                            <input type="email" id="cliente_email" class="form-control" value="{{ $cliente->email }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="cliente_telefone">Telefone do Cliente</label>
                            <input type="text" id="cliente_telefone" class="form-control" value="{{ $cliente->telefone }}" readonly>
                        </div>
                    </div>
                </div>

                <h1>Editar Empresa</h1>
                <form action="{{ route('empresas.update', $empresa->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" name="nome" class="form-control" value="{{ $empresa->nome }}" required>
                        </div>

                        <div class="form-group">
                            <label for="cnpj">CNPJ</label>
                            <input type="text" id="cnpj" name="cnpj" class="form-control" value="{{ $empresa->cnpj }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="endereco">Endereço</label>
                        <input type="text" id="endereco" name="endereco" class="form-control" value="{{ $empresa->endereco }}" required>
                    </div>

                    <div class="form-group">
                        <label for="contato">Contato</label>
                        <input type="text" id="contato" name="contato" class="form-control" value="{{ $empresa->contato }}" required>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a href="{{ route('empresas.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
                
                <div class="button-group" style="margin-top: 20px;">
                    <form action="{{ route('empresas.destroy', $empresa->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta empresa?')">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            // Máscara para o CNPJ
            $('#cnpj').mask('00.000.000/0000-00');
            
            // Máscara para o telefone de contato da empresa
            $('#contato').mask('(00) 00000-0000');
        });
    </script>
</body>
</html>
