<?php
// Remover session_start() daqui pois já é chamado em index.php

function verificarSessao($nivel_requerido = 'usuario') {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['nivel_acesso'])) {
        header('Location: /DashControlWeb/login.php');
        exit;
    }

    if ($nivel_requerido === 'admin' && $_SESSION['nivel_acesso'] !== 'admin') {
        header('Location: /DashControlWeb/index.php?erro=permissao');
        exit;
    }

    return true;
}

function verificarAdmin() {
    return verificarSessao('admin');
}
?>