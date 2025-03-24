<?php
try {
    $pdo = new PDO(
        'mysql:host=127.0.0.1;dbname=nome_do_seu_banco',
        'root',
        ''
    );
    echo "Conexão bem-sucedida!";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}