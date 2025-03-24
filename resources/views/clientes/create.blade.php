<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>

@include('layouts.sidebar')
<body>
        <div class="container">
            <div class="form-container">
                <div class="form-section">
                    <h2>Cadastrar Cliente</h2>
                    <form action="{{ route('clientes.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" name="nome" class="form-control" placeholder="Digite o nome do cliente" required>
                        </div>

                        <div class="form-group">
                            <label for="cnpj_cpf">CPF</label>
                            <input type="text" id="cnpj_cpf" name="cnpj_cpf" class="form-control" placeholder="Digite o CNPJ ou CPF do cliente" required>
                        </div>

                        <div class="form-group">
                            <label for="endereco">Endereço</label>
                            <input type="text" id="endereco" name="endereco" class="form-control" placeholder="Digite o endereço do cliente" required>
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Digite o e-mail do cliente" required>
                        </div>

                        <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="text" id="telefone" name="telefone" class="form-control" placeholder="Digite o telefone do cliente" required>
                        </div>

                        <div id="empresa-forms">
                            <h2>Cadastrar Empresa</h2>
                            <!-- Formulário de empresa inicial vazio -->
                        </div>

                        <button type="button" id="add-empresa" class="btn btn-secondary">Adicionar Empresa</button>
                        <button type="button" id="remove-empresa" class="btn btn-secondary" style="display: none;">Remover Empresa</button>

                        <div class="button-group">
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                            <a href="{{ route('home') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        // Toggle notifications
        function toggleNotifications() {
            const dropdown = document.getElementById('notificationDropdown');
            dropdown.classList.toggle('show');
        }

        // Close notifications when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('.notification-icon') && 
                !event.target.matches('.fa-bell')) {
                const dropdown = document.getElementById('notificationDropdown');
                if (dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                }
            }
        }

        // Add and remove empresa forms
        document.getElementById('add-empresa').addEventListener('click', function() {
            const empresaForms = document.getElementById('empresa-forms');
            const newForm = document.createElement('div');
            newForm.classList.add('empresa-form');
            newForm.innerHTML = `
                <div class="form-group">
                    <label for="empresa_nome">Nome</label>
                    <input type="text" id="empresa_nome" name="empresa_nome[]" class="form-control" placeholder="Digite o nome da empresa">
                </div>
                <div class="form-group">
                    <label for="empresa_cnpj">CNPJ</label>
                    <input type="text" id="empresa_cnpj" name="empresa_cnpj[]" class="form-control" placeholder="Digite o CNPJ da empresa">
                </div>
                <div class="form-group">
                    <label for="empresa_endereco">Endereço</label>
                    <input type="text" id="empresa_endereco" name="empresa_endereco[]" class="form-control" placeholder="Digite o endereço da empresa">
                </div>
                <div class="form-group">
                    <label for="empresa_contato">Contato</label>
                    <input type="text" id="empresa_contato" name="empresa_contato[]" class="form-control" placeholder="Digite o contato da empresa">
                </div>
                <hr>
            `;
            empresaForms.appendChild(newForm);
            document.getElementById('remove-empresa').style.display = 'inline-block';

            // Aplicar máscara ao novo campo de CNPJ da empresa
            $(newForm).find('input[name="empresa_cnpj[]"]').mask('00.000.000/0000-00');
        });

        document.getElementById('remove-empresa').addEventListener('click', function() {
            const empresaForms = document.getElementById('empresa-forms');
            if (empresaForms.children.length > 1) {
                empresaForms.removeChild(empresaForms.lastChild);
            }
            if (empresaForms.children.length === 0) {
                document.getElementById('remove-empresa').style.display = 'none';
            }
        });

        // Aplicar máscaras aos campos de CPF/CNPJ e telefone
        $(document).ready(function() {
            $('#telefone').mask('(00) 00000-0000'); // Máscara para telefone

            $('#cnpj_cpf').on('input', function() {
                var value = $(this).val().replace(/\D/g, '');
                if (value.length <= 11) {
                    $(this).mask('000.000.000-00'); // Máscara para CPF
                } else {
                    $(this).mask('00.000.000/0000-00'); // Máscara para CNPJ
                }
            });
        });
    </script>
</body>
</html>