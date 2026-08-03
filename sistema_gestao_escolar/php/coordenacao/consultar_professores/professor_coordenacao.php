<?php
include "conexao.php";

$id = (int) $_GET['professor'];
$comando = "SELECT nome FROM usuario WHERE id = $id";

?>