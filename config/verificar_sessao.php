<?php
session_start();

function verificarSessao($nivel_requerido = 'usuario') {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['nivel_acesso'])) {
        header('Location: /login.html');
        exit;
    }

    if ($nivel_requerido === 'admin' && $_SESSION['nivel_acesso'] !== 'admin') {
        header('Location: /index.php?erro=permissao');
        exit;
    }

    return true;
}

function verificarAdmin() {
    return verificarSessao('admin');
}
?>