@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3>Preencher Relatório</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="/gerar-documento">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Número do Relatório:</label>
                    <input type="text" class="form-control" name="numeroRelatorio" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Dados do Cliente:</label>
                    <textarea class="form-control" name="dadosDoCliente" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Endereço da Empresa:</label>
                    <input type="text" class="form-control" name="enderecoEmpresa" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">CNPJ:</label>
                    <input type="text" class="form-control" name="cnpj" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Técnico 1:</label>
                    <input type="text" class="form-control" name="tecnico1" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Técnico 2:</label>
                    <input type="text" class="form-control" name="tecnico2" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Data:</label>
                    <input type="date" class="form-control" name="data" required>
                </div>

                <button type="submit" class="btn btn-primary">Gerar Documento</button>
            </form>
        </div>
    </div>
</div>
@endsection 