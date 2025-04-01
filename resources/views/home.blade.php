<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    @include('layouts.sidebar')
    
    <div class="dashboard-page">
        <div class="dashboard-container">
            <h1 class="dashboard-title">Painel de Controle</h1>
            
            <div class="dashboard-grid">
                <!-- Cartão 1: Ordens em Andamento -->
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h2 class="dashboard-card-title">Ordens em Andamento</h2>
                    </div>
                    
                    <div class="dashboard-card-content">
                        <div class="dashboard-stats">
                            <div class="dashboard-stat-number">12</div>
                            <div class="dashboard-stat-label">Em Processamento</div>
                        </div>
                        <button class="dashboard-action-button">Gerenciar OS</button>
                    </div>
                    
                    <div class="dashboard-chart-container">
                        <canvas id="andamentoChart"></canvas>
                    </div>
                </div>

                <!-- Cartão 2: OS Concluídas -->
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h2 class="dashboard-card-title">OS Concluídas</h2>
                    </div>
                    
                    <div class="dashboard-card-content">
                        <div class="dashboard-stats">
                            <div class="dashboard-stat-number">45</div>
                            <div class="dashboard-stat-label">Finalizadas</div>
                        </div>
                        <button class="dashboard-action-button">Ver Detalhes</button>
                    </div>
                    
                    <div class="dashboard-chart-container">
                        <canvas id="concluidasChart"></canvas>
                    </div>
                </div>

                <!-- Cartão 3: OS Pendentes -->
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <h2 class="dashboard-card-title">OS Pendentes</h2>
                    </div>
                    
                    <div class="dashboard-card-content">
                        <div class="dashboard-stats">
                            <div class="dashboard-stat-number">3</div>
                            <div class="dashboard-stat-label">Aguardando</div>
                        </div>
                        <button class="dashboard-action-button">Resolver Pendências</button>
                    </div>
                    
                    <div class="dashboard-chart-container">
                        <canvas id="pendentesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/home.js') }}"></script>
</body>
</html>