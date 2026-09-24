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
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box}body{margin:0;background:#f7f8fc;color:#202338;font-family:Inter,Arial,sans-serif}main{max-width:1120px;margin:0 auto;padding:48px 40px 80px}h1,h2{letter-spacing:-.04em}.hero{margin:0 0 34px}.hero:before{content:'INSTITUTO ATLAS / SECRETARIA';display:block;color:#6664df;font-size:11px;font-weight:800;letter-spacing:.14em;margin-bottom:11px}.hero h1{font-size:clamp(29px,3vw,38px);line-height:1.12;margin:0}.hero p{margin:12px 0 0;color:#777d93;font-size:14px}.back{display:inline-flex;margin-bottom:22px;color:#5d59d8;text-decoration:none;font-size:12px;font-weight:750}.grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px}.item{min-height:220px;display:flex;flex-direction:column;text-decoration:none;padding:30px;background:#fff;border:1px solid #e5e7f0;border-radius:18px;color:#252741;box-shadow:0 8px 26px #1b224006;transition:.18s}.item:hover{border-color:#aaa8ff;transform:translateY(-3px);box-shadow:0 16px 34px #35307b0d}.icon{width:50px;height:50px;border-radius:14px;background:#efeeff;color:#625fe0;display:grid;place-items:center;margin-bottom:26px}.icon svg{width:24px;height:24px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}.item h2{font-size:20px;margin:0 0 9px}.item p{font-size:13px;line-height:1.65;color:#777d93;margin:0}.item .go{margin-top:auto;padding-top:22px;color:#5d59d8;font-size:12px;font-weight:750}.danger .icon{background:#fff0f1;color:#b94353}.danger:hover{border-color:#e5a8b0}.danger .go{color:#b94353}a:focus-visible{outline:3px solid #b6b4ff;outline-offset:2px}@media(max-width:800px){main{padding:78px 20px 50px}}@media(max-width:620px){.grid{grid-template-columns:1fr}.item{min-height:190px}}
</style>
</head>
<body>
    <?php include '../../includes/menu_secretaria.php'; ?>
    <main>
        <a class="back" href="cadastros_secretaria.php">← Voltar para cadastros</a><section class="hero"><h1><?php echo htmlspecialchars($nome_tipo); ?></h1><p>Escolha o que deseja fazer com os registros de <?php echo htmlspecialchars(mb_strtolower($nome_tipo)); ?>.</p></section>
        <section class="grid">
<a class="item" href="cadastrar_secretaria.php?tipo=<?php echo urlencode($tipo); ?>"><div class="icon"><svg viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg></div><h2>Cadastrar <?php echo htmlspecialchars(mb_strtolower($nome_tipo)); ?></h2><p>Adicionar um novo registro ao sistema.</p><span class="go">Iniciar cadastro →</span></a>
<a class="item" href="<?php echo $tipo === 'aluno' ? 'turmas_secretaria.php' : 'consultas_secretaria.php'; ?>?tipo=<?php echo urlencode($tipo); ?>&acao=consultar"><div class="icon"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg></div><h2>Consultar registros</h2><p>Visualizar informações já cadastradas.</p><span class="go">Ver registros →</span></a>
<a class="item" href="<?php echo $tipo === 'aluno' ? 'turmas_secretaria.php' : 'consultas_secretaria.php'; ?>?tipo=<?php echo urlencode($tipo); ?>&acao=atualizar"><div class="icon"><svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4Z"/></svg></div><h2>Atualizar cadastro</h2><p>Editar informações de um registro existente.</p><span class="go">Selecionar registro →</span></a>
<a class="item danger" href="<?php echo $tipo === 'aluno' ? 'turmas_secretaria.php' : 'consultas_secretaria.php'; ?>?tipo=<?php echo urlencode($tipo); ?>&acao=deletar"><div class="icon"><svg viewBox="0 0 24 24"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6M10 11v5M14 11v5"/></svg></div><h2>Excluir cadastro</h2><p>Remover um registro existente do sistema.</p><span class="go">Selecionar registro →</span></a>
</section>
    </main>
</body>
</html>
