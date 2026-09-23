<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';
verificar_perfil('Professor');

$id_professor = $_SESSION['id_usuario'];
$id_turma = intval($_POST['turma'] ?? $_GET['turma'] ?? 0);
$id_disciplina = intval($_POST['disciplina'] ?? $_GET['disciplina'] ?? 0);
$mensagem = '';

$turmas = [];
$stmt = $conexao->prepare('SELECT DISTINCT t.id_turma, t.nome FROM turma t JOIN turma_disciplina td ON td.id_turma=t.id_turma WHERE td.id_professor=? ORDER BY t.nome');
$stmt->bind_param('i', $id_professor);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) { $turmas[] = $row; }
$stmt->close();
if ($id_turma <= 0 && count($turmas) === 1) { $id_turma = (int) $turmas[0]['id_turma']; }
if ($id_turma > 0 && !array_filter($turmas, fn($turma) => (int) $turma['id_turma'] === $id_turma)) { $id_turma = 0; }

$disciplinas = [];
if ($id_turma > 0) {
    $stmt = $conexao->prepare('SELECT DISTINCT d.id_disciplina, d.nome FROM disciplina d JOIN turma_disciplina td ON td.id_disciplina=d.id_disciplina WHERE td.id_turma=? AND td.id_professor=? ORDER BY d.nome');
    $stmt->bind_param('ii', $id_turma, $id_professor);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) { $disciplinas[] = $row; }
    $stmt->close();
}
if ($id_disciplina <= 0 && count($disciplinas) === 1) { $id_disciplina = (int) $disciplinas[0]['id_disciplina']; }
if ($id_disciplina > 0 && !array_filter($disciplinas, fn($disciplina) => (int) $disciplina['id_disciplina'] === $id_disciplina)) { $id_disciplina = 0; }

$id_turma_disciplina = 0;
if ($id_turma > 0 && $id_disciplina > 0) {
    $stmt = $conexao->prepare('SELECT id_turma_disciplina FROM turma_disciplina WHERE id_turma=? AND id_disciplina=? AND id_professor=?');
    $stmt->bind_param('iii', $id_turma, $id_disciplina, $id_professor);
    $stmt->execute();
    $id_turma_disciplina = (int) ($stmt->get_result()->fetch_assoc()['id_turma_disciplina'] ?? 0);
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['criar_avaliacao']) && $id_turma_disciplina > 0) {
    $nome_avaliacao = trim($_POST['nova_avaliacao'] ?? '');
    if ($nome_avaliacao === '') {
        $mensagem = '<div style="background:#fee;color:#c33;padding:10px;border-radius:6px;margin-bottom:15px;">Informe o nome da avaliação.</div>';
    } else {
        $stmt = $conexao->prepare('SELECT COUNT(*) AS total FROM nota WHERE id_turma_disciplina=? AND avaliacao=?');
        $stmt->bind_param('is', $id_turma_disciplina, $nome_avaliacao);
        $stmt->execute();
        $existe = (int) $stmt->get_result()->fetch_assoc()['total'] > 0;
        $stmt->close();
        if ($existe) {
            $mensagem = '<div style="background:#fff4e5;color:#8a5a00;padding:10px;border-radius:6px;margin-bottom:15px;">Essa avaliação já existe.</div>';
        } else {
            $stmt = $conexao->prepare('SELECT id_matricula FROM matricula WHERE id_turma=?');
            $stmt->bind_param('i', $id_turma);
            $stmt->execute();
            $result = $stmt->get_result();
            $conexao->begin_transaction();
            $ok = true;
            $insert = $conexao->prepare('INSERT INTO nota (id_matricula,id_turma_disciplina,avaliacao,nota,data_lancamento) VALUES (?,?,?,NULL,NULL)');
            while ($aluno = $result->fetch_assoc()) {
                $id_matricula = (int) $aluno['id_matricula'];
                $insert->bind_param('iis', $id_matricula, $id_turma_disciplina, $nome_avaliacao);
                if (!$insert->execute()) { $ok = false; break; }
            }
            $insert->close();
            $stmt->close();
            if ($ok) { $conexao->commit(); $mensagem = '<div style="background:#eaf7ee;color:#1d6f3b;padding:10px;border-radius:6px;margin-bottom:15px;">Avaliação criada com sucesso.</div>'; }
            else { $conexao->rollback(); $mensagem = '<div style="background:#fee;color:#c33;padding:10px;border-radius:6px;margin-bottom:15px;">Não foi possível criar a avaliação.</div>'; }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar_notas']) && $id_turma_disciplina > 0) {
    $notas = $_POST['nota'] ?? [];
    $stmt_update = $conexao->prepare('UPDATE nota SET nota=?, data_lancamento=NOW() WHERE id_nota=? AND id_turma_disciplina=? AND id_matricula=?');
    $stmt_null = $conexao->prepare('UPDATE nota SET nota=NULL, data_lancamento=NULL WHERE id_nota=? AND id_turma_disciplina=? AND id_matricula=?');
    foreach ($notas as $id_nota => $valor) {
        $id_nota = intval($id_nota);
        $id_matricula = intval($_POST['matricula'][$id_nota] ?? 0);
        if ($id_nota <= 0 || $id_matricula <= 0) { continue; }
        if (trim($valor) === '') { $stmt_null->bind_param('iii', $id_nota, $id_turma_disciplina, $id_matricula); $stmt_null->execute(); continue; }
        $nota = (float) str_replace(',', '.', $valor);
        if ($nota < 0 || $nota > 10) { continue; }
        $stmt_update->bind_param('diii', $nota, $id_nota, $id_turma_disciplina, $id_matricula);
        $stmt_update->execute();
    }
    $stmt_update->close(); $stmt_null->close();
    $mensagem = '<div style="background:#eaf7ee;color:#1d6f3b;padding:10px;border-radius:6px;margin-bottom:15px;">Notas salvas com sucesso.</div>';
}

$avaliacoes = [];
$alunos_notas = [];
$turma_nome = '';
$disciplina_nome = '';
if ($id_turma_disciplina > 0) {
    $stmt = $conexao->prepare('SELECT t.nome AS turma_nome, d.nome AS disciplina_nome FROM turma t JOIN disciplina d JOIN turma_disciplina td ON td.id_turma=t.id_turma AND td.id_disciplina=d.id_disciplina WHERE td.id_turma_disciplina=?');
    $stmt->bind_param('i', $id_turma_disciplina); $stmt->execute(); $info = $stmt->get_result()->fetch_assoc(); $stmt->close();
    $turma_nome = $info['turma_nome'] ?? ''; $disciplina_nome = $info['disciplina_nome'] ?? '';
    $stmt = $conexao->prepare('SELECT avaliacao FROM nota WHERE id_turma_disciplina=? AND avaliacao IS NOT NULL AND avaliacao<>"" GROUP BY avaliacao ORDER BY MIN(id_nota)');
    $stmt->bind_param('i', $id_turma_disciplina); $stmt->execute(); $result = $stmt->get_result(); while ($row=$result->fetch_assoc()) { $avaliacoes[]=$row['avaliacao']; } $stmt->close();
    $stmt = $conexao->prepare('SELECT m.id_matricula,m.rm,u.nome,n.id_nota,n.avaliacao,n.nota FROM matricula m JOIN usuario u ON u.id_usuario=m.id_aluno LEFT JOIN nota n ON n.id_matricula=m.id_matricula AND n.id_turma_disciplina=? WHERE m.id_turma=? ORDER BY u.nome,n.id_nota');
    $stmt->bind_param('ii', $id_turma_disciplina, $id_turma); $stmt->execute(); $result=$stmt->get_result();
    while ($row=$result->fetch_assoc()) { $key=$row['id_matricula']; if (!isset($alunos_notas[$key])) { $alunos_notas[$key]=['id_matricula'=>$key,'rm'=>$row['rm'],'nome'=>$row['nome'],'notas'=>[]]; } if ($row['id_nota']) { $alunos_notas[$key]['notas'][$row['avaliacao']]=['id_nota'=>$row['id_nota'],'nota'=>$row['nota']]; } }
    $stmt->close();
}
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Professor | Notas — Instituto Atlas</title><style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
*{box-sizing:border-box}body{margin:0;background:#f7f8fc;color:#202338;font-family:Inter,Arial,sans-serif} .atlas-main{max-width:1320px;margin:0 auto;padding:36px 60px 76px}.eyebrow{font-size:11px;font-weight:800;letter-spacing:.15em;color:#777d93;text-transform:uppercase}.page-head{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;margin-bottom:30px}.page-head h1{font-size:38px;letter-spacing:-.055em;margin:13px 0 8px;font-weight:800}.page-head h1 span{color:#6664df}.sub{color:#777d93;font-size:14px;line-height:1.6;margin:0}.tag{border:1px solid #e7e9f1;background:#fff;border-radius:30px;padding:10px 15px;font-size:12px;color:#6664df;font-weight:700}.panel{background:#fff;border:1px solid #e7e9f1;border-radius:17px;padding:26px 30px;margin-bottom:20px;box-shadow:0 7px 22px rgba(29,32,63,.025)}.panel-head{display:flex;justify-content:space-between;gap:16px;align-items:center;margin-bottom:23px}.panel h2{margin:0;font-size:17px;letter-spacing:-.03em}.panel small{font-size:12px;color:#777d93}.filtros{display:flex;gap:15px;align-items:flex-end;flex-wrap:wrap}.field{display:flex;flex-direction:column;gap:8px;flex:1;min-width:170px}.field label{font-size:12px;font-weight:700;color:#34384f}.field select,.field input{height:45px;border:1px solid #e1e4ee;background:#fff;border-radius:10px;padding:0 13px;color:#202338;font:inherit;font-size:13px;width:100%;outline:none}.field select:focus,.field input:focus,.grade-input:focus{border-color:#6664df;box-shadow:0 0 0 3px #6664df1c}.fixed-value{display:flex;align-items:center;min-height:45px;padding:0 13px;border:1px solid #e7e9f1;background:#f8f9fd;border-radius:10px;font-size:13px}.btn{height:45px;background:#6664df;color:white;border:0;border-radius:10px;padding:0 20px;font:inherit;font-weight:700;font-size:13px;cursor:pointer;white-space:nowrap}.btn:hover{background:#5451c8}.btn.secondary{background:#f0efff;color:#5653cc}.btn.secondary:hover{background:#e5e3ff}.notice{padding:14px 17px;border-radius:11px;margin-bottom:19px;font-size:13px;line-height:1.5}.notice.success{background:#eaf8f0;color:#17623d}.notice.error{background:#fff0f0;color:#a12936}.notice.warn{background:#fff8e8;color:#926100}.class-head{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}.class-head p{margin:6px 0 0;color:#777d93;font-size:13px}.divider{border:0;border-top:1px solid #eceef5;margin:24px 0}.create-form{display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap}.create-form .field{max-width:420px}.table-scroll{overflow-x:auto;border:1px solid #e7e9f1;border-radius:13px;margin-top:24px}table{width:100%;border-collapse:collapse;font-size:13px;min-width:660px}th{text-align:left;font-size:10px;text-transform:uppercase;letter-spacing:.09em;color:#777d93;background:#fbfcff;font-weight:800;white-space:nowrap}th,td{padding:15px 17px;border-bottom:1px solid #eceef5}tbody tr:last-child td{border-bottom:0}tbody tr:hover{background:#fcfcff}.student{font-weight:700;color:#202338;min-width:175px}.rm{color:#777d93;font-variant-numeric:tabular-nums}.grade-input{width:74px;height:36px;border:1px solid #e1e4ee;border-radius:8px;text-align:center;background:#fff;font:inherit;font-size:13px;outline:none}.grade-input:disabled{background:#f5f5f8}.average{font-weight:800;color:#4f4dc5}.table-footer{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-top:19px}.table-footer p{font-size:12px;color:#777d93;margin:0}.empty{padding:30px;text-align:center;background:#fafbff;border:1px dashed #dfe2ef;border-radius:12px;color:#777d93;font-size:13px}.empty strong{display:block;color:#202338;margin-bottom:7px;font-size:15px}.section-note{font-size:12px;color:#777d93;margin:0 0 18px}@media(max-width:1100px){.atlas-main{padding:32px 30px 65px}}@media(max-width:700px){.atlas-main{padding:28px 18px 50px}.page-head{align-items:flex-start}.page-head h1{font-size:31px}.tag{display:none}.panel{padding:21px 17px}.field{min-width:100%}.create-form .field{max-width:none}.filtros .btn,.create-form .btn{width:100%}.table-footer{align-items:stretch;flex-direction:column}.table-footer .btn{width:100%}}
</style></head><body><?php include '../../includes/menu_professor.php'; ?><main class="atlas-main"><header class="page-head"><div><div class="eyebrow">Instituto Atlas &nbsp;/&nbsp; Portal do professor</div><h1>Lançamento de notas<span>.</span></h1><p class="sub">Organize avaliações e acompanhe o desempenho das suas turmas.</p></div><span class="tag">Área do professor</span></header>
<?php echo str_replace(['style="background:#fee;color:#c33;padding:10px;border-radius:6px;margin-bottom:15px;"','style="background:#fff4e5;color:#8a5a00;padding:10px;border-radius:6px;margin-bottom:15px;"','style="background:#eaf7ee;color:#1d6f3b;padding:10px;border-radius:6px;margin-bottom:15px;"'],['class="notice error"','class="notice warn"','class="notice success"'],$mensagem); ?>
<section class="panel"><div class="panel-head"><h2>Selecione sua turma</h2><small>Filtre os registros</small></div><form method="POST" class="filtros"><div class="field"><label for="turma">Turma</label><?php if(count($turmas)===1): ?><input type="hidden" name="turma" value="<?php echo $id_turma; ?>"><div class="fixed-value"><?php echo htmlspecialchars($turmas[0]['nome']); ?></div><?php else: ?><select id="turma" name="turma" onchange="this.form.submit()"><option value="">Selecione uma turma</option><?php foreach($turmas as $turma): ?><option value="<?php echo (int)$turma['id_turma']; ?>" <?php echo $id_turma==$turma['id_turma']?'selected':''; ?>><?php echo htmlspecialchars($turma['nome']); ?></option><?php endforeach; ?></select><?php endif; ?></div><div class="field"><label for="disciplina">Disciplina</label><?php if(count($disciplinas)===1): ?><input type="hidden" name="disciplina" value="<?php echo $id_disciplina; ?>"><div class="fixed-value"><?php echo htmlspecialchars($disciplinas[0]['nome']); ?></div><?php else: ?><select id="disciplina" name="disciplina" <?php echo !$disciplinas?'disabled':''; ?>><option value="">Selecione uma disciplina</option><?php foreach($disciplinas as $disc): ?><option value="<?php echo (int)$disc['id_disciplina']; ?>" <?php echo $id_disciplina==$disc['id_disciplina']?'selected':''; ?>><?php echo htmlspecialchars($disc['nome']); ?></option><?php endforeach; ?></select><?php endif; ?></div><button class="btn" type="submit">Buscar registros →</button></form></section>
<?php if($id_turma_disciplina>0): ?><section class="panel"><div class="class-head"><div><div class="eyebrow">Diário de classe</div><h2 style="margin-top:9px"><?php echo htmlspecialchars($turma_nome.' · '.$disciplina_nome); ?></h2><p>Crie uma avaliação ou preencha as notas existentes.</p></div><span class="tag"><?php echo count($alunos_notas); ?> alunos</span></div><hr class="divider"><div class="panel-head"><h2>Nova avaliação</h2><small>Criação para todos os alunos da turma</small></div><form method="POST" class="create-form"><input type="hidden" name="turma" value="<?php echo $id_turma; ?>"><input type="hidden" name="disciplina" value="<?php echo $id_disciplina; ?>"><div class="field"><label for="nova_avaliacao">Nome da avaliação</label><input id="nova_avaliacao" name="nova_avaliacao" placeholder="Ex.: Prova bimestral" maxlength="120" required></div><button class="btn secondary" type="submit" name="criar_avaliacao" value="1">+ Criar avaliação</button></form>
<?php if($avaliacoes): ?><hr class="divider"><div class="panel-head"><h2>Notas dos alunos</h2><small><?php echo count($avaliacoes); ?> avaliação(ões)</small></div><p class="section-note">Use valores de 0 a 10. Deixe o campo vazio para registrar uma nota pendente.</p><form method="POST"><input type="hidden" name="turma" value="<?php echo $id_turma; ?>"><input type="hidden" name="disciplina" value="<?php echo $id_disciplina; ?>"><div class="table-scroll"><table><thead><tr><th>RM</th><th>Aluno</th><?php foreach($avaliacoes as $avaliacao): ?><th><?php echo htmlspecialchars($avaliacao); ?></th><?php endforeach; ?><th>Média</th></tr></thead><tbody><?php foreach($alunos_notas as $aluno): ?><tr><td class="rm"><?php echo htmlspecialchars((string)$aluno['rm']); ?></td><td class="student"><?php echo htmlspecialchars($aluno['nome']); ?></td><?php $soma=0;$quantidade=0;foreach($avaliacoes as $avaliacao):$item=$aluno['notas'][$avaliacao]??null;$id_nota=$item['id_nota']??0;$valor=$item['nota']??null;if($valor!==null){$soma+=(float)$valor;$quantidade++;}?><td><input type="hidden" name="matricula[<?php echo $id_nota; ?>]" value="<?php echo (int)$aluno['id_matricula']; ?>"><input class="grade-input" aria-label="Nota de <?php echo htmlspecialchars($aluno['nome'].' em '.$avaliacao,ENT_QUOTES,'UTF-8'); ?>" type="number" name="nota[<?php echo $id_nota; ?>]" min="0" max="10" step="0.1" value="<?php echo $valor!==null?htmlspecialchars((string)$valor):''; ?>" <?php echo $id_nota?'':'disabled'; ?>></td><?php endforeach; ?><td class="average"><?php echo $quantidade?number_format($soma/$quantidade,1,',','.'):'—'; ?></td></tr><?php endforeach; ?></tbody></table></div><div class="table-footer"><p>Confira os lançamentos antes de salvar.</p><button class="btn" type="submit" name="salvar_notas" value="1">Salvar notas →</button></div></form><?php else: ?><hr class="divider"><div class="empty"><strong>Nenhuma avaliação cadastrada</strong>Crie a primeira avaliação para começar o lançamento de notas.</div><?php endif; ?></section><?php elseif(!$turmas): ?><section class="panel"><div class="empty"><strong>Nenhuma turma atribuída</strong>As turmas vinculadas ao seu perfil aparecerão aqui.</div></section><?php endif; ?></main></body></html>