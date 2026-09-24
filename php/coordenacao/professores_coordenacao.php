<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';
verificar_perfil('Coordenação');
function esc_prof($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
$sql = "SELECT u.id_usuario, u.nome, d.nome AS disciplina, t.nome AS turma
        FROM usuario u
        LEFT JOIN turma_disciplina td ON td.id_professor = u.id_usuario
        LEFT JOIN disciplina d ON d.id_disciplina = td.id_disciplina
        LEFT JOIN turma t ON t.id_turma = td.id_turma
        WHERE u.perfil = 'Professor' AND u.ativo = 1
        ORDER BY u.nome, t.nome, d.nome";
$result = $conexao->query($sql);
$professores = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $id = (int)$row['id_usuario'];
        if (!isset($professores[$id])) {
            $professores[$id] = ['id' => $id, 'nome' => $row['nome'], 'disciplinas' => [], 'turmas' => [], 'vinculos' => []];
        }
        if ($row['disciplina']) $professores[$id]['disciplinas'][$row['disciplina']] = true;
        if ($row['turma']) $professores[$id]['turmas'][$row['turma']] = true;
        if ($row['disciplina'] && $row['turma']) $professores[$id]['vinculos'][$row['turma'].' · '.$row['disciplina']] = true;
    }
    $result->free();
}
$busca = trim($_GET['busca'] ?? '');
$lista = array_values(array_filter($professores, function ($prof) use ($busca) {
    if ($busca === '') return true;
    $texto = $prof['nome'].' '.implode(' ', array_keys($prof['disciplinas'])).' '.implode(' ', array_keys($prof['turmas']));
    return stripos($texto, $busca) !== false;
}));
?>
<!DOCTYPE html>
<html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Coordenação | Professores</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box}body{margin:0;background:#f6f7fb;color:#202337;font-family:Inter,Arial,sans-serif}main{max-width:1220px;margin:32px auto;padding:0 22px 50px}.topo,.painel,.indicador{background:#fff;border:1px solid #e8e9f0;border-radius:17px}.topo{padding:29px;margin-bottom:20px}.sobretitulo{font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:#7654d8;font-weight:800}.topo h1{font-size:29px;letter-spacing:-.8px;margin:8px 0}.muted{color:#73778b;font-size:13px;line-height:1.6}.indicadores{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;margin-bottom:20px}.indicador{padding:20px}.indicador strong{font-size:26px;display:block;margin-top:10px;letter-spacing:-1px}.indicador span{font-size:12px;color:#72768b;font-weight:600}.painel{overflow:hidden}.painel-head{padding:21px 23px;border-bottom:1px solid #ececf2;display:flex;justify-content:space-between;align-items:center;gap:15px;flex-wrap:wrap}.painel-head h2{margin:0 0 4px;font-size:16px}.busca{display:flex;gap:8px;flex-wrap:wrap}.busca input{background:#fff;border:1px solid #dddfea;border-radius:9px;padding:11px 13px;font:inherit;font-size:12px;min-width:230px}.busca button{background:#7654d8;color:white;border:0;border-radius:9px;padding:11px 15px;font:inherit;font-size:12px;font-weight:700;cursor:pointer}.table-wrap{overflow-x:auto}table{width:100%;border-collapse:collapse;text-align:left;min-width:700px}th{background:#fafafe;color:#77798d;font-size:10px;text-transform:uppercase;letter-spacing:.07em}td,th{padding:17px 22px;border-bottom:1px solid #eff0f4}td{font-size:13px;vertical-align:middle}tbody tr:last-child td{border-bottom:0}.name{font-weight:700}.sub{font-size:11px;color:#8a8c9b;margin-top:5px}.pill{display:inline-block;padding:6px 10px;border-radius:8px;font-size:11px;font-weight:700;background:#f1edfc;color:#6747c0;margin:2px 4px 2px 0}.pill.neutral{background:#f0f1f5;color:#77798b}.link{color:#6747c0;text-decoration:none;font-weight:700;font-size:12px;white-space:nowrap}.link:hover{text-decoration:underline}.vazio{padding:44px 24px;text-align:center;color:#7a7d8e;font-size:13px}.nota{padding:16px 23px;color:#86899a;font-size:11px;border-top:1px solid #eff0f4}@media(max-width:680px){main{margin:16px auto;padding:0 14px 30px}.topo{padding:22px}.indicadores{grid-template-columns:1fr}.indicador{padding:16px}.busca,.busca input{width:100%}}
</style></head><body>
<?php include '../../includes/menu_coordenacao.php'; ?>
<main>
<section class="topo"><div class="sobretitulo">Acompanhamento pedagógico</div><h1>Professores</h1><div class="muted">Consulte os docentes ativos, suas disciplinas e as turmas em que lecionam.</div></section>
<div class="indicadores"><div class="indicador"><span>Professores ativos</span><strong><?= count($professores) ?></strong></div><div class="indicador"><span>Disciplinas vinculadas</span><strong><?= count(array_unique(array_merge([], ...array_map(function ($p) { return array_keys($p['disciplinas']); }, $professores ?: [['disciplinas'=>[]]])))) ?></strong></div><div class="indicador"><span>Professores com turmas</span><strong><?= count(array_filter($professores, function ($p) { return count($p['turmas']) > 0; })) ?></strong></div></div>
<section class="painel"><div class="painel-head"><div><h2>Equipe docente</h2><div class="muted"><?= count($lista) ?> professor(es) encontrado(s).</div></div><form class="busca" method="get"><input type="search" name="busca" value="<?= esc_prof($busca) ?>" placeholder="Buscar nome, turma ou disciplina" aria-label="Buscar professores"><button type="submit">Buscar</button></form></div>
<?php if ($lista): ?><div class="table-wrap"><table><thead><tr><th>Professor</th><th>Disciplinas</th><th>Turmas</th><th>Detalhes</th></tr></thead><tbody>
<?php foreach ($lista as $prof): ?><tr><td><div class="name"><?= esc_prof($prof['nome']) ?></div><div class="sub"><?= count($prof['vinculos']) ?> vínculo(s) turma–disciplina</div></td><td><?php if ($prof['disciplinas']): foreach (array_keys($prof['disciplinas']) as $disc): ?><span class="pill"><?= esc_prof($disc) ?></span><?php endforeach; else: ?><span class="pill neutral">Sem vínculo</span><?php endif; ?></td><td><?php if ($prof['turmas']): foreach (array_keys($prof['turmas']) as $turma): ?><span class="pill neutral"><?= esc_prof($turma) ?></span><?php endforeach; else: ?><span class="pill neutral">Sem turma</span><?php endif; ?></td><td><a class="link" href="professor_coordenacao.php?id=<?= (int)$prof['id'] ?>">Ver professor →</a></td></tr><?php endforeach; ?>
</tbody></table></div><?php else: ?><div class="vazio"><?= $busca !== '' ? 'Nenhum professor corresponde à busca.' : 'Nenhum professor ativo encontrado.' ?></div><?php endif; ?><div class="nota">Os vínculos exibidos vêm dos registros de turmas e disciplinas já cadastrados. Esta página é apenas de consulta.</div></section>
</main></body></html>
