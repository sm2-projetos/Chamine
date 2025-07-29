<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <style>
        /* Estilos específicos para o formulário */
        .form-container {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section h2 {
            color: #333;
            font-size: 1.2em;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #00a65a;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #00a65a;
            box-shadow: 0 0 0 2px rgba(0,166,90,0.1);
            outline: none;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 10px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: #00a65a;
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .empresa-form {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .empresa-form .form-group {
            flex: 1 1 calc(50% - 20px);
        }
    </style>
</head>

@include('layouts.sidebar')
<body>
        <div class="container">
    <h2>Cadastrar Infraestrutura</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

<form method="POST" action="{{ route('infraestruturas.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="conjunto_nome">Nome do Conjunto de Blocos</label>
        <input type="text" id="conjunto_nome" name="conjunto_nome" class="form-control" required>
    </div>
    <div id="blocos">
        <div class="bloco">
        </div>
    </div>

    <button type="button" class="btn btn-dark" onclick="adicionarBloco()">+ Adicionar Mais Conteúdo</button>
    <button type="submit" class="btn btn-primary">Salvar</button>
</form>

<script>
    let index = 1;

function adicionarBloco() {
    const container = document.getElementById('blocos');
    const bloco = document.createElement('div');
    bloco.className = 'bloco-estrutura';

    bloco.innerHTML = `
        <div class="form-group">
            <label for="tipo-${index}">Tipo do conteúdo</label>
            <select name="blocos[${index}][tipo]" class="form-control" onchange="alternarCampos(this)">
                <option value="texto">Texto</option>
                <option value="imagem">Imagem</option>
            </select>
        </div>

        <div class="form-group campo-texto">
            <label for="conteudo-${index}">Conteúdo (Texto)</label>
            <textarea name="blocos[${index}][conteudo]" class="form-control" rows="4"></textarea>
        </div>

        <div class="form-group campo-imagem" style="display: none;">
            <label for="imagem-${index}">Conteúdo (Imagem)</label>
            <input type="file" name="blocos[${index}][conteudo]" class="form-control">
        </div>

        <div class="button-group">
            <button type="button" class="btn btn-secondary" onclick="removerBloco(this)">Remover</button>
        </div>
        <hr>
    `;

    container.appendChild(bloco);
    index++;
}

function alternarCampos(select) {
    const bloco = select.closest('.bloco-estrutura');
    const campoTexto = bloco.querySelector('.campo-texto');
    const campoImagem = bloco.querySelector('.campo-imagem');

    if (select.value === 'texto') {
        campoTexto.style.display = 'block';
        campoImagem.style.display = 'none';
    } else {
        campoTexto.style.display = 'none';
        campoImagem.style.display = 'block';
    }
}

function removerBloco(button) {
    button.closest('.bloco-estrutura').remove();
}
</script>

</div>
</body>
</html>