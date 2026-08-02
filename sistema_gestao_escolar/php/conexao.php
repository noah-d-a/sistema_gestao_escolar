<?php
date_default_timezone_set('America/Sao_Paulo');

$conexao = new mysqli("localhost", "root", "", "sistema_gestao_escolar");

if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
}

$conexao->set_charset($conexao, "utf8mb4");
?>
