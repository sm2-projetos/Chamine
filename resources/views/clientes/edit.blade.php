<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>
<body>
    @include('layouts.sidebar')
    <div class ="main-content">
    <div class="container">
        <div class="form-container">
            <h1>Editar Cliente</h1>
            <form action="{{ route('clientes.update', $cliente->id_cliente) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" class="form-control" value="{{ $cliente->nome }}" required>
                </div>

                <div class="form-group">
                    <label for="cnpj_cpf">CPF</label>
                    <input type="text" id="cnpj_cpf" name="cnpj_cpf" class="form-control" value="{{ $cliente->cnpj_cpf }}" required>
                </div>

                <div class="form-group">
                    <label for="endereco">Endereço</label>
                    <input type="text" id="endereco" name="endereco" class="form-control" value="{{ $cliente->endereco }}" required>
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ $cliente->email }}" required>
                </div>

                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" id="telefone" name="telefone" class="form-control" value="{{ $cliente->telefone }}" required>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
            <div class="button-group" style="margin-top: 20px;">
                <form action="{{ route('clientes.destroy', $cliente->id_cliente) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
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

    // Check if CPF already exists
    document.getElementById('cnpj_cpf').addEventListener('blur', function() {
        const cpf = this.value;
        if (cpf) {
            $.ajax({
                url: '{{ route("clientes.checkCpf") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    cnpj_cpf: cpf
                },
                success: function(response) {
                    if (response.exists) {
                        alert('Já existe um cliente cadastrado com este CPF.');
                    }
                }
            });
        }
    });
</script>
</body>
</html>

