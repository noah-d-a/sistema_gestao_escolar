<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';
verificar_perfil('Secretaria');

$tipos = ['aluno' => 'Aluno', 'professor' => 'Professor', 'coordenacao' => 'Coordenação', 'secretaria' => 'Secretaria', 'turma' => 'Turma', 'disciplina' => 'Disciplina'];
$tipo = strtolower(trim($_GET['tipo'] ?? ''));
$id = intval($_GET['id'] ?? 0);
if (!isset($tipos[$tipo]) || $id <= 0) { header('Location: cadastros_secretaria.php'); exit(); }

if ($tipo === 'aluno') {
    $stmt = $conexao->prepare('SELECT u.*, m.rm, m.data_matricula, t.id_turma, t.nome AS turma_nome, t.ano_letivo, t.periodo FROM usuario u JOIN matricula m ON m.id_aluno = u.id_usuario JOIN turma t ON t.id_turma = m.id_turma WHERE u.id_usuario = ? AND u.perfil = "Aluno"');
} elseif (in_array($tipo, ['professor', 'coordenacao', 'secretaria'], true)) {
    $stmt = $conexao->prepare('SELECT * FROM usuario WHERE id_usuario = ? AND perfil = ?');
    $perfil = $tipos[$tipo];
    $stmt->bind_param('is', $id, $perfil);
} elseif ($tipo === 'turma') {
    $stmt = $conexao->prepare('SELECT * FROM turma WHERE id_turma = ?');
} else {
    $stmt = $conexao->prepare('SELECT * FROM disciplina WHERE id_disciplina = ?');
}
if ($tipo === 'aluno' || $tipo === 'turma' || $tipo === 'disciplina') { $stmt->bind_param('i', $id); }
$stmt->execute();
$registro = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$registro) { header('Location: consultas_secretaria.php?tipo=' . urlencode($tipo)); exit(); }
function campo($rotulo, $valor) { echo '<p><strong>' . htmlspecialchars($rotulo) . ':</strong> ' . htmlspecialchars((string) ($valor ?? 'Não informado')) . '</p>'; }
?>
<!DOCTYPE html>
<html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Secretaria | Consultar</title>
<style>
*{box-sizing:border-box}body{margin:0;font-family:Arial,sans-serif;background:#f3f7fb;color:#1f2937}main{max-width:900px;margin:32px auto;padding:0 20px 40px}.header{background:linear-gradient(135deg,#0d3f75,#1a88c8);color:white;border-radius:18px;padding:26px 28px;margin-bottom:24px}.header h1{margin:0;font-size:2rem}.box{background:#fff;border:1px solid #e2eaf5;border-radius:18px;padding:25px;box-shadow:0 10px 22px rgba(15,23,42,.04)}.box p{padding:10px 0;margin:0;border-bottom:1px solid #edf2f9}.acoes{display:flex;gap:12px;margin-top:22px}.acoes a{padding:11px 16px;border-radius:9px;text-decoration:none;background:#eaf3ff;color:#0b447d;font-weight:bold}.acoes .principal{background:#0d4a8f;color:#fff}
</style></head><body><?php include '../../includes/menu_secretaria.php'; ?><main><section class="header"><h1>Consultar <?php echo htmlspecialchars($tipos[$tipo]); ?></h1></section><section class="box">
<?php if ($tipo === 'aluno'): ?><?php campo('Nome', $registro['nome']); ?><?php campo('RM', $registro['rm']); ?><?php campo('Turma', $registro['turma_nome']); ?><?php campo('Ano letivo', $registro['ano_letivo']); ?><?php campo('Período', $registro['periodo']); ?><?php campo('Data da matrícula', $registro['data_matricula']); ?><?php campo('CPF', $registro['cpf']); ?><?php campo('E-mail', $registro['email']); ?><?php campo('Telefone', $registro['telefone']); ?><?php campo('Endereço', $registro['endereco']); ?>
<?php elseif (in_array($tipo, ['professor','coordenacao','secretaria'], true)): ?><?php campo('Nome', $registro['nome']); ?><?php campo('Perfil', $registro['perfil']); ?><?php campo('CPF', $registro['cpf']); ?><?php campo('RG', $registro['rg']); ?><?php campo('Data de nascimento', $registro['data_nascimento']); ?><?php campo('E-mail', $registro['email']); ?><?php campo('Telefone', $registro['telefone']); ?><?php campo('Endereço', $registro['endereco']); ?>
<?php elseif ($tipo === 'turma'): ?><?php campo('Nome', $registro['nome']); ?><?php campo('Ano letivo', $registro['ano_letivo']); ?><?php campo('Período', $registro['periodo']); ?>
<?php else: ?><?php campo('Nome', $registro['nome']); ?><?php campo('Carga horária', ($registro['carga_horaria'] ?? '') . ' horas'); ?><?php endif; ?>
<div class="acoes"><a class="principal" href="consultas_secretaria.php?tipo=<?php echo urlencode($tipo); ?>">Voltar</a></div></section></main></body></html>
