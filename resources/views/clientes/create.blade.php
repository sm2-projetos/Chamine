<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cliente-cadastro.css') }}">
</head>
<body>
    @include('layouts.sidebar')

    <div class="main-content cliente-form-container">
        <div class="form-container">
            <h1>Cadastrar Cliente</h1>
            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf
                <div class="cliente-section">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" name="nome" class="form-control" placeholder="Digite o nome do cliente" required>
                        </div>

                        <div class="form-group">
                            <label for="cnpj_cpf">CPF/CNPJ</label>
                            <input type="text" id="cnpj_cpf" name="cnpj_cpf" class="form-control" placeholder="Digite o CNPJ ou CPF do cliente" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="endereco">Endereço</label>
                        <input type="text" id="endereco" name="endereco" class="form-control" placeholder="Digite o endereço do cliente" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Digite o e-mail do cliente" required>
                        </div>

                        <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="text" id="telefone" name="telefone" class="form-control" placeholder="Digite o telefone do cliente" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="empresa_id">Empresa Vinculada</label>
                        <select id="empresa_id" name="empresa_id" class="form-control">
                            <option value="">Selecione uma empresa...</option>
                            @foreach($empresas as $empresa)
                                <option value="{{ $empresa->id }}">{{ $empresa->nome }} ({{ $empresa->cnpj }})</option>
                            @endforeach
                        </select>
                        <div class="mt-2">
                            <small class="text-muted">Não encontrou a empresa? 
                                <a href="{{ route('empresas.create') }}" target="_blank">Cadastre uma nova empresa</a>
                            </small>
                        </div>
                    </div>
                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Cadastrar
                        </button>
                        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            // Máscara para telefone
            $('#telefone').mask('(00) 00000-0000');
            
            // Máscara para CPF/CNPJ dinâmica
            $('#cnpj_cpf').on('input', function() {
                var value = $(this).val().replace(/\D/g, '');
                if (value.length <= 11) {
                    $(this).mask('000.000.000-00'); // Máscara para CPF
                } else {
                    $(this).mask('00.000.000/0000-00'); // Máscara para CNPJ
                }
            });
        });

        // Add empresa form
        document.getElementById('add-empresa').addEventListener('click', function() {
            const empresaForms = document.getElementById('empresa-forms');
            const newForm = document.createElement('div');
            newForm.classList.add('empresa-form');
            
            // ID único para esta empresa
            const empresaId = Date.now();
            
            newForm.innerHTML = `
                <div class="form-row">
                    <div class="form-group">
                        <label for="empresa_nome_${empresaId}">Nome da Empresa</label>
                        <input type="text" id="empresa_nome_${empresaId}" name="empresa_nome[]" class="form-control" placeholder="Nome da empresa" required>
                    </div>
                    <div class="form-group">
                        <label for="empresa_cnpj_${empresaId}">CNPJ</label>
                        <input type="text" id="empresa_cnpj_${empresaId}" name="empresa_cnpj[]" class="form-control cnpj-mask" placeholder="CNPJ da empresa" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="empresa_endereco_${empresaId}">Endereço</label>
                    <input type="text" id="empresa_endereco_${empresaId}" name="empresa_endereco[]" class="form-control" placeholder="Endereço da empresa" required>
                </div>
                <div class="form-group">
                    <label for="empresa_contato_${empresaId}">Contato</label>
                    <input type="text" id="empresa_contato_${empresaId}" name="empresa_contato[]" class="form-control telefone-mask" placeholder="Telefone da empresa" required>
                </div>
            `;
            
            empresaForms.appendChild(newForm);
            document.getElementById('remove-empresa').style.display = 'inline-block';

            // Aplicar máscaras aos novos campos
            $('.cnpj-mask').mask('00.000.000/0000-00');
            $('.telefone-mask').mask('(00) 00000-0000');
        });

        // Remove empresa form
        document.getElementById('remove-empresa').addEventListener('click', function() {
            const empresaForms = document.getElementById('empresa-forms');
            const empresaFormsList = empresaForms.getElementsByClassName('empresa-form');
            
            if (empresaFormsList.length > 0) {
                empresaForms.removeChild(empresaFormsList[empresaFormsList.length - 1]);
            }
            
            if (empresaFormsList.length <= 1) {
                document.getElementById('remove-empresa').style.display = 'none';
            }
        });
    </script>
</body>
</html>