<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';
verificar_perfil('Secretaria');

$tipos = ['aluno' => 'Alunos', 'professor' => 'Professores', 'coordenacao' => 'Coordenação', 'secretaria' => 'Secretaria', 'turma' => 'Turmas', 'disciplina' => 'Disciplinas'];
$tipo = strtolower(trim($_GET['tipo'] ?? ''));
$acao = strtolower(trim($_GET['acao'] ?? 'consultar'));
$turma = intval($_GET['turma'] ?? 0);
if (!isset($tipos[$tipo]) || !in_array($acao, ['consultar', 'atualizar', 'deletar'], true)) { header('Location: cadastros_secretaria.php'); exit(); }

$registros = [];
if ($tipo === 'aluno') {
    $sql = 'SELECT u.id_usuario AS id, u.nome, u.email, m.rm, t.nome AS turma_nome FROM usuario u JOIN matricula m ON m.id_aluno = u.id_usuario JOIN turma t ON t.id_turma = m.id_turma WHERE u.perfil = "Aluno" AND u.ativo = 1';
    if ($turma > 0) { $sql .= ' AND t.id_turma = ?'; }
    $sql .= ' ORDER BY u.nome';
    $stmt = $conexao->prepare($sql);
    if ($turma > 0) { $stmt->bind_param('i', $turma); }
} elseif (in_array($tipo, ['professor', 'coordenacao', 'secretaria'], true)) {
    $perfil = ['professor' => 'Professor', 'coordenacao' => 'Coordenação', 'secretaria' => 'Secretaria'][$tipo];
    $stmt = $conexao->prepare('SELECT id_usuario AS id, nome, email, cpf FROM usuario WHERE perfil = ? AND ativo = 1 ORDER BY nome');
    $stmt->bind_param('s', $perfil);
} elseif ($tipo === 'turma') {
    $stmt = $conexao->prepare('SELECT id_turma AS id, nome, ano_letivo, periodo FROM turma ORDER BY nome');
} else {
    $stmt = $conexao->prepare('SELECT id_disciplina AS id, nome, carga_horaria FROM disciplina ORDER BY nome');
}
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) { $registros[] = $row; }
$stmt->close();
$destino = $acao === 'consultar' ? 'consultar_secretaria.php' : ($acao === 'atualizar' ? 'atualizar_secretaria.php' : 'deletar_secretaria.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Secretaria | Consultas</title>
<style>
*{box-sizing:border-box} body{margin:0;font-family:Arial,sans-serif;background:#f3f7fb;color:#1f2937} main{max-width:1080px;margin:32px auto;padding:0 20px 40px}.header{background:linear-gradient(135deg,#0d3f75,#1a88c8);color:#fff;border-radius:18px;padding:26px 28px;margin-bottom:24px}.header h1{margin:0;font-size:2rem}.lista{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:18px}.item{display:block;text-decoration:none;background:#fff;border:1px solid #e2eaf6;border-radius:16px;padding:18px 20px;box-shadow:0 8px 20px rgba(15,23,42,.04);color:#1f2937}.item h2{margin:0 0 8px;color:#123d70;font-size:1.2rem}.item p{margin:5px 0;color:#5e6979;line-height:1.5}.vazio{background:#fff;padding:35px;border-radius:14px;color:#666;text-align:center}
</style>
</head>
<body>
<?php include '../../includes/menu_secretaria.php'; ?>
<main>
<section class="header"><h1><?php echo htmlspecialchars($tipos[$tipo]); ?></h1></section>
<?php if ($registros): ?><section class="lista">
<?php foreach ($registros as $registro): ?><a class="item" href="<?php echo $destino; ?>?tipo=<?php echo urlencode($tipo); ?>&acao=<?php echo urlencode($acao); ?>&id=<?php echo $registro['id']; ?><?php echo $turma > 0 ? '&turma=' . $turma : ''; ?>">
<h2><?php echo htmlspecialchars($registro['nome']); ?></h2>
<?php if ($tipo === 'aluno'): ?><p>RM: <?php echo htmlspecialchars($registro['rm']); ?></p><p>Turma: <?php echo htmlspecialchars($registro['turma_nome']); ?></p><?php elseif (isset($registro['email'])): ?><p><?php echo htmlspecialchars($registro['email'] ?? ''); ?></p><?php elseif ($tipo === 'turma'): ?><p><?php echo htmlspecialchars($registro['ano_letivo'] . ' - ' . $registro['periodo']); ?></p><?php else: ?><p>Carga horária: <?php echo htmlspecialchars($registro['carga_horaria']); ?>h</p><?php endif; ?></a><?php endforeach; ?></section>
<?php else: ?><div class="vazio">Nenhum registro encontrado.</div><?php endif; ?>
</main>
</body>
</html>
