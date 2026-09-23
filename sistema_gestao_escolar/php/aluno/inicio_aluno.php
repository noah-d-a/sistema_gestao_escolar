<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

// Verificar se é aluno
verificar_perfil('Aluno');

$id_aluno = $_SESSION['id_usuario'];

// Consultar dados do aluno e sua turma
$sql = "SELECT u.nome, u.email, m.rm, t.nome as turma_nome, t.periodo, t.ano_letivo 
        FROM usuario u 
        JOIN matricula m ON u.id_usuario = m.id_aluno
        JOIN turma t ON m.id_turma = t.id_turma
        WHERE u.id_usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_aluno);
$stmt->execute();
$result = $stmt->get_result();
$aluno = $result->fetch_assoc();
$stmt->close();

if (!$aluno) {
    echo "Dados do aluno não encontrados.";
    exit();
}

// Calcular média geral
$sql = "SELECT AVG(n.nota) as media_geral
        FROM nota n
        JOIN matricula m ON n.id_matricula = m.id_matricula
        WHERE m.id_aluno = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_aluno);
$stmt->execute();
$result = $stmt->get_result();
$media_row = $result->fetch_assoc();
$media_geral = $media_row['media_geral'] ?? 0;
$media_geral = number_format($media_geral, 1);
$stmt->close();

// Calcular frequência geral e contar faltas
$sql = "SELECT COUNT(*) as total_aulas, SUM(CASE WHEN presente = 1 THEN 1 ELSE 0 END) as aulas_presentes
        FROM frequencia f
        JOIN matricula m ON f.id_matricula = m.id_matricula
        WHERE m.id_aluno = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_aluno);
$stmt->execute();
$result = $stmt->get_result();
$freq_row = $result->fetch_assoc();
$total_aulas = $freq_row['total_aulas'] ?? 0;
$aulas_presentes = $freq_row['aulas_presentes'] ?? 0;
$frequencia = $total_aulas > 0 ? round(($aulas_presentes / $total_aulas) * 100, 1) : 0;
$faltas = $total_aulas - $aulas_presentes;
$stmt->close();

// Contar questionários pendentes
$sql = "SELECT COUNT(*) as pendentes FROM questionario WHERE criado_por != ? AND id_questionario NOT IN (SELECT id_questionario FROM pergunta WHERE id_pergunta IN (SELECT id_pergunta FROM resposta WHERE id_usuario = ?))";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ii", $id_aluno, $id_aluno);
$stmt->execute();
$result = $stmt->get_result();
$quest_row = $result->fetch_assoc();
$questionarios_pendentes = $quest_row['pendentes'] ?? 0;
$stmt->close();

// Buscar disciplinas com frequência < 75%
$disciplinas_risco = [];
$sql = "SELECT td.id_turma_disciplina, d.nome, COUNT(*) as total, SUM(CASE WHEN f.presente = 1 THEN 1 ELSE 0 END) as presentes
        FROM frequencia f
        JOIN turma_disciplina td ON f.id_turma_disciplina = td.id_turma_disciplina
        JOIN disciplina d ON td.id_disciplina = d.id_disciplina
        JOIN matricula m ON f.id_matricula = m.id_matricula
        WHERE m.id_aluno = ?
        GROUP BY td.id_turma_disciplina, d.nome
        HAVING (SUM(CASE WHEN f.presente = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100 < 75";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_aluno);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $freq_disc = $row['presentes'] > 0 ? round(($row['presentes'] / $row['total']) * 100, 1) : 0;
    $disciplinas_risco[] = ['nome' => $row['nome'], 'frequencia' => $freq_disc];
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Visão geral | Instituto Atlas</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--atlas-accent:#6664df;--atlas-ink:#202338;--atlas-muted:#777d93;--atlas-line:#e7e9f1;--atlas-bg:#f7f8fc}*{box-sizing:border-box}body{background:var(--atlas-bg);color:var(--atlas-ink);font-family:Inter,Arial,sans-serif}button{font:inherit}.atlas-main{width:min(1320px,100%);margin:0 auto;padding:36px clamp(20px,4vw,60px) 65px}.atlas-topline{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:26px}.atlas-eyebrow{font-size:10px;letter-spacing:.15em;color:#9297a8;font-weight:750}.atlas-year{font-size:12px;border:1px solid var(--atlas-line);border-radius:8px;background:white;padding:9px 12px;color:#656b83}.atlas-heading{display:flex;align-items:flex-end;justify-content:space-between;gap:18px;margin-bottom:31px}.atlas-heading h1{font-size:clamp(28px,3vw,38px);line-height:1.2;letter-spacing:-.055em;margin:0 0 10px;font-weight:750}.atlas-heading p{margin:0;color:var(--atlas-muted);font-size:13px;line-height:1.6}.atlas-heading .atlas-status{border-radius:100px;background:#eaf8ef;color:#28754a;font-size:11px;font-weight:650;padding:8px 12px;white-space:nowrap}.atlas-grid{display:grid;grid-template-columns:minmax(0,1.6fr) minmax(300px,1fr);gap:20px;align-items:stretch}.atlas-card{background:#fff;border:1px solid var(--atlas-line);border-radius:16px;box-shadow:0 3px 18px rgba(30,36,74,.025)}.atlas-card-header{display:flex;align-items:center;justify-content:space-between;gap:12px}.atlas-card h2{font-size:15px;letter-spacing:-.025em;font-weight:700;margin:0}.atlas-subtle{color:#9197a8;font-size:11px}.atlas-performance{padding:28px 29px;min-height:280px;display:flex;flex-direction:column}.atlas-performance .atlas-big{font-size:clamp(54px,7vw,82px);font-weight:750;letter-spacing:-.085em;line-height:1;margin:23px 0 8px;font-variant-numeric:tabular-nums}.atlas-performance .atlas-big-label{font-size:12px;color:var(--atlas-muted)}.atlas-metrics{margin-top:auto;padding-top:24px;display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px}.atlas-metric{border-top:1px solid var(--atlas-line);padding-top:17px;min-width:0}.atlas-metric span{display:block;color:var(--atlas-muted);font-size:11px;margin-bottom:8px}.atlas-metric strong{display:block;font-size:25px;letter-spacing:-.055em;font-weight:700;font-variant-numeric:tabular-nums}.atlas-metric small{display:block;color:#a0a5b4;font-size:10px;margin-top:6px}.atlas-quick{padding:28px;display:flex;flex-direction:column;justify-content:space-between;gap:24px;background:linear-gradient(150deg,#fff 55%,#f2f1ff 100%)}.atlas-quick-icon{width:45px;height:45px;border-radius:14px;background:#eeedff;color:#6664df;display:grid;place-items:center;font-size:22px}.atlas-quick h2{font-size:22px;line-height:1.3;letter-spacing:-.045em;max-width:240px}.atlas-quick p{font-size:12px;line-height:1.7;color:var(--atlas-muted);margin:9px 0 0}.atlas-quick a{display:inline-flex;align-items:center;justify-content:space-between;gap:15px;width:100%;text-decoration:none;background:#6664df;color:#fff;border-radius:10px;padding:13px 15px;font-size:12px;font-weight:650;transition:background .2s,transform .2s}.atlas-quick a:hover{background:#504ec6;transform:translateY(-1px)}.atlas-section{display:flex;align-items:center;justify-content:space-between;gap:10px;margin:34px 0 16px}.atlas-section h2{margin:0;font-size:17px;letter-spacing:-.035em}.atlas-section p{margin:5px 0 0;font-size:12px;color:var(--atlas-muted)}.atlas-count{background:#fef4e5;color:#a55c18;font-size:11px;border-radius:7px;padding:8px 10px;font-weight:650}.atlas-lower{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px;align-items:start}.atlas-details,.atlas-attendance{padding:23px 27px}.atlas-details dl{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px 18px;margin:20px 0 0}.atlas-details dt{color:#9095a6;font-size:10px;letter-spacing:.035em;margin-bottom:5px}.atlas-details dd{margin:0;font-size:12px;font-weight:600;overflow-wrap:anywhere}.atlas-badge{display:inline-flex;align-items:center;gap:5px;border-radius:100px;background:#eaf8ef;color:#28754a;font-size:11px;padding:6px 10px;font-weight:650}.atlas-badge:before{content:'';width:6px;height:6px;border-radius:50%;background:#3ea36b}.atlas-risk-list{list-style:none;margin:15px 0 0;padding:0}.atlas-risk-list li{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:13px 0;border-top:1px solid var(--atlas-line)}.atlas-risk-list li strong{font-size:12px}.atlas-risk-list li small{display:block;color:var(--atlas-muted);font-size:10px;margin-top:5px}.atlas-risk-percent{color:#ae651f;background:#fff3e5;border-radius:8px;padding:8px 10px;font-size:12px;font-weight:750;font-variant-numeric:tabular-nums}.atlas-empty{margin:24px 0 0;color:var(--atlas-muted);font-size:12px;line-height:1.6}.atlas-notice{margin-top:16px;background:#fffbf3;border:1px solid #f2e4ca;border-radius:12px;padding:16px 20px;display:flex;gap:12px;align-items:flex-start;color:#875c27;font-size:12px;line-height:1.7}.atlas-notice .atlas-notice-icon{font-size:16px;line-height:1.3}.atlas-notice strong{font-weight:750}.atlas-note-toggle{border:0;background:transparent;color:#6865c9;font-weight:650;font-size:11px;cursor:pointer;padding:5px 0}.atlas-note-toggle:hover{text-decoration:underline}.atlas-note-extra[hidden]{display:none}.atlas-note-extra{margin-top:8px}.atlas-footer{margin-top:24px;color:#a1a6b5;font-size:10px;text-align:right}
@media(max-width:1100px){.atlas-grid{grid-template-columns:1fr}.atlas-quick{min-height:190px}.atlas-quick h2{max-width:none}.atlas-quick a{max-width:220px}.atlas-lower{grid-template-columns:1fr}}@media(max-width:800px){.atlas-main{padding:76px 18px 35px}.atlas-heading{align-items:flex-start;flex-direction:column}.atlas-topline{margin-bottom:20px}.atlas-performance,.atlas-quick,.atlas-details,.atlas-attendance{padding:22px}.atlas-metrics{gap:8px}.atlas-metric strong{font-size:21px}.atlas-details dl{gap:20px 10px}}@media(max-width:380px){.atlas-metric span{font-size:10px}.atlas-metric strong{font-size:19px}.atlas-details dl{grid-template-columns:1fr}}@media(prefers-reduced-motion:reduce){.atlas-quick a{transition:none}}
</style></head><body>
<?php include '../../includes/menu_aluno.php'; ?>
<main class="atlas-main">
 <div class="atlas-topline"><span class="atlas-eyebrow">INSTITUTO ATLAS <span aria-hidden="true">/</span> PORTAL DO ALUNO</span><span class="atlas-year">Ano letivo <?php echo htmlspecialchars((string)$aluno['ano_letivo'], ENT_QUOTES, 'UTF-8'); ?></span></div>
 <header class="atlas-heading"><div><h1>Visão geral<span style="color:#6967df">.</span></h1><p>Bem-vinda, <?php echo htmlspecialchars($aluno['nome'], ENT_QUOTES, 'UTF-8'); ?>. Acompanhe suas informações acadêmicas.</p></div><span class="atlas-status">● Matrícula ativa</span></header>
 <section class="atlas-grid" aria-label="Resumo acadêmico">
  <article class="atlas-card atlas-performance"><div class="atlas-card-header"><h2>Desempenho acadêmico</h2><span class="atlas-subtle">Resumo geral</span></div><div class="atlas-big"><?php echo htmlspecialchars((string)$media_geral, ENT_QUOTES, 'UTF-8'); ?></div><div class="atlas-big-label">Média geral registrada</div><div class="atlas-metrics"><div class="atlas-metric"><span>Frequência</span><strong><?php echo htmlspecialchars((string)$frequencia, ENT_QUOTES, 'UTF-8'); ?>%</strong><small>Presença geral</small></div><div class="atlas-metric"><span>Faltas</span><strong><?php echo htmlspecialchars((string)$faltas, ENT_QUOTES, 'UTF-8'); ?></strong><small>Registros</small></div><div class="atlas-metric"><span>Questionários</span><strong><?php echo htmlspecialchars((string)$questionarios_pendentes, ENT_QUOTES, 'UTF-8'); ?></strong><small>Pendentes</small></div></div></article>
  <aside class="atlas-card atlas-quick"><div class="atlas-quick-icon" aria-hidden="true">↗</div><div><h2>Seu boletim, sempre à mão.</h2><p>Consulte suas notas e acompanhe seu desempenho por disciplina.</p></div><a href="boletim_aluno.php">Acessar boletim <span aria-hidden="true">↗</span></a></aside>
 </section>
 <div class="atlas-section"><div><h2>Sua situação acadêmica</h2><p>Dados da matrícula e acompanhamento de frequência.</p></div><?php if (count($disciplinas_risco) > 0): ?><span class="atlas-count"><?php echo count($disciplinas_risco); ?> alerta(s)</span><?php endif; ?></div>
 <section class="atlas-lower" aria-label="Informações e frequência"><article class="atlas-card atlas-details"><div class="atlas-card-header"><h2>Informações do aluno</h2><span class="atlas-subtle">Dados da matrícula</span></div><dl><div><dt>UNIDADE</dt><dd>Instituto Atlas</dd></div><div><dt>RM</dt><dd><?php echo htmlspecialchars((string)$aluno['rm'], ENT_QUOTES, 'UTF-8'); ?></dd></div><div><dt>NOME</dt><dd><?php echo htmlspecialchars($aluno['nome'], ENT_QUOTES, 'UTF-8'); ?></dd></div><div><dt>TURMA</dt><dd><?php echo htmlspecialchars($aluno['turma_nome'], ENT_QUOTES, 'UTF-8'); ?></dd></div><div><dt>PERÍODO</dt><dd><?php echo htmlspecialchars($aluno['periodo'], ENT_QUOTES, 'UTF-8'); ?></dd></div><div><dt>ANO LETIVO</dt><dd><?php echo htmlspecialchars((string)$aluno['ano_letivo'], ENT_QUOTES, 'UTF-8'); ?></dd></div><div><dt>SITUAÇÃO DA MATRÍCULA</dt><dd><span class="atlas-badge">Cursando</span></dd></div></dl></article>
 <article class="atlas-card atlas-attendance"><div class="atlas-card-header"><h2>Frequência por disciplina</h2><span class="atlas-subtle">Mínimo: 75%</span></div><?php if (count($disciplinas_risco) > 0): ?><ul class="atlas-risk-list"><?php foreach ($disciplinas_risco as $disc): ?><li><div><strong><?php echo htmlspecialchars($disc['nome'], ENT_QUOTES, 'UTF-8'); ?></strong><small>Abaixo do mínimo exigido</small></div><span class="atlas-risk-percent"><?php echo htmlspecialchars((string)$disc['frequencia'], ENT_QUOTES, 'UTF-8'); ?>%</span></li><?php endforeach; ?></ul><?php else: ?><p class="atlas-empty">Você não possui disciplinas com frequência baixa.</p><?php endif; ?></article></section>
 <?php if (count($disciplinas_risco) > 0): ?><div class="atlas-notice" role="status"><span class="atlas-notice-icon" aria-hidden="true">!</span><div><strong>Atenção à frequência.</strong> Sua frequência em <strong><?php echo htmlspecialchars($disciplinas_risco[0]['nome'], ENT_QUOTES, 'UTF-8'); ?></strong> está em <strong><?php echo htmlspecialchars((string)$disciplinas_risco[0]['frequencia'], ENT_QUOTES, 'UTF-8'); ?>%</strong>, abaixo do mínimo exigido de 75%. <button class="atlas-note-toggle" type="button" aria-expanded="false" aria-controls="atlas-note-extra">Ver orientação</button><div id="atlas-note-extra" class="atlas-note-extra" hidden>Você pode ser reprovado por falta. Consulte a página de presença para acompanhar seus registros.</div></div></div><?php endif; ?>
 <div class="atlas-footer">Instituto Atlas · Portal acadêmico</div>
</main>
<script>(function(){var b=document.querySelector('.atlas-note-toggle'),e=document.getElementById('atlas-note-extra');if(!b||!e)return;b.addEventListener('click',function(){var open=b.getAttribute('aria-expanded')!=='true';b.setAttribute('aria-expanded',String(open));b.textContent=open?'Ocultar orientação':'Ver orientação';e.hidden=!open})})();</script>
</body></html>
