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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
    *{box-sizing:border-box}body{margin:0;background:#f7f8fc;color:#202338;font-family:Inter,Arial,sans-serif}main{max-width:1240px;margin:0 auto;padding:44px 36px 70px}.eyebrow{font-size:11px;font-weight:800;letter-spacing:.14em;color:#6664df;text-transform:uppercase}.topo{display:flex;align-items:center;justify-content:space-between;gap:20px;margin-bottom:28px}.topo h1{font-size:clamp(25px,3vw,34px);letter-spacing:-.045em;margin:8px 0 7px}.topo p{font-size:13px;color:#777d93;margin:0}.topo .tag{font-size:11px;font-weight:700;color:#5653c4;background:#eeedff;padding:10px 14px;border-radius:999px}.painel{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px;margin-bottom:30px}.box{border:1px solid #e7e9f1;border-radius:16px;padding:22px;background:#fff;box-shadow:0 8px 26px #1b224006}.box .titulo{font-size:11px;letter-spacing:.08em;font-weight:750;color:#777d93;text-transform:uppercase;margin-bottom:18px}.box .valor{font-size:32px;font-weight:800;letter-spacing:-.06em;color:#252741}.box .detail{font-size:11px;color:#969bb0;margin-top:12px}.section-head{margin:0 0 17px}.section-head h2{font-size:18px;letter-spacing:-.035em;margin:0 0 5px}.section-head p{font-size:12px;color:#777d93;margin:0}.actions{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:15px}.action{display:block;text-decoration:none;color:#252741;background:#fff;border:1px solid #e7e9f1;border-radius:15px;padding:23px;transition:transform .15s,border-color .15s}.action:hover{transform:translateY(-2px);border-color:#aaa8ff}.action .symbol{display:grid;place-items:center;width:37px;height:37px;background:#efeeff;color:#6664df;border-radius:10px;font-size:18px;margin-bottom:18px}.action strong{display:block;font-size:14px;margin-bottom:8px}.action span:last-child{font-size:12px;line-height:1.6;color:#777d93}@media(max-width:1100px){.painel{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:800px){main{padding:78px 20px 45px}.topo{align-items:flex-start}.actions{grid-template-columns:1fr}}@media(max-width:480px){.painel{grid-template-columns:1fr}.topo .tag{display:none}}
    </style>
</head>
<body>
    <?php include "../../includes/menu_secretaria.php"; ?>

    <main>
        <header class="topo"><div><div class="eyebrow">Instituto Atlas / Secretaria</div><h1>Olá, <?php echo htmlspecialchars(explode(' ', trim($nome_secretario))[0], ENT_QUOTES, 'UTF-8'); ?>.</h1><p>Visão geral e acesso rápido às atividades administrativas.</p></div><span class="tag">Painel administrativo</span></header>

        <section class="painel">
            <div class="box">
                <div class="titulo">Alunos ativos</div>
                <div class="valor"><?php echo number_format($total_alunos, 0, ',', '.'); ?></div><div class="detail">Estudantes com cadastro ativo</div>
            </div>
            <div class="box">
                <div class="titulo">Professores</div>
                <div class="valor"><?php echo number_format($total_professores, 0, ',', '.'); ?></div><div class="detail">Profissionais ativos</div>
            </div>
            <div class="box">
                <div class="titulo">Turmas</div>
                <div class="valor"><?php echo number_format($total_turmas, 0, ',', '.'); ?></div><div class="detail">Turmas registradas</div>
            </div>
            <div class="box">
                <div class="titulo">Mensagens pendentes</div>
                <div class="valor"><?php echo (int)$mensagens_nao_lidas; ?></div><div class="detail">Mensagens não lidas</div>
            </div>
        </section>
        <section aria-labelledby="acessos"><div class="section-head"><h2 id="acessos">Acesso rápido</h2><p>Escolha uma área para continuar seu trabalho.</p></div><div class="actions"><a class="action" href="cadastros_secretaria.php"><span class="symbol" aria-hidden="true">＋</span><strong>Gerenciar cadastros</strong><span>Consultar, cadastrar e atualizar registros da escola.</span></a><a class="action" href="relacoes_secretaria.php"><span class="symbol" aria-hidden="true">↔</span><strong>Relações acadêmicas</strong><span>Organizar os vínculos entre turmas, professores e disciplinas.</span></a><a class="action" href="editar_horario_secretaria.php"><span class="symbol" aria-hidden="true">◷</span><strong>Gerenciar horários</strong><span>Consultar e organizar os horários cadastrados.</span></a><a class="action" href="questionarios_secretaria.php"><span class="symbol" aria-hidden="true">☷</span><strong>Questionários</strong><span>Acessar os questionários da secretaria.</span></a><a class="action" href="mensagens_secretaria.php"><span class="symbol" aria-hidden="true">✉</span><strong>Mensagens</strong><span>Verificar comunicações e mensagens recebidas.</span></a><a class="action" href="cadastro_secretaria.php"><span class="symbol" aria-hidden="true">♙</span><strong>Meu cadastro</strong><span>Consultar seus dados pessoais cadastrados.</span></a></div></section>
    </main>
</body>
</html>