<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Secretaria');

$tipos = [
    'aluno' => 'Aluno',
    'professor' => 'Professor',
    'coordenacao' => 'Coordenação',
    'secretaria' => 'Secretaria',
    'turma' => 'Turma',
    'disciplina' => 'Disciplina'
];
$tipo = strtolower(trim($_GET['tipo'] ?? $_POST['tipo'] ?? ''));
if (!isset($tipos[$tipo])) {
    header('Location: cadastros_secretaria.php');
    exit();
}
$mensagem = '';
$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($tipo === 'turma') {
        $nome = trim($_POST['nome'] ?? '');
        $ano_letivo = intval($_POST['ano_letivo'] ?? 0);
        $periodo = trim($_POST['periodo'] ?? '');
        if ($nome !== '' && $ano_letivo >= 2000 && in_array($periodo, ['Manhã', 'Tarde', 'Noite'], true)) {
            $stmt = $conexao->prepare('INSERT INTO turma (nome, ano_letivo, periodo) VALUES (?, ?, ?)');
            $stmt->bind_param('sis', $nome, $ano_letivo, $periodo);
            $sucesso = $stmt->execute();
            $stmt->close();
        }
    } elseif ($tipo === 'disciplina') {
        $nome = trim($_POST['nome'] ?? '');
        $carga_horaria = intval($_POST['carga_horaria'] ?? 0);
        if ($nome !== '' && $carga_horaria > 0) {
            $stmt = $conexao->prepare('INSERT INTO disciplina (nome, carga_horaria) VALUES (?, ?)');
            $stmt->bind_param('si', $nome, $carga_horaria);
            $sucesso = $stmt->execute();
            $stmt->close();
        }
    } else {
        $nome = trim($_POST['nome'] ?? '');
        $cpf = trim($_POST['cpf'] ?? '');
        $rg = trim($_POST['rg'] ?? '');
        $data_nascimento = trim($_POST['data_nascimento'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = trim($_POST['senha'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');
        $endereco = trim($_POST['endereco'] ?? '');
        $id_turma = intval($_POST['id_turma'] ?? 0);
        $rm = trim($_POST['rm'] ?? '');
        $data_matricula = trim($_POST['data_matricula'] ?? date('Y-m-d'));

        if ($nome !== '' && filter_var($email, FILTER_VALIDATE_EMAIL) && $senha !== '') {
            $conexao->begin_transaction();
            $stmt = $conexao->prepare('INSERT INTO usuario (perfil, nome, cpf, rg, data_nascimento, email, senha, telefone, endereco, ativo) VALUES (?, ?, ?, ?, NULLIF(?, ""), ?, ?, ?, ?, 1)');
            $perfil = $tipos[$tipo];
            $stmt->bind_param('sssssssss', $perfil, $nome, $cpf, $rg, $data_nascimento, $email, $senha, $telefone, $endereco);
            $sucesso = $stmt->execute();
            $id_aluno = $conexao->insert_id;
            $stmt->close();

            if ($sucesso && $tipo === 'aluno') {
                if ($id_turma <= 0 || $rm === '' || $data_matricula === '') {
                    $sucesso = false;
                } else {
                    $stmt = $conexao->prepare('INSERT INTO matricula (rm, id_aluno, id_turma, data_matricula) VALUES (?, ?, ?, ?)');
                    $stmt->bind_param('siis', $rm, $id_aluno, $id_turma, $data_matricula);
                    $sucesso = $stmt->execute();
                    $stmt->close();
                }
            }

            if ($sucesso) {
                $conexao->commit();
            } else {
                $conexao->rollback();
            }
        }
    }

    $mensagem = $sucesso
        ? '<div style="background: #eaf7ee; color: #1d6f3b; padding: 10px 12px; border-radius: 8px; margin-bottom: 15px;">' . htmlspecialchars($tipos[$tipo]) . ' cadastrado(a) com sucesso.</div>'
        : '<div style="background: #fee; color: #9d1c1c; padding: 10px 12px; border-radius: 8px; margin-bottom: 15px;">Não foi possível cadastrar. Verifique os campos obrigatórios e os dados duplicados.</div>';
}

$turmas = [];
if ($tipo === 'aluno') {
    $result = $conexao->query('SELECT id_turma, nome, ano_letivo, periodo FROM turma ORDER BY nome');
    while ($row = $result->fetch_assoc()) {
        $turmas[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria | Cadastrar <?php echo htmlspecialchars($tipos[$tipo]); ?></title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f3f6fb; color: #1f2937; }
        main { max-width: 980px; margin: 32px auto; padding: 0 20px 40px; }
        .topo { background: linear-gradient(135deg, #0d3d70, #1f8fd8); color: white; border-radius: 18px; padding: 28px 30px; margin-bottom: 24px; }
        .topo h1 { margin: 0; font-size: 2rem; }
        .box { background: #fff; border: 1px solid #e2eaf5; border-radius: 18px; padding: 28px; box-shadow: 0 10px 25px rgba(15,23,42,.04); }
        form { display: grid; grid-template-columns: repeat(2, minmax(220px, 1fr)); gap: 18px 22px; }
        .campo { display: flex; flex-direction: column; gap: 8px; }
        .full { grid-column: 1 / -1; }
        label { font-weight: bold; color: #26405d; }
        input, select { width: 100%; padding: 11px 12px; border-radius: 10px; border: 1px solid #dfe8f4; background: #f9fbff; font-size: .95rem; }
        .botoes { grid-column: 1 / -1; display: flex; gap: 12px; margin-top: 8px; }
        button { border: none; border-radius: 10px; padding: 12px 18px; font-weight: bold; cursor: pointer; }
        .principal { background: #0d4a8f; color: white; }
        .secundario { background: #edf3ff; color: #154c82; }
    </style>
</head>
<body>
    <?php include '../../includes/menu_secretaria.php'; ?>
    <main>
        <section class="topo"><h1>Cadastrar <?php echo htmlspecialchars($tipos[$tipo]); ?></h1></section>
        <section class="box">
            <?php echo $mensagem; ?>
            <form method="POST">
                <input type="hidden" name="tipo" value="<?php echo htmlspecialchars($tipo); ?>">
                <?php if ($tipo === 'turma'): ?>
                    <div class="campo"><label for="nome">Nome da turma</label><input id="nome" name="nome" required></div>
                    <div class="campo"><label for="ano_letivo">Ano letivo</label><input id="ano_letivo" name="ano_letivo" type="number" min="2000" required></div>
                    <div class="campo"><label for="periodo">Período</label><select id="periodo" name="periodo" required><option value="">Selecione</option><option>Manhã</option><option>Tarde</option><option>Noite</option></select></div>
                <?php elseif ($tipo === 'disciplina'): ?>
                    <div class="campo"><label for="nome">Nome da disciplina</label><input id="nome" name="nome" required></div>
                    <div class="campo"><label for="carga_horaria">Carga horária</label><input id="carga_horaria" name="carga_horaria" type="number" min="1" required></div>
                <?php else: ?>
                    <div class="campo"><label for="nome">Nome completo</label><input id="nome" name="nome" required></div>
                    <div class="campo"><label for="cpf">CPF</label><input id="cpf" name="cpf"></div>
                    <div class="campo"><label for="rg">RG</label><input id="rg" name="rg"></div>
                    <div class="campo"><label for="data_nascimento">Data de nascimento</label><input id="data_nascimento" name="data_nascimento" type="date"></div>
                    <div class="campo"><label for="email">E-mail</label><input id="email" name="email" type="email" required></div>
                    <div class="campo"><label for="senha">Senha</label><input id="senha" name="senha" type="password" required></div>
                    <div class="campo"><label for="telefone">Telefone</label><input id="telefone" name="telefone"></div>
                    <div class="campo"><label for="endereco">Endereço</label><input id="endereco" name="endereco"></div>
                    <?php if ($tipo === 'aluno'): ?>
                        <div class="campo"><label for="rm">RM</label><input id="rm" name="rm" required></div>
                        <div class="campo"><label for="data_matricula">Data da matrícula</label><input id="data_matricula" name="data_matricula" type="date" value="<?php echo date('Y-m-d'); ?>" required></div>
                        <div class="campo full"><label for="id_turma">Turma</label><select id="id_turma" name="id_turma" required><option value="">Selecione uma turma</option><?php foreach ($turmas as $turma): ?><option value="<?php echo $turma['id_turma']; ?>"><?php echo htmlspecialchars($turma['nome'] . ' - ' . $turma['ano_letivo'] . ' - ' . $turma['periodo']); ?></option><?php endforeach; ?></select></div>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="botoes"><button class="principal" type="submit">Salvar cadastro</button><button class="secundario" type="reset">Limpar</button></div>
            </form>
        </section>
    </main>
</body>
</html>
