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

    if ($tipo === 'turma') {
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
        $sql = "UPDATE usuario SET nome = ?, email = ?, telefone = ?, endereco = ?, perfil = ? WHERE id_usuario = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sssssi", $nome, $email, $telefone, $endereco, $perfil, $id);
        $stmt->execute();
        $stmt->close();
        $mensagem = '<div style="background: #eaf7ee; color: #1d6f3b; padding: 10px 12px; border-radius: 8px; margin-bottom: 15px;">Dados do usuário atualizados com sucesso.</div>';
    }
}

if ($id > 0) {
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
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f3f7fb; color: #20304a; }
        nav { background: #0b1f3a; }
        main { max-width: 1000px; margin: 32px auto; padding: 0 20px 40px; }
        .container { background: white; border-radius: 18px; border: 1px solid #e2eaf5; box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05); overflow: hidden; }
        .header { background: linear-gradient(135deg, #0d406f, #1d8ec7); color: white; padding: 24px 28px; }
        .header h1 { margin: 0; font-size: 2rem; }
        .content { padding: 28px; }
        .card { border: 1px solid #e6edf7; border-radius: 14px; padding: 18px; background: #fbfdff; margin-bottom: 18px; }
        .card h2 { margin: 0 0 14px; color: #103f71; font-size: 1.2rem; }
        .grid { display: grid; grid-template-columns: repeat(2, minmax(220px, 1fr)); gap: 14px 18px; }
        label { display: block; font-weight: bold; margin-bottom: 7px; color: #2e4665; }
        input, select { width: 100%; padding: 10px 12px; border-radius: 10px; border: 1px solid #dfe8f4; background: #f9fbff; }
        .actions { display: flex; gap: 12px; margin-top: 20px; }
        button { border: none; border-radius: 10px; padding: 12px 18px; font-weight: bold; cursor: pointer; }
        .primary { background: #0d4a8f; color: white; }
        .secondary { background: #eaf3ff; color: #0b447d; }
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
                        Registro não encontrado.
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html>
