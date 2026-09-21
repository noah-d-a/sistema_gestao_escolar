<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';
verificar_perfil('Secretaria');
$tipo = strtolower(trim($_GET['tipo'] ?? 'aluno'));
$acao = strtolower(trim($_GET['acao'] ?? 'consultar'));
if ($tipo !== 'aluno' || !in_array($acao, ['consultar', 'atualizar', 'deletar'], true)) {
    header('Location: cadastros_secretaria.php');
    exit();
}
$turmas = [];
$result = $conexao->query('SELECT id_turma, nome, ano_letivo, periodo FROM turma ORDER BY nome');
while ($row = $result->fetch_assoc()) {
    $turmas[] = $row;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria | Selecionar turma</title>
    <style>
        * { box-sizing: border-box; } body { margin: 0; font-family: Arial, sans-serif; background: #f3f6fb; color: #1f2937; }
        main { max-width: 1000px; margin: 32px auto; padding: 0 20px 40px; } .header { background: linear-gradient(135deg,#0d3d70,#1f8fd8); color: #fff; border-radius: 18px; padding: 28px; margin-bottom: 24px; } .header h1 { margin: 0; font-size: 2rem; }
        .lista { display: grid; grid-template-columns: repeat(auto-fit,minmax(230px,1fr)); gap: 18px; } .item { display:block; text-decoration:none; background:#fff; border:1px solid #e2eaf5; border-radius:16px; padding:20px; color:#123d70; box-shadow:0 8px 20px rgba(15,23,42,.05); } .item h2 { margin:0 0 8px; } .item p { margin:0; color:#657286; }
    </style>
</head>
<body>
<?php include '../../includes/menu_secretaria.php'; ?>
<main>
    <section class="header"><h1>Selecione a turma</h1></section>
    <section class="lista">
        <?php foreach ($turmas as $turma): ?>
            <a class="item" href="consultas_secretaria.php?tipo=aluno&acao=<?php echo urlencode($acao); ?>&turma=<?php echo $turma['id_turma']; ?>">
                <h2><?php echo htmlspecialchars($turma['nome']); ?></h2>
                <p><?php echo htmlspecialchars($turma['ano_letivo'] . ' - ' . $turma['periodo']); ?></p>
            </a>
        <?php endforeach; ?>
    </section>
    <?php if (!$turmas): ?><p style="background:#fff;padding:30px;border-radius:14px;color:#666;">Nenhuma turma cadastrada.</p><?php endif; ?>
</main>
</body>
</html>
