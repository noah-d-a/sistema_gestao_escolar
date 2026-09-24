<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';
verificar_perfil('Coordenação');
function esc($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
$id_turma = max(0, (int)($_GET['turma'] ?? 0));
$turmas = [];
$r = $conexao->query('SELECT id_turma, nome, ano_letivo FROM turma ORDER BY ano_letivo DESC, nome');
if ($r) { while ($t = $r->fetch_assoc()) $turmas[] = $t; $r->free(); }
$turma_nome = '';
foreach ($turmas as $t) if ((int)$t['id_turma'] === $id_turma) $turma_nome = $t['nome'];
$alunos = [];
if ($id_turma && $turma_nome !== '') {
    // Subconsultas independentes evitam multiplicar notas por registros de presença.
    $sql = "SELECT m.id_matricula, m.rm, u.nome, u.id_usuario,
        (SELECT ROUND(AVG(n.nota), 2) FROM nota n JOIN turma_disciplina td ON td.id_turma_disciplina = n.id_turma_disciplina WHERE n.id_matricula = m.id_matricula AND td.id_turma = m.id_turma) AS media_notas,
        (SELECT ROUND(100 * AVG(f.presente), 1) FROM frequencia f JOIN turma_disciplina td ON td.id_turma_disciplina = f.id_turma_disciplina WHERE f.id_matricula = m.id_matricula AND td.id_turma = m.id_turma) AS frequencia_perc,
        (SELECT COUNT(*) FROM nota n JOIN turma_disciplina td ON td.id_turma_disciplina = n.id_turma_disciplina WHERE n.id_matricula = m.id_matricula AND td.id_turma = m.id_turma) AS total_notas,
        (SELECT COUNT(*) FROM frequencia f JOIN turma_disciplina td ON td.id_turma_disciplina = f.id_turma_disciplina WHERE f.id_matricula = m.id_matricula AND td.id_turma = m.id_turma) AS total_presencas
        FROM matricula m JOIN usuario u ON u.id_usuario = m.id_aluno WHERE m.id_turma = ? ORDER BY u.nome";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('i', $id_turma);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) $alunos[] = $row;
    $stmt->close();
}
$com_notas = 0; $com_frequencia = 0; $soma_notas = 0; $soma_frequencia = 0;
foreach ($alunos as $a) {
    if ($a['media_notas'] !== null) { $com_notas++; $soma_notas += (float)$a['media_notas']; }
    if ($a['frequencia_perc'] !== null) { $com_frequencia++; $soma_frequencia += (float)$a['frequencia_perc']; }
}
function numero($n, $casas = 1) { return number_format((float)$n, $casas, ',', '.'); }
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Coordenação | Alunos</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box}body{margin:0;background:#f6f7fb;color:#202337;font-family:Inter,Arial,sans-serif}main{max-width:1220px;margin:32px auto;padding:0 22px 50px}.topo,.painel,.indicador{background:#fff;border:1px solid #e8e9f0;border-radius:17px}.topo{padding:29px;margin-bottom:22px}.sobretitulo{font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:#7654d8;font-weight:800}.topo h1{font-size:29px;letter-spacing:-.8px;margin:8px 0}.muted{color:#73778b;font-size:13px;line-height:1.6}.filtro{display:flex;align-items:end;gap:12px;flex-wrap:wrap;margin:20px 0}.filtro label{font-size:12px;font-weight:700;display:block;margin-bottom:7px}.filtro select{width:min(100%,350px);min-width:230px;background:white;border:1px solid #dddfea;border-radius:10px;padding:12px;color:#25243b;font:inherit;font-size:13px}.indicadores{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;margin-bottom:20px}.indicador{padding:20px}.indicador strong{font-size:26px;display:block;margin-top:10px;letter-spacing:-1px}.indicador span{font-size:12px;color:#72768b;font-weight:600}.painel{overflow:hidden}.painel-head{padding:21px 23px;border-bottom:1px solid #ececf2}.painel-head h2{margin:0 0 4px;font-size:16px}.table-wrap{overflow-x:auto}table{width:100%;border-collapse:collapse;text-align:left;min-width:670px}th{background:#fafafe;color:#77798d;font-size:10px;text-transform:uppercase;letter-spacing:.07em}td,th{padding:16px 22px;border-bottom:1px solid #eff0f4}td{font-size:13px}tbody tr:last-child td{border-bottom:0}.name{font-weight:700}.rm{font-size:11px;color:#8a8c9b;margin-top:4px}.pill{display:inline-block;padding:6px 10px;border-radius:8px;font-size:11px;font-weight:700;background:#f1edfc;color:#6747c0}.pill.neutral{background:#f0f1f5;color:#77798b}.vazio{padding:44px 24px;text-align:center;color:#7a7d8e;font-size:13px}.nota{padding:16px 23px;color:#86899a;font-size:11px;border-top:1px solid #eff0f4}@media(max-width:680px){main{margin:16px auto;padding:0 14px 30px}.topo{padding:22px}.indicadores{grid-template-columns:1fr}.indicador{padding:16px}.filtro select{width:100%}}
</style></head><body>
<?php include '../../includes/menu_coordenacao.php'; ?>
<main><section class="topo"><div class="sobretitulo">Acompanhamento pedagógico</div><h1>Alunos<?php if ($turma_nome !== '') echo ' · '.esc($turma_nome); ?></h1><div class="muted">Consulte o desempenho e a frequência dos estudantes por turma.</div></section>
<form class="filtro" method="get"><div><label for="turma">Selecionar turma</label><select id="turma" name="turma" onchange="this.form.submit()"><option value="">Escolha uma turma</option><?php foreach ($turmas as $t): ?><option value="<?= (int)$t['id_turma'] ?>" <?= $id_turma === (int)$t['id_turma'] ? 'selected' : '' ?>><?= esc($t['nome']) ?> · <?= esc($t['ano_letivo']) ?></option><?php endforeach; ?></select></div></form>
<?php if ($turma_nome !== ''): ?>
<div class="indicadores"><div class="indicador"><span>Alunos matriculados</span><strong><?= count($alunos) ?></strong></div><div class="indicador"><span>Média das notas dos alunos</span><strong><?= $com_notas ? numero($soma_notas/$com_notas,2) : '—' ?></strong></div><div class="indicador"><span>Frequência média dos alunos</span><strong><?= $com_frequencia ? numero($soma_frequencia/$com_frequencia).'%' : '—' ?></strong></div></div>
<section class="painel"><div class="painel-head"><h2>Estudantes da turma</h2><div class="muted">Indicadores calculados a partir dos registros existentes.</div></div><?php if ($alunos): ?><div class="table-wrap"><table><thead><tr><th>Aluno</th><th>Nota média</th><th>Frequência</th><th>Registros de notas</th><th>Registros de presença</th></tr></thead><tbody><?php foreach ($alunos as $a): ?><tr><td><div class="name"><?= esc($a['nome']) ?></div><div class="rm">RM <?= esc($a['rm']) ?></div></td><td><span class="pill <?= $a['media_notas'] === null ? 'neutral' : '' ?>"><?= $a['media_notas'] === null ? 'Sem notas' : numero($a['media_notas'],2) ?></span></td><td><span class="pill <?= $a['frequencia_perc'] === null ? 'neutral' : '' ?>"><?= $a['frequencia_perc'] === null ? 'Sem registros' : numero($a['frequencia_perc']).'%' ?></span></td><td><?= (int)$a['total_notas'] ?></td><td><?= (int)$a['total_presencas'] ?></td></tr><?php endforeach; ?></tbody></table></div><?php else: ?><div class="vazio">Nenhum aluno matriculado nesta turma.</div><?php endif; ?><div class="nota">A média considera os lançamentos de notas disponíveis. A frequência considera os registros de presença; ausência de registros não é tratada como 100%.</div></section>
<?php else: ?><section class="painel"><div class="vazio"><?= $id_turma ? 'Turma não encontrada. Selecione uma turma válida.' : 'Selecione uma turma acima para visualizar os alunos e seus indicadores.' ?></div></section><?php endif; ?>
</main></body></html>
