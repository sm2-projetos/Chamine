<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Gestão</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <img src="https://www.galaxcms.com.br/up_crud_comum/2065/logo-20180522144628.png" alt="Logo">
                <h2>Bem-vindo</h2>
                <p>Faça login para acessar o sistema</p>
            </div>
            
            <form action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <i class="fas fa-user"></i>
                    <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Senha</label>
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
                </div>
                
                <button type="submit" class="login-btn">Entrar</button>
                
                @if ($errors->any())
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="forgot-password">
                    <a href="#">Esqueceu sua senha?</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>