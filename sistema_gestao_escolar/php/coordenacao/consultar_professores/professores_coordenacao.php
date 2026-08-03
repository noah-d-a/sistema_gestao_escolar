<?php
include "conexao.php";

$comando = "SELECT id, nome FROM usuario WHERE perfil = 'Professor'";
$lista = $conexao->query($comando);

while ($professor = $lista->fetch_assoc()) {
    echo "
        <div>
            <a href='professor.php?professor={$professor['id']}'>
                <p>$professor['nome']</p>
            </a>
        </div>
    ";
}
?>