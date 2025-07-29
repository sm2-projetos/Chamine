<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legislação</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

@include('layouts.sidebar')

<div class="certificado-layout">
    <div class="certificado-lista">
        <h2 class="certificado-header">📚 Legislações Existentes</h2>

        @if($legislacoes->count())
            <div class="certificado-container">
                @foreach($legislacoes as $legislacao)
                    <div class="certificado-card">
                        <div class="certificado-header">
                            {{ $legislacao->nome }}
                        </div>
                        <p style="margin-top: 8px;">{{ $legislacao->descricao }}</p>

                        <div class="certificado-actions">
                            <button class="btn-editar-legislacao" data-id="{{ $legislacao->id }}" data-nome="{{ $legislacao->nome }}" data-descricao="{{ $legislacao->descricao }}">
                                Editar
                            </button>

                            <form action="{{ route('legislacao.destroy', $legislacao->id) }}" method="POST" class="ajax-delete-legislacao">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="danger">Excluir</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>Nenhuma legislação cadastrada ainda.</p>
        @endif
    </div>

    <div class="certificado-formulario">
        <h2 class="certificado-header" id="form-title">📥 Criar Nova Legislação</h2>

        <form action="{{ route('legislacao.store') }}" method="POST" class="form-upload-container" id="form-legislacao">
            @csrf
                @csrf
    <input type="hidden" name="id" id="id">
    <div id="put-method-field"></div>

            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>

            <label for="descricao">Descrição:</label>
            <input type="text" name="descricao" id="descricao" required>

            <div style="display: flex; justify-content: space-between; gap: 10px; margin-top: 16px;">
                <button type="submit" id="submit-btn" class="btn-salvar">Salvar</button>
                <button type="button" id="btn-cadastrar-novo" class="btn-salvar" style="display: none;">Cadastrar Novo</button>
            </div>
        </form>
  </div>
</div>
<style>
    .certificado-layout {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
        align-items: flex-start;
        margin-top: 20px;
    }

    .certificado-lista {
        flex: 2;
        min-width: 320px;
    }

    .certificado-formulario {
        flex: 1;
        min-width: 280px;
    }
    .certificado-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 16px;
        margin-top: 20px;
    }

    .certificado-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        background-color: #fafafa;
    }

    .certificado-header {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 8px;
        color: #333;
    }

    .certificado-actions {
        display: flex;
        gap: 8px; /* <-- Aqui adicionamos espaço entre os botões/links */
        flex-wrap: wrap;
        margin-top: 12px;
    }

    .certificado-actions form,
    .certificado-actions a {
        display: inline-block;
    }

    .certificado-actions button,
    .certificado-actions a {
        background-color: #007BFF;
        color: white;
        border: none;
        padding: 6px 12px;
        text-decoration: none;
        border-radius: 4px;
        font-size: 0.9rem;
        transition: background 0.2s ease;
    }

    .certificado-actions button:hover,
    .certificado-actions a:hover {
        background-color: #0056b3;
    }

    .certificado-actions .danger {
        background-color: #dc3545;
    }

    .certificado-actions .danger:hover {
        background-color: #a71d2a;
    }

    .certificado-primary {
        color: green;
        font-weight: bold;
    }

    .form-upload-container {
        max-width: 600px;
        margin-bottom: 30px;
        padding: 16px;
        background-color: #fafafa;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .form-upload-container label {
        display: block;
        font-weight: bold;
        margin-bottom: 6px;
        color: #333;
    }

    .form-upload-container input[type="text"],
    .form-upload-container input[type="file"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 0.95rem;
    }

    .form-upload-container input[type="checkbox"] {
        margin-right: 6px;
    }

    .form-upload-container button {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 0.95rem;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .form-upload-container button:hover {
        background-color: #218838;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.ajax-delete-legislacao').submit(function(e) {
            e.preventDefault();
            if (!confirm('Tem certeza que deseja excluir esta legislação?')) return;

            let form = $(this);
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    alert('Legislação excluída com sucesso!');
                    location.reload();
                },
                error: function(xhr) {
                    alert('Erro ao excluir: ' + xhr.responseText);
                }
            });
        });

        $('.btn-editar-legislacao').click(function() {
            const id = $(this).data('id');
            $('#form-title').text('✏️ Editar Legislação');
            $('#submit-btn').text('Atualizar');
            $('#id').val($(this).data('id'));
            $('#nome').val($(this).data('nome'));
            $('#descricao').val($(this).data('descricao'));
            $('#form-legislacao').attr('action', '/legislacao-update/' + id);
            $('#put-method-field').html('<input type="hidden" name="_method" value="PUT">');
            $('#btn-cadastrar-novo').show();
        });

        $('#btn-cadastrar-novo').click(function() {
            $('#form-title').text('📄 Criar Nova Legislação');
            $('#submit-btn').text('Salvar');
            $('#id').val('');
            $('#nome').val('');
            $('#descricao').val('');
            $('#form-legislacao').attr('action', '{{ route('legislacao.store') }}');
            $('#put-method-field').html('');
            $('#btn-cadastrar-novo').hide();
        });
    });
</script>
