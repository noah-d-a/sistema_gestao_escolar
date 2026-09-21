<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Secretaria');

// Contar alunos
$sql = "SELECT COUNT(*) as total FROM usuario WHERE perfil = 'Aluno' AND ativo = 1";
$stmt = $conexao->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_alunos = $row['total'] ?? 0;
$stmt->close();

// Contar professores
$sql = "SELECT COUNT(*) as total FROM usuario WHERE perfil = 'Professor' AND ativo = 1";
$stmt = $conexao->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_professores = $row['total'] ?? 0;
$stmt->close();

// Contar turmas
$sql = "SELECT COUNT(*) as total FROM turma";
$stmt = $conexao->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_turmas = $row['total'] ?? 0;
$stmt->close();

// Contar mensagens não lidas
$id_secretario = $_SESSION['id_usuario'];
$nome_secretario = $_SESSION['nome'] ?? 'Secretaria';
$sql = "SELECT nome FROM usuario WHERE id_usuario = ? AND perfil = 'Secretaria' AND ativo = 1";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_secretario);
$stmt->execute();
$result = $stmt->get_result();
$usuario_logado = $result->fetch_assoc();
if ($usuario_logado) {
    $nome_secretario = $usuario_logado['nome'];
    $_SESSION['nome'] = $nome_secretario;
}
$stmt->close();

$sql = "SELECT COUNT(*) as total FROM mensagem WHERE destinatario = ? AND lida = 0";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_secretario);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$mensagens_nao_lidas = $row['total'] ?? 0;
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria | Início</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #eef3fa;
            color: #1f2937;
        }
        nav { background: #0b1f3a; }
        main {
            max-width: 1180px;
            margin: 30px auto;
            padding: 0 20px 40px;
        }
        .topo {
            background: linear-gradient(135deg, #0d2d5c, #1465b0);
            border-radius: 18px;
            color: white;
            padding: 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }
        .topo h1 { margin: 0; font-size: 2rem; }
        .topo span {
            display: inline-block;
            background: rgba(255,255,255,0.12);
            padding: 7px 12px;
            border-radius: 999px;
            margin-bottom: 10px;
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        .painel {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }
        .box {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #e3e8ef;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.04);
        }
        .box .titulo {
            color: #6b7280;
            font-size: 0.82rem;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .box .valor {
            font-size: 2rem;
            font-weight: bold;
            color: #123d70;
        }
        .grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 22px;
        }
        .panel {
            background: #fff;
            border-radius: 18px;
            padding: 22px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.04);
        }
        .panel h2 {
            margin-top: 0;
            color: #123d70;
            font-size: 1.3rem;
        }
        .lista { list-style: none; margin: 0; padding: 0; }
        .lista li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #edf1f6;
        }
        .lista li:last-child { border-bottom: none; }
        .status {
            background: #e8f7ee;
            color: #147d3b;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: bold;
        }
        .status.atencao {
            background: #fff4e5;
            color: #b76a00;
        }
        .mensagem {
            background: #f9fbff;
            border: 1px solid #e9eef8;
            border-radius: 12px;
            padding: 12px 14px;
            margin-top: 12px;
        }
        .mensagem strong { display: block; margin-bottom: 4px; }
    </style>
</head>
<body>
    <?php include "../../includes/menu_secretaria.php"; ?>

    <main>
        <section class="topo">
            <h1>Bem-vindo, <?php echo htmlspecialchars($nome_secretario); ?>!</h1>
        </section>

        <section class="painel">
            <div class="box">
                <div class="titulo">Alunos ativos</div>
                <div class="valor"><?php echo number_format($total_alunos, 0, ',', '.'); ?></div>
            </div>
            <div class="box">
                <div class="titulo">Professores</div>
                <div class="valor"><?php echo number_format($total_professores, 0, ',', '.'); ?></div>
            </div>
            <div class="box">
                <div class="titulo">Turmas</div>
                <div class="valor"><?php echo number_format($total_turmas, 0, ',', '.'); ?></div>
            </div>
            <div class="box">
                <div class="titulo">Mensagens pendentes</div>
                <div class="valor"><?php echo $mensagens_nao_lidas; ?></div>
            </div>
        </section>
    </main>
</body>
</html>