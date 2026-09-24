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
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"><style>
*{box-sizing:border-box}body{margin:0;background:#f7f8fc;color:#202338;font-family:Inter,Arial,sans-serif}main{max-width:1110px;margin:0 auto;padding:44px 36px 70px}h1,h2{letter-spacing:-.04em}a:focus-visible,button:focus-visible,input:focus-visible,select:focus-visible{outline:3px solid #b6b4ff;outline-offset:2px}.header{background:none;color:#202338;padding:0;margin:0 0 26px;border-radius:0}.header:before{content:'INSTITUTO ATLAS / SECRETARIA';display:block;color:#6664df;font-size:11px;font-weight:800;letter-spacing:.14em;margin-bottom:12px}.header h1{font-size:clamp(26px,3vw,34px);line-height:1.2;margin:0}.box{background:#fff;border:1px solid #e7e9f1;border-radius:16px;padding:30px;box-shadow:0 8px 26px #1b224006}.acoes{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-top:25px}.acoes a,.acoes button{display:inline-flex;align-items:center;justify-content:center;border:0;border-radius:10px;padding:12px 18px;font:inherit;font-size:12px;font-weight:700;cursor:pointer;text-decoration:none}.principal{background:#6664df;color:#fff}.principal:hover{background:#5351c7}.secundario,.cancelar{background:#efeeff;color:#5653c4}.secundario:hover,.cancelar:hover{background:#e3e1ff}.erro,.sucesso{border-radius:10px;padding:14px 16px;margin-bottom:20px;font-size:13px}.erro{background:#fff1f2;color:#9e2738;border:1px solid #ffd5dc}.sucesso{background:#ecfdf3;color:#187448;border:1px solid #c8efd9}@media(max-width:800px){main{padding:78px 20px 48px}}@media(max-width:580px){.box{padding:20px}}.box{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:0 26px}.box p{min-width:0;margin:0;padding:17px 0;border-bottom:1px solid #eceef5;font-size:14px;line-height:1.5;overflow-wrap:anywhere}.box p strong{display:block;margin-bottom:6px;font-size:11px;letter-spacing:.025em;color:#777d93;font-weight:700}.box .acoes{grid-column:1/-1}@media(max-width:580px){.box{grid-template-columns:1fr}}
</style></head><body><?php include '../../includes/menu_secretaria.php'; ?><main><section class="header"><h1>Consultar <?php echo htmlspecialchars($tipos[$tipo]); ?></h1></section><section class="box">
<?php if ($tipo === 'aluno'): ?><?php campo('Nome', $registro['nome']); ?><?php campo('RM', $registro['rm']); ?><?php campo('Turma', $registro['turma_nome']); ?><?php campo('Ano letivo', $registro['ano_letivo']); ?><?php campo('Período', $registro['periodo']); ?><?php campo('Data da matrícula', $registro['data_matricula']); ?><?php campo('CPF', $registro['cpf']); ?><?php campo('E-mail', $registro['email']); ?><?php campo('Telefone', $registro['telefone']); ?><?php campo('Endereço', $registro['endereco']); ?>
<?php elseif (in_array($tipo, ['professor','coordenacao','secretaria'], true)): ?><?php campo('Nome', $registro['nome']); ?><?php campo('Perfil', $registro['perfil']); ?><?php campo('CPF', $registro['cpf']); ?><?php campo('RG', $registro['rg']); ?><?php campo('Data de nascimento', $registro['data_nascimento']); ?><?php campo('E-mail', $registro['email']); ?><?php campo('Telefone', $registro['telefone']); ?><?php campo('Endereço', $registro['endereco']); ?>
<?php elseif ($tipo === 'turma'): ?><?php campo('Nome', $registro['nome']); ?><?php campo('Ano letivo', $registro['ano_letivo']); ?><?php campo('Período', $registro['periodo']); ?>
<?php else: ?><?php campo('Nome', $registro['nome']); ?><?php campo('Carga horária', ($registro['carga_horaria'] ?? '') . ' horas'); ?><?php endif; ?>
<div class="acoes"><a class="principal" href="consultas_secretaria.php?tipo=<?php echo urlencode($tipo); ?>">Voltar</a></div></section></main></body></html>
