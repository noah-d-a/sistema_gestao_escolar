<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Secretaria');

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
$pesquisa = isset($_GET['q']) ? trim($_GET['q']) : '';
$registros = [];
$titulo = '';

if (!in_array($tipo, ['professor', 'coordenacao', 'secretaria', 'turma', 'disciplina'], true)) {
    $tipo = '';
}

if ($tipo === 'professor') {
    $titulo = 'Professores';
    $sql = "SELECT id_usuario, nome, email, cpf, perfil FROM usuario WHERE perfil = 'Professor' AND ativo = 1 AND nome LIKE ? ORDER BY nome";
    $search_param = "%$pesquisa%";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('s', $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $registros[] = $row;
    }
    $stmt->close();
} elseif ($tipo === 'coordenacao') {
    $titulo = 'Coordenação';
    $sql = "SELECT id_usuario, nome, email, cpf, perfil FROM usuario WHERE perfil = 'Coordenação' AND ativo = 1 AND nome LIKE ? ORDER BY nome";
    $search_param = "%$pesquisa%";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('s', $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $registros[] = $row;
    }
    $stmt->close();
} elseif ($tipo === 'secretaria') {
    $titulo = 'Secretaria';
    $sql = "SELECT id_usuario, nome, email, cpf, perfil FROM usuario WHERE perfil = 'Secretaria' AND ativo = 1 AND nome LIKE ? ORDER BY nome";
    $search_param = "%$pesquisa%";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('s', $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $registros[] = $row;
    }
    $stmt->close();
} elseif ($tipo === 'turma') {
    $titulo = 'Turmas';
    $sql = 'SELECT id_turma, nome FROM turma WHERE nome LIKE ? ORDER BY nome';
    $search_param = "%$pesquisa%";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('s', $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $registros[] = $row;
    }
    $stmt->close();
} elseif ($tipo === 'disciplina') {
    $titulo = 'Disciplinas';
    $sql = 'SELECT id_disciplina, nome FROM disciplina WHERE nome LIKE ? ORDER BY nome';
    $search_param = "%$pesquisa%";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('s', $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $registros[] = $row;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria | Consultar <?php echo htmlspecialchars($titulo ?: 'Registros'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"><style>
*{box-sizing:border-box}body{margin:0;background:#f7f8fc;color:#22243a;font-family:Inter,Arial,sans-serif}main{max-width:1140px;margin:0 auto;padding:44px 36px 75px}h1,h2{letter-spacing:-.035em}a:focus-visible,button:focus-visible,input:focus-visible,select:focus-visible{outline:3px solid #aaa7f8;outline-offset:2px}.header{background:transparent!important;color:#22243a!important;border-radius:0!important;padding:0!important;margin:0 0 26px!important;box-shadow:none!important}.header:before{content:'INSTITUTO ATLAS / SECRETARIA';display:block;color:#6762d8;font-size:11px;font-weight:800;letter-spacing:.13em;margin-bottom:11px}.header h1{font-size:clamp(27px,3vw,35px);margin:0;font-weight:800;line-height:1.2}.container{background:transparent;border:0;box-shadow:none;overflow:visible}.content{padding:0}.card,.filtros,.aluno,.item{background:white;border:1px solid #e7e9f1;border-radius:15px;box-shadow:0 7px 22px rgba(25,30,70,.035)}.card{padding:26px 28px;margin-bottom:18px}.card h2{font-size:15px;color:#24263b;margin:0 0 22px;font-weight:800}.grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px}.grid>div{min-width:0}label,.filtros label{display:block;font-size:12px;font-weight:700;color:#555b72;margin-bottom:8px}input,select,.filtros input,.filtros select{width:100%;min-width:0;background:#fff;border:1px solid #dfe2ed;border-radius:9px;padding:12px 13px;font:inherit;font-size:13px;color:#282b40}input:disabled{background:#f5f6fa;color:#777d8d}input:focus,select:focus{border-color:#7771df;outline:3px solid #efedff}.actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:20px}button,.filtros button,.btn-small{font:inherit;font-size:12px;font-weight:700;border:0;border-radius:9px;padding:12px 17px;cursor:pointer;text-decoration:none;display:inline-flex;justify-content:center;align-items:center}.primary,.filtros button,.btn-edit{background:#6560d8;color:white}.primary:hover,.filtros button:hover,.btn-edit:hover{background:#524dc4}.secondary{background:#eeedff;color:#5550c1}.btn-delete{background:#fff0f1;color:#bb3648}.filtros{padding:22px 24px;margin-bottom:22px}.filtros form{flex-wrap:wrap}.filtros form>div{min-width:180px}.lista{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:15px}.aluno,.item{padding:22px;transition:border-color .15s}.aluno:hover,.item:hover{border-color:#c8c5fa}.nome{font-size:15px;font-weight:800;color:#25283c;margin-bottom:12px;overflow-wrap:anywhere}.dados,.info{font-size:12px;line-height:1.9;color:#676c7e;overflow-wrap:anywhere}.dados strong,.info strong{color:#34394d}.btn-small{flex:1;padding:10px}.actions a{min-width:85px}@media(max-width:800px){main{padding:82px 20px 45px}}@media(max-width:560px){.grid{grid-template-columns:1fr}.card{padding:20px}.filtros{padding:18px}.lista{grid-template-columns:1fr}}
</style>
</head>
<body>
    <?php include '../../includes/menu_secretaria.php'; ?>

    <main>
        <section class="header">
            <h1>Consultar <?php echo htmlspecialchars($titulo ?: 'Registros'); ?></h1>
        </section>

        <?php if ($tipo): ?>
            <div class="filtros">
                <form method="GET" style="display: flex; gap: 12px; width: 100%; align-items: flex-end;">
                    <input type="hidden" name="tipo" value="<?php echo htmlspecialchars($tipo); ?>">
                    <div style="flex: 1;">
                        <label>Buscar</label>
                        <input type="text" name="q" placeholder="Digite o nome..." value="<?php echo htmlspecialchars($pesquisa); ?>" />
                    </div>
                    <button type="submit">Buscar</button>
                </form>
            </div>
        <?php endif; ?>

        <?php if (count($registros) > 0): ?>
            <section class="lista">
                <?php foreach ($registros as $reg): ?>
                    <article class="item">
                        <div class="nome"><?php echo htmlspecialchars($reg['nome']); ?></div>
                        <div class="info">
                            <?php if (isset($reg['cpf'])): ?>
                                <strong>CPF:</strong> <?php echo htmlspecialchars($reg['cpf'] ?? 'N/A'); ?><br>
                                <strong>Email:</strong> <?php echo htmlspecialchars($reg['email'] ?? 'N/A'); ?>
                            <?php endif; ?>
                        </div>
                        <div class="actions">
                            <a class="btn-small btn-edit" href="alterar_secretaria.php?id=<?php echo isset($reg['id_usuario']) ? $reg['id_usuario'] : ($reg['id_turma'] ?? $reg['id_disciplina']); ?>&tipo=<?php echo htmlspecialchars($tipo); ?>">Editar</a>
                            <a class="btn-small btn-delete" onclick="return confirm('Deseja realmente excluir este registro?');" href="deletar_secretaria.php?id=<?php echo isset($reg['id_usuario']) ? $reg['id_usuario'] : ($reg['id_turma'] ?? $reg['id_disciplina']); ?>&tipo=<?php echo htmlspecialchars($tipo); ?>">Deletar</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        <?php else: ?>
            <div style="background: #fff; padding: 40px; text-align: center; border-radius: 14px; color: #666;">
                <p>Nenhum registro encontrado.</p>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>

