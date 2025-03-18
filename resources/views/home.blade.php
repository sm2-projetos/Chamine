<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    @include('layouts.sidebar')


        <div class="container">
            <div class="dashboard-grid">
                <div class="card">
                    <h2>Ordens em Andamento</h2>
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-item">
                                <div class="stat-number">12</div>
                                <div class="stat-label">Em Processamento</div>
                            </div>
                            <button class="action-button">Gerenciar OS</button>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="andamentoChart"></canvas>
                    </div>
                </div>

                <div class="card">
                    <h2>OS Concluídas</h2>
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-item">
                                <div class="stat-number">45</div>
                                <div class="stat-label">Finalizadas</div>
                            </div>
                            <button class="action-button">Ver Detalhes</button>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="concluidasChart"></canvas>
                    </div>
                </div>

                <div class="card">
                    <h2>OS Pendentes</h2>
                    <div class="stat-card">
                        <div class="stat-info">
                            <div class="stat-item">
                                <div class="stat-number">3</div>
                                <div class="stat-label">Aguardando</div>
                            </div>
                            <button class="action-button">Resolver Pendências</button>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="pendentesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/home.js') }}"></script>
</body>
</html>