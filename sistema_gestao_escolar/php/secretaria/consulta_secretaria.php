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
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #1f2937; }
        main { max-width: 1100px; margin: 32px auto; padding: 0 20px 40px; }
        .header { background: linear-gradient(135deg, #103b6e, #1f8ad9); color: white; border-radius: 18px; padding: 28px 30px; margin-bottom: 24px; }
        .header h1 { margin: 0; font-size: 2rem; }
        .filtros { background: white; border-radius: 14px; padding: 18px 20px; margin-bottom: 22px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); display: flex; gap: 12px; align-items: flex-end; }
        .filtros label { font-size: 0.78rem; font-weight: bold; color: #26405d; display: block; }
        .filtros input { padding: 8px 11px; border: 1px solid #dce5f0; border-radius: 8px; font-size: 0.85rem; flex: 1; }
        .filtros button { background: #0d4a8f; color: #fff; border: none; border-radius: 8px; padding: 8px 18px; cursor: pointer; font-weight: bold; }
        .lista { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 18px; }
        .item { background: white; border: 1px solid #e3ebf7; border-radius: 16px; padding: 18px 20px; box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04); transition: all 0.3s; }
        .item:hover { box-shadow: 0 12px 28px rgba(15,23,42,0.12); transform: translateY(-2px); }
        .nome { font-size: 1.05rem; font-weight: bold; color: #113d70; margin-bottom: 10px; }
        .info { color: #5c6878; line-height: 1.7; font-size: 0.85rem; }
        .actions { display: flex; gap: 8px; margin-top: 12px; }
        .btn-small { flex: 1; padding: 6px 10px; border: none; border-radius: 6px; font-size: 0.75rem; cursor: pointer; text-align: center; text-decoration: none; display: inline-block; }
        .btn-edit { background: #4568a8; color: white; }
        .btn-delete { background: #cc2222; color: white; }
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
                            <a class="btn-small btn-delete" href="deletar_secretaria.php?id=<?php echo isset($reg['id_usuario']) ? $reg['id_usuario'] : ($reg['id_turma'] ?? $reg['id_disciplina']); ?>&tipo=<?php echo htmlspecialchars($tipo); ?>">Deletar</a>
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

