<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Secretaria');

$tipo = $_GET['tipo'] ?? 'aluno';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$mensagem = '';
$registro = null;

if ($id <= 0) {
    $mensagem = '<div style="background: #fee; color: #9d1c1c; padding: 10px 12px; border-radius: 8px; margin-bottom: 15px;">Registro não informado.</div>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'] ?? $tipo;
    $id = intval($_POST['id'] ?? 0);

    if ($id <= 0 || !in_array($tipo, ['aluno', 'professor', 'coordenacao', 'secretaria', 'turma', 'disciplina'], true)) {
        $mensagem = '<div class="card">Registro inválido.</div>';
    } elseif ($tipo === 'turma') {
        $nome = trim($_POST['nome'] ?? '');
        $ano_letivo = trim($_POST['ano_letivo'] ?? '');
        $periodo = trim($_POST['periodo'] ?? '');
        if (!empty($nome) && !empty($ano_letivo) && !empty($periodo)) {
            $sql = "UPDATE turma SET nome = ?, ano_letivo = ?, periodo = ? WHERE id_turma = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("sssi", $nome, $ano_letivo, $periodo, $id);
            $stmt->execute();
            $stmt->close();
            $mensagem = '<div style="background: #eaf7ee; color: #1d6f3b; padding: 10px 12px; border-radius: 8px; margin-bottom: 15px;">Turma atualizada com sucesso.</div>';
        }
    } elseif ($tipo === 'disciplina') {
        $nome = trim($_POST['nome'] ?? '');
        $carga_horaria = intval($_POST['carga_horaria'] ?? 0);
        if (!empty($nome) && $carga_horaria > 0) {
            $sql = "UPDATE disciplina SET nome = ?, carga_horaria = ? WHERE id_disciplina = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("sii", $nome, $carga_horaria, $id);
            $stmt->execute();
            $stmt->close();
            $mensagem = '<div style="background: #eaf7ee; color: #1d6f3b; padding: 10px 12px; border-radius: 8px; margin-bottom: 15px;">Disciplina atualizada com sucesso.</div>';
        }
    } else {
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');
        $endereco = trim($_POST['endereco'] ?? '');
        $perfil = trim($_POST['perfil'] ?? 'Aluno');
        if (!in_array($perfil, ['Aluno', 'Professor', 'Coordenação', 'Secretaria'], true)) { $perfil = 'Aluno'; }
        $sql = "UPDATE usuario SET nome = ?, email = ?, telefone = ?, endereco = ?, perfil = ? WHERE id_usuario = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sssssi", $nome, $email, $telefone, $endereco, $perfil, $id);
        $stmt->execute();
        $stmt->close();
        $mensagem = '<div style="background: #eaf7ee; color: #1d6f3b; padding: 10px 12px; border-radius: 8px; margin-bottom: 15px;">Dados do usuário atualizados com sucesso.</div>';
    }
}

if ($id > 0 && in_array($tipo, ['aluno', 'professor', 'coordenacao', 'secretaria', 'turma', 'disciplina'], true)) {
    if ($tipo === 'turma') {
        $sql = "SELECT * FROM turma WHERE id_turma = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id);
    } elseif ($tipo === 'disciplina') {
        $sql = "SELECT * FROM disciplina WHERE id_disciplina = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id);
    } else {
        $sql = "SELECT * FROM usuario WHERE id_usuario = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $id);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $registro = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria | Alterar cadastro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"><style>
*{box-sizing:border-box}body{margin:0;background:#f7f8fc;color:#22243a;font-family:Inter,Arial,sans-serif}main{max-width:1140px;margin:0 auto;padding:44px 36px 75px}h1,h2{letter-spacing:-.035em}a:focus-visible,button:focus-visible,input:focus-visible,select:focus-visible{outline:3px solid #aaa7f8;outline-offset:2px}.header{background:transparent!important;color:#22243a!important;border-radius:0!important;padding:0!important;margin:0 0 26px!important;box-shadow:none!important}.header:before{content:'INSTITUTO ATLAS / SECRETARIA';display:block;color:#6762d8;font-size:11px;font-weight:800;letter-spacing:.13em;margin-bottom:11px}.header h1{font-size:clamp(27px,3vw,35px);margin:0;font-weight:800;line-height:1.2}.container{background:transparent;border:0;box-shadow:none;overflow:visible}.content{padding:0}.card,.filtros,.aluno,.item{background:white;border:1px solid #e7e9f1;border-radius:15px;box-shadow:0 7px 22px rgba(25,30,70,.035)}.card{padding:26px 28px;margin-bottom:18px}.card h2{font-size:15px;color:#24263b;margin:0 0 22px;font-weight:800}.grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px}.grid>div{min-width:0}label,.filtros label{display:block;font-size:12px;font-weight:700;color:#555b72;margin-bottom:8px}input,select,.filtros input,.filtros select{width:100%;min-width:0;background:#fff;border:1px solid #dfe2ed;border-radius:9px;padding:12px 13px;font:inherit;font-size:13px;color:#282b40}input:disabled{background:#f5f6fa;color:#777d8d}input:focus,select:focus{border-color:#7771df;outline:3px solid #efedff}.actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:20px}button,.filtros button,.btn-small{font:inherit;font-size:12px;font-weight:700;border:0;border-radius:9px;padding:12px 17px;cursor:pointer;text-decoration:none;display:inline-flex;justify-content:center;align-items:center}.primary,.filtros button,.btn-edit{background:#6560d8;color:white}.primary:hover,.filtros button:hover,.btn-edit:hover{background:#524dc4}.secondary{background:#eeedff;color:#5550c1}.btn-delete{background:#fff0f1;color:#bb3648}.filtros{padding:22px 24px;margin-bottom:22px}.filtros form{flex-wrap:wrap}.filtros form>div{min-width:180px}.lista{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:15px}.aluno,.item{padding:22px;transition:border-color .15s}.aluno:hover,.item:hover{border-color:#c8c5fa}.nome{font-size:15px;font-weight:800;color:#25283c;margin-bottom:12px;overflow-wrap:anywhere}.dados,.info{font-size:12px;line-height:1.9;color:#676c7e;overflow-wrap:anywhere}.dados strong,.info strong{color:#34394d}.btn-small{flex:1;padding:10px}.actions a{min-width:85px}@media(max-width:800px){main{padding:82px 20px 45px}}@media(max-width:560px){.grid{grid-template-columns:1fr}.card{padding:20px}.filtros{padding:18px}.lista{grid-template-columns:1fr}}
</style>
</head>
<body>
    <?php include '../../includes/menu_secretaria.php'; ?>

    <main>
        <section class="container">
            <div class="header">
                <h1>Alterar cadastro</h1>
            </div>

            <div class="content">
                <?php echo $mensagem; ?>

                <?php if ($registro): ?>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                        <input type="hidden" name="tipo" value="<?php echo htmlspecialchars($tipo); ?>">

                        <?php if ($tipo === 'turma'): ?>
                            <div class="card">
                                <h2>Dados da turma</h2>
                                <div class="grid">
                                    <div>
                                        <label>Nome</label>
                                        <input type="text" name="nome" value="<?php echo htmlspecialchars($registro['nome'] ?? ''); ?>" required>
                                    </div>
                                    <div>
                                        <label>Ano letivo</label>
                                        <input type="number" name="ano_letivo" value="<?php echo htmlspecialchars($registro['ano_letivo'] ?? ''); ?>" required>
                                    </div>
                                    <div>
                                        <label>Período</label>
                                        <select name="periodo">
                                            <option value="Manhã" <?php echo ($registro['periodo'] ?? '') === 'Manhã' ? 'selected' : ''; ?>>Manhã</option>
                                            <option value="Tarde" <?php echo ($registro['periodo'] ?? '') === 'Tarde' ? 'selected' : ''; ?>>Tarde</option>
                                            <option value="Noite" <?php echo ($registro['periodo'] ?? '') === 'Noite' ? 'selected' : ''; ?>>Noite</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php elseif ($tipo === 'disciplina'): ?>
                            <div class="card">
                                <h2>Dados da disciplina</h2>
                                <div class="grid">
                                    <div>
                                        <label>Nome</label>
                                        <input type="text" name="nome" value="<?php echo htmlspecialchars($registro['nome'] ?? ''); ?>" required>
                                    </div>
                                    <div>
                                        <label>Carga horária</label>
                                        <input type="number" name="carga_horaria" value="<?php echo htmlspecialchars($registro['carga_horaria'] ?? ''); ?>" required>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="card">
                                <h2>Dados pessoais</h2>
                                <div class="grid">
                                    <div>
                                        <label>Perfil</label>
                                        <select name="perfil">
                                            <option value="Aluno" <?php echo ($registro['perfil'] ?? '') === 'Aluno' ? 'selected' : ''; ?>>Aluno</option>
                                            <option value="Professor" <?php echo ($registro['perfil'] ?? '') === 'Professor' ? 'selected' : ''; ?>>Professor</option>
                                            <option value="Coordenação" <?php echo ($registro['perfil'] ?? '') === 'Coordenação' ? 'selected' : ''; ?>>Coordenação</option>
                                            <option value="Secretaria" <?php echo ($registro['perfil'] ?? '') === 'Secretaria' ? 'selected' : ''; ?>>Secretaria</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label>Nome completo</label>
                                        <input type="text" name="nome" value="<?php echo htmlspecialchars($registro['nome'] ?? ''); ?>" required>
                                    </div>
                                    <div>
                                        <label>CPF</label>
                                        <input type="text" value="<?php echo htmlspecialchars($registro['cpf'] ?? ''); ?>" disabled>
                                    </div>
                                    <div>
                                        <label>Data de nascimento</label>
                                        <input type="date" value="<?php echo htmlspecialchars($registro['data_nascimento'] ?? ''); ?>" disabled>
                                    </div>
                                    <div>
                                        <label>Telefone</label>
                                        <input type="text" name="telefone" value="<?php echo htmlspecialchars($registro['telefone'] ?? ''); ?>">
                                    </div>
                                    <div>
                                        <label>E-mail</label>
                                        <input type="email" name="email" value="<?php echo htmlspecialchars($registro['email'] ?? ''); ?>" required>
                                    </div>
                                    <div style="grid-column: 1 / -1;">
                                        <label>Endereço</label>
                                        <input type="text" name="endereco" value="<?php echo htmlspecialchars($registro['endereco'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="actions">
                            <button class="primary" type="submit">Salvar alterações</button>
                            <button class="secondary" type="button" onclick="window.history.back();">Cancelar</button>
                        </div>
                    </form>
                <?php else: ?>
                    <div style="background: #fff; padding: 30px; border-radius: 12px; color: #666; text-align: center;">
                        Registro não encontrado. Abra um cadastro pela página de consultas para editar.
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html>
