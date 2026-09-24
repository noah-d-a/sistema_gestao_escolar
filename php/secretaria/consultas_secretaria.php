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
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box}body{margin:0;background:#f7f8fc;color:#202338;font-family:Inter,Arial,sans-serif}main{max-width:1190px;margin:0 auto;padding:44px 36px 70px}h1,h2{letter-spacing:-.04em}a:focus-visible,button:focus-visible,input:focus-visible,select:focus-visible{outline:3px solid #b6b4ff;outline-offset:2px}.topo,.header{margin:0 0 28px;padding:0;background:none;color:#202338;border-radius:0}.topo:before,.header:before{content:'INSTITUTO ATLAS / SECRETARIA';display:block;color:#6664df;font-size:11px;font-weight:800;letter-spacing:.14em;margin-bottom:12px}.topo h1,.header h1{font-size:clamp(25px,3vw,34px);line-height:1.2;margin:0}.box{background:#fff;border:1px solid #e7e9f1;border-radius:16px;padding:30px;box-shadow:0 8px 26px #1b224006}.box:before{content:'DADOS DO REGISTRO';display:block;font-size:11px;letter-spacing:.12em;font-weight:800;color:#777d93;margin-bottom:24px}form{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px}.campo{display:flex;flex-direction:column;gap:8px}.full,.botoes{grid-column:1/-1}label{font-size:12px;font-weight:700;color:#363a52}input,select{width:100%;min-height:45px;padding:11px 13px;border-radius:10px;border:1px solid #e1e4f0;background:#fff;font:inherit;font-size:13px;color:#252741}input:hover,select:hover{border-color:#b4b3e7}.botoes{display:flex;gap:10px;flex-wrap:wrap;margin-top:8px}button{font:inherit;border:0;border-radius:10px;padding:12px 18px;font-size:12px;font-weight:700;cursor:pointer}.principal{background:#6664df;color:#fff}.principal:hover{background:#5351c7}.secundario{background:#efeeff;color:#5653c4}.secundario:hover{background:#e3e1ff}.lista{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:20px}.item{display:block;text-decoration:none;background:#fff;border:1px solid #e7e9f1;border-radius:15px;padding:28px;min-height:175px;color:#252741;transition:border-color .16s,transform .16s}.item:hover{border-color:#aaa8ff;transform:translateY(-2px)}.item h2{margin:0 0 10px;font-size:19px}.item p{margin:5px 0;color:#777d93;font-size:13px;line-height:1.6}.item:after{content:'Ver detalhes  →';display:block;margin-top:19px;color:#6664df;font-size:12px;font-weight:700}.vazio{background:#fff;border:1px solid #e7e9f1;padding:32px;border-radius:15px;color:#777d93}.back{display:inline-block;color:#6664df;font-size:12px;font-weight:700;text-decoration:none;margin-bottom:16px}.back:hover{text-decoration:underline}@media(max-width:800px){main{padding:78px 20px 48px}}@media(max-width:900px){.lista{grid-template-columns:repeat(2,1fr)}}@media(max-width:580px){form{grid-template-columns:1fr}.box{padding:20px}.lista{grid-template-columns:1fr}}
</style>
</head>
<body>
<?php include '../../includes/menu_secretaria.php'; ?>
<main>
<a class="back" href="acoes_secretaria.php?tipo=<?php echo urlencode($tipo); ?>">← Voltar às ações</a>
<section class="header"><h1><?php echo htmlspecialchars($tipos[$tipo]); ?> · <?php echo htmlspecialchars(["consultar"=>"Consultar", "atualizar"=>"Atualizar", "deletar"=>"Excluir"][$acao]); ?></h1></section>
<?php if ($registros): ?><section class="lista">
<?php foreach ($registros as $registro): ?><a class="item" href="<?php echo $destino; ?>?tipo=<?php echo urlencode($tipo); ?>&acao=<?php echo urlencode($acao); ?>&id=<?php echo $registro['id']; ?><?php echo $turma > 0 ? '&turma=' . $turma : ''; ?>">
<h2><?php echo htmlspecialchars($registro['nome']); ?></h2>
<?php if ($tipo === 'aluno'): ?><p>RM: <?php echo htmlspecialchars($registro['rm']); ?></p><p>Turma: <?php echo htmlspecialchars($registro['turma_nome']); ?></p><?php elseif (isset($registro['email'])): ?><p><?php echo htmlspecialchars($registro['email'] ?? ''); ?></p><?php elseif ($tipo === 'turma'): ?><p><?php echo htmlspecialchars($registro['ano_letivo'] . ' - ' . $registro['periodo']); ?></p><?php else: ?><p>Carga horária: <?php echo htmlspecialchars($registro['carga_horaria']); ?>h</p><?php endif; ?></a><?php endforeach; ?></section>
<?php else: ?><div class="vazio">Nenhum registro encontrado.</div><?php endif; ?>
</main>
</body>
</html>
