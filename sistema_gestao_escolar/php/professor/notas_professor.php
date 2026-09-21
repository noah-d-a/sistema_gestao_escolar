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
<!DOCTYPE html>
<html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Professor | Notas</title><style>
*{box-sizing:border-box}body{margin:0;font-family:Arial,sans-serif;background:#f4f7fb;color:#1f2937}main{max-width:1180px;margin:32px auto;padding:0 20px 40px}.topo{background:linear-gradient(135deg,#1f3b65,#4568a8);color:#fff;border-radius:18px;padding:30px 28px;margin-bottom:26px}.topo h1{margin:0 0 4px;font-size:2rem}.topo p{margin:0;font-size:.9rem;opacity:.8}.panel{background:#fff;border-radius:18px;padding:22px;border:1px solid #e5ebf6;box-shadow:0 10px 22px rgba(15,23,42,.04);margin-bottom:22px}.panel h2{margin-top:0;color:#133b6d}.filtros{display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap}.filtros label{font-size:.78rem;font-weight:bold;color:#555;display:block;margin-bottom:4px}.filtros select,.filtros input{border:1px solid #dfe9f6;border-radius:8px;padding:8px 12px;font-size:.84rem}.btn{background:#183f73;color:#fff;border:0;border-radius:8px;padding:8px 16px;font-weight:bold;cursor:pointer}table{width:100%;border-collapse:collapse;font-size:.875rem}th,td{text-align:left;padding:10px 12px;border-bottom:1px solid #edf2f9}th{font-size:.75rem;color:#6b7280;text-transform:uppercase}input[type=number]{width:70px;border:1px solid #dfe9f6;border-radius:6px;padding:4px 8px}.media{font-weight:bold}
</style></head><body><?php include '../../includes/menu_professor.php'; ?><main><section class="topo"><h1>Lançamento de Notas</h1><p>Selecione a turma e a disciplina para criar avaliações e lançar notas.</p></section><div class="panel"><?php echo $mensagem; ?><form method="POST" class="filtros"><div><label>Turma</label><?php if(count($turmas)===1): ?><input type="hidden" name="turma" value="<?php echo $id_turma; ?>"><strong><?php echo htmlspecialchars($turmas[0]['nome']); ?></strong><?php else: ?><select name="turma" onchange="this.form.submit()"><option value="">Selecione</option><?php foreach($turmas as $turma): ?><option value="<?php echo $turma['id_turma']; ?>" <?php echo $id_turma==$turma['id_turma']?'selected':''; ?>><?php echo htmlspecialchars($turma['nome']); ?></option><?php endforeach; ?></select><?php endif; ?></div><div><label>Disciplina</label><?php if(count($disciplinas)===1): ?><input type="hidden" name="disciplina" value="<?php echo $id_disciplina; ?>"><strong><?php echo htmlspecialchars($disciplinas[0]['nome']); ?></strong><?php else: ?><select name="disciplina"><option value="">Selecione</option><?php foreach($disciplinas as $disc): ?><option value="<?php echo $disc['id_disciplina']; ?>" <?php echo $id_disciplina==$disc['id_disciplina']?'selected':''; ?>><?php echo htmlspecialchars($disc['nome']); ?></option><?php endforeach; ?></select><?php endif; ?></div><button class="btn" type="submit">Buscar</button></form></div><?php if($id_turma_disciplina>0): ?><div class="panel"><h2><?php echo htmlspecialchars($turma_nome.' · '.$disciplina_nome); ?></h2><form method="POST" class="filtros"><input type="hidden" name="turma" value="<?php echo $id_turma; ?>"><input type="hidden" name="disciplina" value="<?php echo $id_disciplina; ?>"><input name="nova_avaliacao" placeholder="Nome da avaliação"><button class="btn" name="criar_avaliacao" value="1">Criar avaliação</button></form><?php if($avaliacoes): ?><form method="POST"><input type="hidden" name="turma" value="<?php echo $id_turma; ?>"><input type="hidden" name="disciplina" value="<?php echo $id_disciplina; ?>"><table><thead><tr><th>RM</th><th>Aluno</th><?php foreach($avaliacoes as $avaliacao): ?><th><?php echo htmlspecialchars($avaliacao); ?></th><?php endforeach; ?><th>Média</th></tr></thead><tbody><?php foreach($alunos_notas as $aluno): ?><tr><td><?php echo htmlspecialchars($aluno['rm']); ?></td><td><?php echo htmlspecialchars($aluno['nome']); ?></td><?php $ids=[];$soma=0;$quantidade=0;foreach($avaliacoes as $avaliacao):$item=$aluno['notas'][$avaliacao]??null;$id_nota=$item['id_nota']??0;$ids[]=$id_nota;$valor=$item['nota']??null;if($valor!==null){$soma+=(float)$valor;$quantidade++;}?><td><input type="hidden" name="matricula[<?php echo $id_nota; ?>]" value="<?php echo $aluno['id_matricula']; ?>"><input type="number" name="nota[<?php echo $id_nota; ?>]" min="0" max="10" step="0.1" value="<?php echo $valor!==null?htmlspecialchars($valor):''; ?>" <?php echo $id_nota?'':'disabled'; ?>></td><?php endforeach; ?><td class="media"><?php echo $quantidade?number_format($soma/$quantidade,1,',','.'):'-'; ?></td></tr><?php endforeach; ?></tbody></table><button class="btn" name="salvar_notas" value="1" style="margin-top:16px">Salvar</button></form><?php else:?><p style="color:#666">Crie a primeira avaliação para esta turma e disciplina.</p><?php endif; ?></div><?php endif; ?></main></body></html>
