<?php
// Remover session_start() daqui pois já é chamado em index.php

function verificarSessao($nivel_requerido = 'usuario') {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['nivel_acesso'])) {
        header('Location: /login.php');
        exit;
    }

    if ($nivel_requerido === 'admin' && $_SESSION['nivel_acesso'] !== 'admin') {
        // Redirecionar para a página inicial com mensagem de erro
        header('Location: /index.php?erro=permissao');
        exit;
    }

    return true;
}

function verificarAdmin() {
    return verificarSessao('admin');
}

function verificarPermissaoRecuperacao() {
    // Verificar se o usuário tem permissão para acessar a recuperação de senha
    if (!isset($_SESSION['user_id'])) {
        return true; // Permite acesso para usuários não logados
    }
    
    if ($_SESSION['nivel_acesso'] === 'admin') {
        return true; // Permite acesso para administradores
    }
    
    header('Location: /index.php?erro=permissao');
    exit;
}
?>