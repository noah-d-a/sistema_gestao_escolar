<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Secretaria');

$id_secretario = $_SESSION['id_usuario'];
$mensagem = '';

$sql = "SELECT COUNT(*) AS total FROM usuario WHERE perfil = 'Secretaria' AND ativo = 1";
$stmt = $conexao->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$total_secretarias = (int) ($result->fetch_assoc()['total'] ?? 0);
$stmt->close();
$pode_editar = $total_secretarias <= 1;

// Buscar dados do secretário
$sql = "SELECT * FROM usuario WHERE id_usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_secretario);
$stmt->execute();
$result = $stmt->get_result();
$secretario = $result->fetch_assoc();
$stmt->close();

// Se enviar formulário
if (isset($_POST['salvar']) && $pode_editar) {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');
    
    if (!empty($nome) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = "UPDATE usuario SET nome = ?, email = ?, telefone = ?, endereco = ? WHERE id_usuario = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssssi", $nome, $email, $telefone, $endereco, $id_secretario);
        
        if ($stmt->execute()) {
            $mensagem = '<div style="background: #efe; color: #363; padding: 10px; border-radius: 5px; margin-bottom: 15px;">Cadastro atualizado com sucesso!</div>';
            $_SESSION['nome'] = $nome;
            $secretario['nome'] = $nome;
            $secretario['email'] = $email;
            $secretario['telefone'] = $telefone;
            $secretario['endereco'] = $endereco;
        }
        $stmt->close();
    } else {
        $mensagem = '<div style="background: #fee; color: #9d1c1c; padding: 10px; border-radius: 5px; margin-bottom: 15px;">Informe um nome e um e-mail válido.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria | Cadastro</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f6fb;
            color: #1f2937;
        }

        main {
            max-width: 980px;
            margin: 32px auto;
            padding: 0 20px 40px;
        }

        .topo {
            background: linear-gradient(135deg, #0d3d70, #1f8fd8);
            color: white;
            border-radius: 18px;
            padding: 28px 30px;
            margin-bottom: 26px;
            box-shadow: 0 10px 25px rgba(13, 61, 112, 0.18);
        }

        .topo h1 {
            margin: 0;
            font-size: 2rem;
        }

        .box {
            background: #fff;
            border: 1px solid #e2eaf5;
            border-radius: 18px;
            padding: 28px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.04);
        }

        form {
            display: grid;
            grid-template-columns: repeat(2, minmax(220px, 1fr));
            gap: 18px 22px;
        }

        .campo {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .campo.full {
            grid-column: 1 / -1;
        }

        label {
            font-weight: bold;
            color: #26405d;
        }

        input, select {
            width: 100%;
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

        .principal {
            background: #0d4a8f;
            color: white;
        }

        .secundario {
            background: #edf3ff;
            color: #154c82;
        }
    </style>
</head>
<body>
    <?php include "../../includes/menu_secretaria.php"; ?>

    <main>
        <section class="topo">
            <h1>Seu cadastro</h1>
        </section>

        <section class="box">
            <?php echo $mensagem; ?>
            <?php if (!$pode_editar): ?>
                <div style="background: #fff4e5; color: #8a5a00; padding: 10px; border-radius: 5px; margin-bottom: 15px;">Este cadastro é somente para visualização. Outro membro da Secretaria deve realizar alterações.</div>
            <?php endif; ?>
            <form method="POST">
                <div class="campo">
                    <label for="nome">Nome completo</label>
                    <input id="nome" name="nome" type="text" value="<?php echo htmlspecialchars($secretario['nome'] ?? ''); ?>" <?php echo $pode_editar ? '' : 'disabled'; ?> />
                </div>

                <div class="campo">
                    <label for="cpf">CPF</label>
                    <input id="cpf" type="text" value="<?php echo htmlspecialchars($secretario['cpf'] ?? ''); ?>" disabled />
                </div>

                <div class="campo">
                    <label for="rg">RG</label>
                    <input id="rg" type="text" value="<?php echo htmlspecialchars($secretario['rg'] ?? ''); ?>" disabled />
                </div>

                <div class="campo">
                    <label for="nascimento">Data de nascimento</label>
                    <input id="nascimento" type="date" value="<?php echo htmlspecialchars($secretario['data_nascimento'] ?? ''); ?>" disabled />
                </div>

                <div class="campo">
                    <label for="telefone">Telefone</label>
                    <input id="telefone" name="telefone" type="text" value="<?php echo htmlspecialchars($secretario['telefone'] ?? ''); ?>" <?php echo $pode_editar ? '' : 'disabled'; ?> />
                </div>

                <div class="campo full">
                    <label for="email">E-mail</label>
                    <input id="email" name="email" type="email" value="<?php echo htmlspecialchars($secretario['email'] ?? ''); ?>" <?php echo $pode_editar ? '' : 'disabled'; ?> />
                </div>

                <div class="campo full">
                    <label for="endereco">Endereço</label>
                    <input id="endereco" name="endereco" type="text" value="<?php echo htmlspecialchars($secretario['endereco'] ?? ''); ?>" <?php echo $pode_editar ? '' : 'disabled'; ?> />
                </div>

                <div class="botoes">
                    <?php if ($pode_editar): ?>
                        <button class="principal" type="submit" name="salvar" value="1">Salvar cadastro</button>
                        <button class="secundario" type="reset">Limpar</button>
                    <?php endif; ?>
                </div>
            </form>
        </section>
    </main>
</body>
</html>