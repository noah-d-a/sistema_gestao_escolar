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
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box}body{margin:0;background:#f7f8fc;color:#202338;font-family:Inter,Arial,sans-serif}main{max-width:1190px;margin:0 auto;padding:44px 36px 70px}h1,h2{letter-spacing:-.04em}a:focus-visible,button:focus-visible,input:focus-visible,select:focus-visible{outline:3px solid #b6b4ff;outline-offset:2px}.topo,.header{margin:0 0 28px;padding:0;background:none;color:#202338;border-radius:0}.topo:before,.header:before{content:'INSTITUTO ATLAS / SECRETARIA';display:block;color:#6664df;font-size:11px;font-weight:800;letter-spacing:.14em;margin-bottom:12px}.topo h1,.header h1{font-size:clamp(25px,3vw,34px);line-height:1.2;margin:0}.box{background:#fff;border:1px solid #e7e9f1;border-radius:16px;padding:30px;box-shadow:0 8px 26px #1b224006}.box:before{content:'DADOS DO REGISTRO';display:block;font-size:11px;letter-spacing:.12em;font-weight:800;color:#777d93;margin-bottom:24px}form{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px}.campo{display:flex;flex-direction:column;gap:8px}.full,.botoes{grid-column:1/-1}label{font-size:12px;font-weight:700;color:#363a52}input,select{width:100%;min-height:45px;padding:11px 13px;border-radius:10px;border:1px solid #e1e4f0;background:#fff;font:inherit;font-size:13px;color:#252741}input:hover,select:hover{border-color:#b4b3e7}.botoes{display:flex;gap:10px;flex-wrap:wrap;margin-top:8px}button{font:inherit;border:0;border-radius:10px;padding:12px 18px;font-size:12px;font-weight:700;cursor:pointer}.principal{background:#6664df;color:#fff}.principal:hover{background:#5351c7}.secundario{background:#efeeff;color:#5653c4}.secundario:hover{background:#e3e1ff}.lista{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:15px}.item{display:block;text-decoration:none;background:#fff;border:1px solid #e7e9f1;border-radius:15px;padding:22px;color:#252741;transition:border-color .16s,transform .16s}.item:hover{border-color:#aaa8ff;transform:translateY(-2px)}.item h2{margin:0 0 10px;font-size:17px}.item p{margin:5px 0;color:#777d93;font-size:13px;line-height:1.6}.item:after{content:'Ver detalhes  →';display:block;margin-top:19px;color:#6664df;font-size:12px;font-weight:700}.vazio{background:#fff;border:1px solid #e7e9f1;padding:32px;border-radius:15px;color:#777d93}.back{display:inline-block;color:#6664df;font-size:12px;font-weight:700;text-decoration:none;margin-bottom:16px}.back:hover{text-decoration:underline}@media(max-width:800px){main{padding:78px 20px 48px}}@media(max-width:580px){form{grid-template-columns:1fr}.box{padding:20px}.lista{grid-template-columns:1fr}}
</style>
</head>
<body>
    <?php include '../../includes/menu_secretaria.php'; ?>
    <main>
        <a class="back" href="cadastros_secretaria.php">← Voltar aos cadastros</a>
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
                    <div class="campo"><label for="senha">Senha</label><input id="senha" name="senha" type="password" autocomplete="new-password" required></div>
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
