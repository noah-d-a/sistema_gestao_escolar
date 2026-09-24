<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';
verificar_perfil('Aluno');
$id_aluno = $_SESSION['id_usuario'];

// Consultar dados da turma (consulta original preservada).
$sql = "SELECT t.ano_letivo FROM matricula m JOIN turma t ON m.id_turma = t.id_turma WHERE m.id_aluno = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $id_aluno);
$stmt->execute();
$result = $stmt->get_result();
$turma_row = $result->fetch_assoc();
$ano_letivo = $turma_row['ano_letivo'] ?? date('Y');
$stmt->close();

// Estatísticas originais: aprovados e reprovados contam registros de notas, não disciplinas.
$sql = "SELECT AVG(n.nota) as media_geral,
               SUM(CASE WHEN n.nota >= 6 THEN 1 ELSE 0 END) as aprovados,
               SUM(CASE WHEN n.nota < 4 THEN 1 ELSE 0 END) as reprovados
        FROM nota n
        JOIN matricula m ON n.id_matricula = m.id_matricula
        WHERE m.id_aluno = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $id_aluno);
$stmt->execute();
$result = $stmt->get_result();
$stats = $result->fetch_assoc();
$media_geral = $stats['media_geral'] !== null ? number_format((float)$stats['media_geral'], 1) : '—';
$aprovados = $stats['aprovados'] ?? 0;
$reprovados = $stats['reprovados'] ?? 0;
$stmt->close();

// Buscar disciplinas com notas (consulta e regra de situação originais preservadas).
$sql = "SELECT d.nome, u.nome as professor_nome,
               GROUP_CONCAT(DISTINCT n.avaliacao) as avaliacoes,
               AVG(n.nota) as media
        FROM nota n
        JOIN matricula m ON n.id_matricula = m.id_matricula
        JOIN turma_disciplina td ON n.id_turma_disciplina = td.id_turma_disciplina
        JOIN disciplina d ON td.id_disciplina = d.id_disciplina
        JOIN usuario u ON td.id_professor = u.id_usuario
        WHERE m.id_aluno = ?
        GROUP BY d.nome, u.nome
        ORDER BY d.nome";
$stmt = $conexao->prepare($sql);
$stmt->bind_param('i', $id_aluno);
$stmt->execute();
$result = $stmt->get_result();
$disciplinas = [];
while ($row = $result->fetch_assoc()) {
    $row['media'] = number_format((float)$row['media'], 1);
    $row['situacao'] = $row['media'] >= 6 ? 'Aprovado' : ($row['media'] >= 4 ? 'Recuperação' : 'Reprovado');
    $disciplinas[] = $row;
}
$stmt->close();
function atlas_escape($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Boletim | Instituto Atlas</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--atlas-accent:#6664df;--atlas-ink:#202338;--atlas-muted:#777d93;--atlas-line:#e7e9f1;--atlas-bg:#f7f8fc}
*{box-sizing:border-box}
body{background:var(--atlas-bg);color:var(--atlas-ink);font-family:Inter,Arial,sans-serif}
button,input{font:inherit}
.boletim-main{width:min(1320px,100%);margin:0 auto;padding:36px clamp(20px,4vw,60px) 65px}
.boletim-topline{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:26px}
.boletim-eyebrow{font-size:10px;letter-spacing:.15em;color:#9297a8;font-weight:750}
.boletim-year{font-size:12px;border:1px solid var(--atlas-line);border-radius:8px;background:#fff;padding:9px 12px;color:#656b83}
.boletim-heading{display:flex;align-items:end;justify-content:space-between;gap:20px;margin-bottom:30px}
.boletim-heading h1{font-size:clamp(28px,3vw,38px);line-height:1.2;letter-spacing:-.055em;margin:0 0 10px;font-weight:750}
.boletim-heading p{margin:0;color:var(--atlas-muted);font-size:13px;line-height:1.6}
.boletim-heading .boletim-tag{border:1px solid #dfdefb;color:#5a58c4;background:#f0efff;padding:8px 12px;border-radius:100px;font-size:11px;font-weight:650;white-space:nowrap}
.boletim-summary{display:grid;grid-template-columns:1.35fr 1fr 1fr;gap:18px;margin-bottom:33px}
.boletim-card{background:#fff;border:1px solid var(--atlas-line);border-radius:16px;box-shadow:0 3px 18px rgba(30,36,74,.025)}
.boletim-stat{padding:24px 26px;min-height:157px;display:flex;flex-direction:column;justify-content:space-between}
.boletim-stat-label{display:flex;align-items:center;justify-content:space-between;gap:12px;color:#777d93;font-size:12px;font-weight:600}
.boletim-stat-icon{width:30px;height:30px;border-radius:9px;display:grid;place-items:center;background:#f1f0ff;color:#6664df;font-size:16px}
.boletim-stat-value{font-size:clamp(35px,4vw,49px);font-weight:750;letter-spacing:-.075em;line-height:1;font-variant-numeric:tabular-nums}
.boletim-stat small{color:#979cac;font-size:11px;margin-top:8px}
.boletim-stat:first-child{background:linear-gradient(145deg,#fff 52%,#f4f3ff)}
.boletim-section-heading{display:flex;align-items:end;justify-content:space-between;gap:16px;margin-bottom:16px}
.boletim-section-heading h2{font-size:17px;letter-spacing:-.035em;margin:0 0 6px}
.boletim-section-heading p{margin:0;font-size:12px;color:var(--atlas-muted);line-height:1.6}
.boletim-count{background:#eeedff;color:#5b59c4;border-radius:8px;padding:8px 11px;font-size:11px;font-weight:650;white-space:nowrap}
.boletim-table-card{overflow:hidden}
.boletim-toolbar{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:21px 25px;border-bottom:1px solid var(--atlas-line)}
.boletim-toolbar strong{font-size:13px;letter-spacing:-.015em}
.boletim-search{display:flex;align-items:center;gap:9px;width:min(275px,100%);border:1px solid #e3e5ee;background:#fafbfe;border-radius:9px;padding:10px 12px;color:#8b90a4}
.boletim-search svg{width:15px;height:15px;flex:none;stroke:currentColor;fill:none;stroke-width:1.8}
.boletim-search input{min-width:0;width:100%;border:0;outline:0;background:transparent;color:var(--atlas-ink);font-size:12px}
.boletim-search:focus-within{border-color:#7775e4;box-shadow:0 0 0 3px #6664df17}
.boletim-scroll{overflow-x:auto}
.boletim-table{width:100%;border-collapse:collapse;text-align:left;font-size:12px;min-width:690px}
.boletim-table th{padding:16px 24px;background:#fbfcff;border-bottom:1px solid var(--atlas-line);color:#969bad;font-size:10px;font-weight:750;letter-spacing:.09em;text-transform:uppercase;white-space:nowrap}
.boletim-table td{padding:19px 24px;border-bottom:1px solid #f0f1f6;color:#62687d;vertical-align:middle;line-height:1.5}
.boletim-table tbody tr:last-child td{border-bottom:0}
.boletim-table tbody tr:hover{background:#fafaff}
.boletim-subject{font-weight:700;color:#24273d;font-size:12px}
.boletim-score{font-weight:750;font-size:15px;color:#252941;font-variant-numeric:tabular-nums}
.boletim-status{display:inline-flex;align-items:center;gap:7px;padding:7px 10px;border-radius:100px;font-size:10px;font-weight:700;white-space:nowrap}
.boletim-status:before{content:'';width:6px;height:6px;border-radius:50%;background:currentColor}
.boletim-status.aprovado{background:#eaf8ef;color:#28754a}
.boletim-status.recuperacao{background:#fff5e6;color:#a56519}
.boletim-status.reprovado{background:#fff0f0;color:#b4454b}
.boletim-empty{padding:45px 25px;text-align:center;color:#777d93;font-size:13px}
.boletim-no-match{padding:25px;text-align:center;color:#777d93;font-size:12px}
.boletim-no-match[hidden]{display:none}
.boletim-footer{display:flex;align-items:flex-start;gap:10px;border-top:1px solid var(--atlas-line);padding:18px 25px;color:#7e8497;font-size:11px;line-height:1.6}
.boletim-footer svg{width:15px;height:15px;flex:none;stroke:#7775d9;fill:none;stroke-width:1.8;margin-top:1px}
.boletim-page-footer{text-align:right;margin-top:25px;color:#a1a6b5;font-size:10px}
@media(max-width:1100px){.boletim-summary{grid-template-columns:repeat(3,minmax(0,1fr))}.boletim-stat{padding:22px 19px}}
@media(max-width:800px){.boletim-main{padding:76px 18px 35px}.boletim-heading{align-items:start;flex-direction:column}.boletim-summary{gap:10px}.boletim-stat{min-height:130px;padding:17px 13px}.boletim-stat-value{font-size:32px}.boletim-stat-label{font-size:10px}.boletim-stat-icon{display:none}.boletim-toolbar{padding:18px;flex-wrap:wrap}.boletim-table th,.boletim-table td{padding:15px 18px}}
@media(max-width:430px){.boletim-summary{grid-template-columns:1fr}.boletim-stat{min-height:110px}.boletim-stat-icon{display:grid}.boletim-toolbar{align-items:stretch}.boletim-search{width:100%}}
@media(prefers-reduced-motion:reduce){.boletim-table tbody tr{transition:none}}
</style>
</head>
<body>
<?php include '../../includes/menu_aluno.php'; ?>
<main class="boletim-main">
  <div class="boletim-topline"><span class="boletim-eyebrow">INSTITUTO ATLAS / ESPAÇO DO ALUNO</span><span class="boletim-year">Ano letivo <?php echo atlas_escape($ano_letivo); ?></span></div>
  <header class="boletim-heading"><div><h1>Boletim</h1><p>Acompanhe suas notas e o desempenho por disciplina.</p></div><span class="boletim-tag">Desempenho acadêmico</span></header>
  <section class="boletim-summary" aria-label="Resumo das notas">
    <article class="boletim-card boletim-stat"><div class="boletim-stat-label">Média geral <span class="boletim-stat-icon" aria-hidden="true">↗</span></div><div><div class="boletim-stat-value"><?php echo atlas_escape($media_geral); ?></div><small>Média das notas registradas</small></div></article>
    <article class="boletim-card boletim-stat"><div class="boletim-stat-label">Notas a partir de 6 <span class="boletim-stat-icon" aria-hidden="true">✓</span></div><div><div class="boletim-stat-value"><?php echo atlas_escape($aprovados); ?></div><small>Registros de avaliação</small></div></article>
    <article class="boletim-card boletim-stat"><div class="boletim-stat-label">Notas abaixo de 4 <span class="boletim-stat-icon" aria-hidden="true">!</span></div><div><div class="boletim-stat-value"><?php echo atlas_escape($reprovados); ?></div><small>Registros de avaliação</small></div></article>
  </section>
  <section aria-labelledby="boletim-notas-title">
    <div class="boletim-section-heading"><div><h2 id="boletim-notas-title">Notas por disciplina</h2><p>Consulte suas médias, avaliações e situação em cada matéria.</p></div><span class="boletim-count"><?php echo count($disciplinas); ?> <?php echo count($disciplinas) === 1 ? 'registro' : 'registros'; ?></span></div>
    <div class="boletim-card boletim-table-card">
      <?php if (count($disciplinas) > 0): ?>
      <div class="boletim-toolbar"><strong>Disciplinas e avaliações</strong><label class="boletim-search"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m16 16 5 5"/></svg><input id="boletim-filtro" type="search" placeholder="Buscar disciplina ou professor" aria-label="Buscar disciplina ou professor"></label></div>
      <div class="boletim-scroll"><table class="boletim-table"><thead><tr><th scope="col">Disciplina</th><th scope="col">Professor</th><th scope="col">Avaliações</th><th scope="col">Média</th><th scope="col">Situação</th></tr></thead><tbody id="boletim-linhas">
      <?php foreach ($disciplinas as $disc): ?>
      <?php $classe = $disc['situacao'] === 'Aprovado' ? 'aprovado' : ($disc['situacao'] === 'Recuperação' ? 'recuperacao' : 'reprovado'); ?>
      <tr><td><span class="boletim-subject"><?php echo atlas_escape($disc['nome']); ?></span></td><td><?php echo atlas_escape($disc['professor_nome']); ?></td><td><?php echo atlas_escape($disc['avaliacoes'] ?? 'N/A'); ?></td><td><span class="boletim-score"><?php echo atlas_escape($disc['media']); ?></span></td><td><span class="boletim-status <?php echo $classe; ?>"><?php echo atlas_escape($disc['situacao']); ?></span></td></tr>
      <?php endforeach; ?>
      </tbody></table></div>
      <div id="boletim-sem-resultado" class="boletim-no-match" hidden>Nenhum resultado encontrado para essa busca.</div>
      <div class="boletim-footer"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 11v6m0-10v1"/></svg><span>Nota mínima para aprovação: 6.0 · Mínimo para recuperação: 4.0. A situação apresentada segue a regra atual do sistema.</span></div>
      <?php else: ?>
      <div class="boletim-empty">Nenhuma nota registrada ainda.</div>
      <?php endif; ?>
    </div>
  </section>
  <div class="boletim-page-footer">Instituto Atlas · Portal acadêmico</div>
</main>
<script>
(function(){'use strict';var search=document.getElementById('boletim-filtro'),rows=document.querySelectorAll('#boletim-linhas tr'),empty=document.getElementById('boletim-sem-resultado');if(!search||!empty)return;search.addEventListener('input',function(){var term=search.value.trim().toLocaleLowerCase('pt-BR'),visible=0;rows.forEach(function(row){var match=row.textContent.toLocaleLowerCase('pt-BR').includes(term);row.hidden=!match;if(match)visible++});empty.hidden=visible!==0})})();
</script>
</body>
</html>
