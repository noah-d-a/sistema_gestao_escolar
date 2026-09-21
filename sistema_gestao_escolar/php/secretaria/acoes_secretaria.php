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
$tipo = strtolower(trim($_GET['tipo'] ?? ''));
if (!isset($tipos[$tipo])) {
    header('Location: cadastros_secretaria.php');
    exit();
}
$nome_tipo = $tipos[$tipo];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria | Ações</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f3f6fb; color: #1f2937; }
        main { max-width: 1000px; margin: 32px auto; padding: 0 20px 40px; }
        .hero { background: linear-gradient(135deg, #0d4a8f, #1f8ad9); color: #fff; padding: 28px; border-radius: 18px; margin-bottom: 24px; }
        .hero h1 { margin: 0; font-size: 2rem; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 18px; }
        .item { display: block; background: #fff; color: #123d70; text-decoration: none; border: 1px solid #e2eaf5; border-radius: 16px; padding: 22px; box-shadow: 0 8px 20px rgba(15,23,42,.05); }
        .item h2 { margin: 0 0 8px; }
        .item p { margin: 0; color: #64748b; }
    </style>
</head>
<body>
    <?php include '../../includes/menu_secretaria.php'; ?>
    <main>
        <section class="hero"><h1>Ações: <?php echo htmlspecialchars($nome_tipo); ?></h1></section>
        <section class="grid">
            <a class="item" href="cadastrar_secretaria.php?tipo=<?php echo urlencode($tipo); ?>"><h2>Cadastrar</h2><p>Adicionar um novo registro.</p></a>
            <a class="item" href="<?php echo $tipo === 'aluno' ? 'turmas_secretaria.php' : 'consultas_secretaria.php'; ?>?tipo=<?php echo urlencode($tipo); ?>&acao=consultar"><h2>Consultar</h2><p>Visualizar os registros cadastrados.</p></a>
            <a class="item" href="<?php echo $tipo === 'aluno' ? 'turmas_secretaria.php' : 'consultas_secretaria.php'; ?>?tipo=<?php echo urlencode($tipo); ?>&acao=atualizar"><h2>Atualizar</h2><p>Alterar dados permitidos.</p></a>
            <a class="item" href="<?php echo $tipo === 'aluno' ? 'turmas_secretaria.php' : 'consultas_secretaria.php'; ?>?tipo=<?php echo urlencode($tipo); ?>&acao=deletar"><h2>Deletar</h2><p>Excluir um registro existente.</p></a>
        </section>
    </main>
</body>
</html>
