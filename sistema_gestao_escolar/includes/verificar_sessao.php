<?php
// Verificar se o usuário está autenticado
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['perfil'])) {
    header('Location: ../login.php');
    exit();
}

// Função para verificar se o usuário tem um perfil específico
function verificar_perfil($perfil_requerido) {
    if ($_SESSION['perfil'] !== $perfil_requerido) {
        header('HTTP/1.1 403 Forbidden');
        echo "Acesso negado.";
        exit();
    }
}

// Função para verificar múltiplos perfis
function verificar_perfis($perfis_requeridos) {
    if (!in_array($_SESSION['perfil'], $perfis_requeridos)) {
        header('HTTP/1.1 403 Forbidden');
        echo "Acesso negado.";
        exit();
    }
}

// Função para sair da sessão
function logout() {
    session_destroy();
    header('Location: ../login.php');
    exit();
}
?>
