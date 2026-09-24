<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';
verificar_perfil('Professor');
$id_professor = $_SESSION['id_usuario'];

$sql = "SELECT nome FROM usuario WHERE id_usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$prof = $stmt->get_result()->fetch_assoc();
$nome_prof = $prof['nome'] ?? 'Professor';
$stmt->close();

$sql = "SELECT COUNT(DISTINCT m.id_aluno) as total_alunos FROM matricula m JOIN turma_disciplina td ON m.id_turma = td.id_turma WHERE td.id_professor = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$alunos_row = $stmt->get_result()->fetch_assoc();
$total_alunos = (int)($alunos_row['total_alunos'] ?? 0);
$stmt->close();

$sql = "SELECT COUNT(DISTINCT t.id_turma) as turmas_ativas FROM turma t JOIN turma_disciplina td ON t.id_turma = td.id_turma WHERE td.id_professor = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$turmas_row = $stmt->get_result()->fetch_assoc();
$turmas_ativas = (int)($turmas_row['turmas_ativas'] ?? 0);
$stmt->close();

$dias_semana = [1 => 'Segunda', 2 => 'Terça', 3 => 'Quarta', 4 => 'Quinta', 5 => 'Sexta'];
$dia_semana = $dias_semana[date('N')] ?? '';
$sql = "SELECT COUNT(DISTINCT h.id_horario) as aulas_hoje FROM horario h JOIN turma_disciplina td ON h.id_turma_disciplina = td.id_turma_disciplina WHERE td.id_professor = ? AND h.dia_semana = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("is", $id_professor, $dia_semana);
$stmt->execute();
$aulas_row = $stmt->get_result()->fetch_assoc();
$aulas_hoje = (int)($aulas_row['aulas_hoje'] ?? 0);
$stmt->close();

$sql = "SELECT COUNT(*) as notas_pendentes FROM nota n JOIN turma_disciplina td ON n.id_turma_disciplina = td.id_turma_disciplina WHERE td.id_professor = ? AND (n.nota IS NULL OR n.nota = '')";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$notas_row = $stmt->get_result()->fetch_assoc();
$notas_pendentes = (int)($notas_row['notas_pendentes'] ?? 0);
$stmt->close();

$sql = "SELECT t.nome as turma_nome, d.nome as disciplina_nome, t.periodo, COUNT(DISTINCT m.id_aluno) as total_alunos, AVG(n.nota) as media
        FROM turma t
        JOIN turma_disciplina td ON t.id_turma = td.id_turma
        JOIN disciplina d ON td.id_disciplina = d.id_disciplina
        LEFT JOIN matricula m ON t.id_turma = m.id_turma
        LEFT JOIN nota n ON m.id_matricula = n.id_matricula AND n.id_turma_disciplina = td.id_turma_disciplina
        WHERE td.id_professor = ?
        GROUP BY t.nome, d.nome, t.periodo
        ORDER BY t.nome";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$result = $stmt->get_result();
$minhas_turmas = [];
while ($row = $result->fetch_assoc()) {
    $row['media'] = $row['media'] !== null ? number_format((float)$row['media'], 1, ',', '.') : '—';
    $minhas_turmas[] = $row;
}
$stmt->close();
function atlas_prof_esc($value) { return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Professor | Visão geral · Instituto Atlas</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box}body{background:var(--atlas-bg,#f7f8fc);color:var(--atlas-ink,#202338);font-family:Inter,Arial,sans-serif}.prof-main{max-width:1320px;margin:0 auto;padding:36px 60px 65px}.prof-top{display:flex;justify-content:space-between;align-items:center;gap:15px;margin-bottom:29px}.prof-eyebrow{font-size:10px;font-weight:750;letter-spacing:.12em;color:#858ba1}.prof-eyebrow b{color:#b5b9c7;margin:0 8px}.prof-pill{border:1px solid #e6e7f0;background:white;color:#777d93;border-radius:100px;padding:9px 13px;font-size:11px;font-weight:650}.prof-heading{display:flex;justify-content:space-between;gap:22px;align-items:flex-end;margin-bottom:29px}.prof-heading h1{font-size:clamp(28px,3vw,38px);letter-spacing:-.055em;line-height:1.16;margin:0 0 10px;font-weight:750}.prof-heading p{margin:0;color:#777d93;font-size:13px;line-height:1.7}.prof-heading .prof-label{display:inline-flex;background:#eeedff;color:#6664df;border-radius:100px;padding:9px 12px;font-size:11px;font-weight:700;white-space:nowrap}.prof-card{background:#fff;border:1px solid #e7e9f1;border-radius:16px;box-shadow:0 3px 18px rgba(30,36,74,.025)}.prof-hero{display:grid;grid-template-columns:minmax(0,1.6fr) minmax(280px,1fr);gap:20px}.prof-overview{padding:28px 29px;display:flex;flex-direction:column;min-height:286px}.prof-card-top{display:flex;align-items:center;justify-content:space-between;gap:10px}.prof-card h2{font-size:15px;letter-spacing:-.025em;margin:0;font-weight:700}.prof-muted{font-size:11px;color:#9197a8}.prof-big{font-size:clamp(54px,7vw,80px);letter-spacing:-.085em;line-height:1;margin:24px 0 7px;font-weight:750;font-variant-numeric:tabular-nums}.prof-big-label{color:#777d93;font-size:12px}.prof-stats{margin-top:auto;display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;padding-top:24px}.prof-stat{border-top:1px solid #e7e9f1;padding-top:17px;min-width:0}.prof-stat span{display:block;color:#777d93;font-size:11px;margin-bottom:8px}.prof-stat strong{font-size:25px;letter-spacing:-.05em;font-weight:750;display:block;font-variant-numeric:tabular-nums}.prof-stat small{display:block;color:#a0a5b4;font-size:10px;margin-top:6px}.prof-action{padding:28px;display:flex;flex-direction:column;justify-content:space-between;gap:20px;background:linear-gradient(150deg,#fff 52%,#f1f0ff 100%)}.prof-action-icon{width:45px;height:45px;border-radius:14px;display:grid;place-items:center;background:#eeedff;color:#6664df;font-size:24px}.prof-action h2{font-size:22px;line-height:1.3;letter-spacing:-.045em;max-width:280px}.prof-action p{font-size:12px;line-height:1.7;color:#777d93;margin:9px 0 0}.prof-action a{display:flex;align-items:center;justify-content:space-between;gap:10px;text-decoration:none;background:#6664df;color:#fff;border-radius:10px;padding:13px 15px;font-size:12px;font-weight:700}.prof-action a:hover{background:#514ecb}.prof-section{display:flex;justify-content:space-between;align-items:center;gap:10px;margin:35px 0 16px}.prof-section h2{font-size:17px;letter-spacing:-.035em;margin:0}.prof-section p{color:#777d93;font-size:12px;margin:6px 0 0}.prof-counter{background:#eeedff;color:#6664df;border-radius:8px;padding:8px 11px;font-size:11px;font-weight:700}.prof-table-card{overflow:hidden}.prof-table-scroll{overflow-x:auto}table{border-collapse:collapse;width:100%;min-width:660px;text-align:left}thead{background:#fafbfe}th{font-size:10px;letter-spacing:.075em;color:#858ba1;text-transform:uppercase;font-weight:750;padding:17px 22px;border-bottom:1px solid #e7e9f1}td{font-size:12px;color:#535a70;padding:19px 22px;border-bottom:1px solid #f0f1f6}tbody tr:last-child td{border-bottom:0}tbody tr:hover{background:#fafaff}td:first-child{font-weight:750;color:#25283d}.prof-subject{display:inline-flex;background:#f3f2ff;color:#625fc3;border-radius:7px;padding:7px 10px;font-weight:650}.prof-number{font-weight:750;color:#25283d;font-variant-numeric:tabular-nums}.prof-empty{padding:35px 24px;color:#777d93;font-size:13px;text-align:center}.prof-footer{margin-top:24px;color:#a1a6b5;font-size:10px;text-align:right}@media(max-width:1100px){.prof-hero{grid-template-columns:1fr}.prof-action{min-height:200px}.prof-action a{max-width:250px}}@media(max-width:800px){.prof-main{padding:76px 18px 35px}.prof-heading{align-items:flex-start;flex-direction:column}.prof-overview,.prof-action{padding:22px}.prof-top{margin-bottom:20px}th,td{padding:15px 17px}}@media(max-width:380px){.prof-stats{gap:8px}.prof-stat strong{font-size:21px}.prof-stat span{font-size:10px}}
</style></head><body>
<?php include '../../includes/menu_professor.php'; ?>
<main class="prof-main">
 <div class="prof-top"><span class="prof-eyebrow">INSTITUTO ATLAS <b>/</b> PORTAL DO PROFESSOR</span><span class="prof-pill"><?php echo atlas_prof_esc(date('Y')); ?></span></div>
 <header class="prof-heading"><div><h1>Visão geral<span style="color:#6664df">.</span></h1><p>Olá, <?php echo atlas_prof_esc($nome_prof); ?>. Acompanhe suas turmas e atividades em um só lugar.</p></div><span class="prof-label">Área do professor</span></header>
 <section class="prof-hero" aria-label="Resumo do professor">
  <article class="prof-card prof-overview"><div class="prof-card-top"><h2>Seu panorama acadêmico</h2><span class="prof-muted">Dados atuais</span></div><div class="prof-big"><?php echo $total_alunos; ?></div><div class="prof-big-label">Alunos vinculados às suas turmas</div><div class="prof-stats"><div class="prof-stat"><span>Turmas</span><strong><?php echo $turmas_ativas; ?></strong><small>Vinculadas</small></div><div class="prof-stat"><span>Aulas hoje</span><strong><?php echo $aulas_hoje; ?></strong><small>Na grade</small></div><div class="prof-stat"><span>Notas pendentes</span><strong><?php echo $notas_pendentes; ?></strong><small>Registros sem nota</small></div></div></article>
  <aside class="prof-card prof-action"><div class="prof-action-icon" aria-hidden="true">↗</div><div><h2>Organize suas avaliações.</h2><p>Consulte os lançamentos e acompanhe os registros de notas das suas turmas.</p></div><a href="notas_professor.php">Acessar notas <span aria-hidden="true">↗</span></a></aside>
 </section>
 <div class="prof-section"><div><h2>Minhas turmas</h2><p>Disciplinas atribuídas e desempenho registrado.</p></div><span class="prof-counter"><?php echo count($minhas_turmas); ?> vínculo(s)</span></div>
 <section class="prof-card prof-table-card" aria-label="Tabela de turmas">
 <?php if ($minhas_turmas): ?><div class="prof-table-scroll"><table><thead><tr><th>Turma</th><th>Disciplina</th><th>Período</th><th>Alunos</th><th>Média</th></tr></thead><tbody>
 <?php foreach ($minhas_turmas as $turma): ?><tr><td><?php echo atlas_prof_esc($turma['turma_nome']); ?></td><td><span class="prof-subject"><?php echo atlas_prof_esc($turma['disciplina_nome']); ?></span></td><td><?php echo atlas_prof_esc($turma['periodo']); ?></td><td class="prof-number"><?php echo (int)$turma['total_alunos']; ?></td><td class="prof-number"><?php echo atlas_prof_esc($turma['media']); ?></td></tr><?php endforeach; ?>
 </tbody></table></div><?php else: ?><div class="prof-empty">Nenhuma turma atribuída ao seu perfil até o momento.</div><?php endif; ?>
 </section><div class="prof-footer">Instituto Atlas · Portal acadêmico</div>
</main></body></html>
