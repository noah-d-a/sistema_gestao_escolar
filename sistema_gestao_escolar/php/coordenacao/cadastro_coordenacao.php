<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Coordenação');

$id_coordenador = $_SESSION['id_usuario'];

// Buscar dados do coordenador
$sql = "SELECT * FROM usuario WHERE id_usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_coordenador);
$stmt->execute();
$result = $stmt->get_result();
$coordenador = $result->fetch_assoc();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordenação | Cadastro</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f7fb;
            color: #1f2937;
        }
        nav { background: #1b2d4d; }
        main {
            max-width: 980px;
            margin: 32px auto;
            padding: 0 20px 40px;
        }
        .topo {
            background: linear-gradient(135deg, #1b3d70, #3d6bb1);
            color: white;
            border-radius: 18px;
            padding: 26px 28px;
            margin-bottom: 24px;
        }
        .topo h1 { margin: 0; font-size: 2rem; }
        .box {
            background: white;
            border-radius: 18px;
            border: 1px solid #e3ebf7;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.05);
            padding: 28px;
        }
        form {
            display: grid;
            grid-template-columns: repeat(2, minmax(220px, 1fr));
            gap: 18px 22px;
        }
        .campo { display: flex; flex-direction: column; gap: 7px; }
        .campo.full { grid-column: 1 / -1; }
        label {
            font-weight: bold;
            color: #2c4564;
        }
        input, select {
            padding: 11px 12px;
            border-radius: 10px;
            border: 1px solid #dfe8f4;
            background: #f9fbff;
            font-size: 0.95rem;
        }
        .botoes {
            grid-column: 1 / -1;
            display: flex;
            gap: 12px;
            margin-top: 8px;
        }
        button {
            border: none;
            border-radius: 10px;
            padding: 12px 18px;
            font-weight: bold;
            cursor: pointer;
        }
        .principal { background: #1d4d8a; color: white; }
        .secundario { background: #edf3ff; color: #17477c; }
    </style>
</head>
<body>
    <?php include "../../includes/menu_coordenacao.php"; ?>

    <main>
        <section class="topo">
            <h1>Meu Perfil</h1>
        </section>

        <section class="box">
            <div style="background: #edf5ff; color: #17477c; padding: 10px; border-radius: 5px; margin-bottom: 15px;">Este cadastro é somente para consulta.</div>
            <div class="formulario">
                <div class="campo">
                    <label for="perfil">Perfil</label>
                    <select id="perfil" disabled>
                        <option><?php echo htmlspecialchars($coordenador['perfil'] ?? 'Coordenação'); ?></option>
                    </select>
                </div>

                <div class="campo">
                    <label for="nome">Nome completo</label>
                    <input id="nome" type="text" value="<?php echo htmlspecialchars($coordenador['nome'] ?? ''); ?>" disabled />
                </div>

                <div class="campo">
                    <label for="cpf">CPF</label>
                    <input id="cpf" type="text" value="<?php echo htmlspecialchars($coordenador['cpf'] ?? ''); ?>" disabled />
                </div>

                <div class="campo">
                    <label for="rg">RG</label>
                    <input id="rg" type="text" value="<?php echo htmlspecialchars($coordenador['rg'] ?? ''); ?>" disabled />
                </div>

                <div class="campo">
                    <label for="nascimento">Data de nascimento</label>
                    <input id="nascimento" type="date" value="<?php echo htmlspecialchars($coordenador['data_nascimento'] ?? ''); ?>" disabled />
                </div>

                <div class="campo">
                    <label for="telefone">Telefone</label>
                    <input id="telefone" type="text" value="<?php echo htmlspecialchars($coordenador['telefone'] ?? ''); ?>" disabled />
                </div>

                <div class="campo full">
                    <label for="email">E-mail</label>
                    <input id="email" type="email" value="<?php echo htmlspecialchars($coordenador['email'] ?? ''); ?>" disabled />
                </div>

                <div class="campo full">
                    <label for="endereco">Endereço</label>
                    <input id="endereco" type="text" value="<?php echo htmlspecialchars($coordenador['endereco'] ?? ''); ?>" disabled />
                </div>

            </div>
        </section>
    </main>
</body>
</html>
