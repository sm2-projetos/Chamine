<div class="main-content">
        <div class="header">
            <img src="https://www.galaxcms.com.br/up_crud_comum/2065/logo-20180522144628.png" alt="Logo">
            <div class="header-actions">
                <div class="notifications">
                    <div class="notification-icon" onclick="toggleNotifications()">
                        <i class="fas fa-bell"></i>
                        <span class="notification-count">2</span>
                    </div>
                    <div class="notification-dropdown" id="notificationDropdown">
                        <div class="alert-item">
                            <strong>Licença expirando</strong>
                            <p>3 licenças vencem em 30 dias</p>
                        </div>
                        <div class="alert-item">
                            <strong>Dados Inconsistentes</strong>
                            <p>2 registros fora do padrão</p>
                        </div>
                        <!-- Novo item de logout na dropdown -->
                        <div class="alert-item" onclick="document.getElementById('logoutForm').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </div>
                        <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>

<div class="sidebar">
    <div class="sidebar-header">
        <h2><i class="fas fa-th-large"></i> Menu Principal</h2>
    </div>

    <div class="menu-section">
        <div class="menu-section-title">Gerenciamento</div>
        <a href="{{ route('home') }}" class="menu-item">
            <i class="fas fa-home"></i>
            Dashboard
        </a>
        <a href="{{ route('propostas.create') }}" class="menu-item">
            <i class="fas fa-file-contract"></i>
            Criar Proposta Comercial
        </a>
        <a href="#" class="menu-item">
            <i class="fas fa-file-alt"></i>
            Relatórios
        </a>
    </div>

    <div class="menu-section">
        <div class="menu-section-title">Cadastros</div>
        <a href="{{ route('clientes.create') }}" class="menu-item">
            <i class="fas fa-user-plus"></i>
            Cadastrar Cliente
        </a>
        <a href="{{ route('clientes.index') }}" class="menu-item">
            <i class="fas fa-list"></i>
            Listar Clientes
        </a>
        <a href="{{ route('empresas.index') }}" class="menu-item">
            <i class="fas fa-building"></i>
            Listar Empresas
        </a>
        <a href="#" class="menu-item">
            <i class="fas fa-tasks"></i>
            Ver Todas OS
        </a>
        <a href="#" class="menu-item">
            <i class="fas fa-cog"></i>
            Configurações
        </a>
    </div>

    <div class="user-info">
        <div class="user-avatar">
            <i class="fas fa-user"></i>
        </div>
        <div class="user-details">
            <div class="user-name">{{ Auth::user()->name }}</div>
            <div class="user-role">{{ Auth::user()->role }}</div>
        </div>
    </div>
</div>
