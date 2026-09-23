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
*{box-sizing:border-box}body{margin:0;background:#f7f8fc;color:#202338;font-family:Inter,Arial,sans-serif}main{max-width:1200px;margin:0 auto;padding:44px 36px 70px}h1,h2,h3{letter-spacing:-.04em}a:focus-visible,button:focus-visible,input:focus-visible,select:focus-visible{outline:3px solid #b6b4ff;outline-offset:2px}.topo,.cabecalho,.hero{background:transparent!important;color:#202338!important;border-radius:0!important;box-shadow:none!important;padding:0!important;margin:0 0 28px!important}.topo:before,.cabecalho:before,.hero:before{content:'INSTITUTO ATLAS / SECRETARIA';display:block;color:#6664df;font-size:11px;font-weight:800;letter-spacing:.14em;margin-bottom:10px}.topo h1,.cabecalho h1,.hero h1{font-size:clamp(25px,3vw,34px)!important;line-height:1.2;margin:0!important}.box,.item{background:#fff;border:1px solid #e7e9f1;border-radius:16px;box-shadow:0 8px 26px #1b224006}.box{padding:30px}.item{display:block;text-decoration:none;padding:24px;color:#252741;transition:border-color .16s,transform .16s}.item:hover{border-color:#aaa8ff;transform:translateY(-2px)}.item h2,.item h3{font-size:17px;color:#252741;margin:0 0 10px}.item p{font-size:13px;line-height:1.65;color:#777d93;margin:0}.grid,.lista{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px}.lista .item .topo{font-size:10px!important;letter-spacing:.13em;color:#6664df!important;font-weight:800;margin:0 0 12px!important}.lista .item .topo:before{display:none}form{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px}.campo{display:flex;flex-direction:column;gap:8px}.campo.full,.botoes{grid-column:1/-1}label{font-size:12px;font-weight:700;color:#363a52}input,select{width:100%;min-height:45px;padding:11px 13px;border-radius:10px;border:1px solid #e1e4f0;background:#fff;font:inherit;font-size:13px;color:#252741}input:disabled{background:#f5f6fa;color:#626a80;opacity:1;cursor:not-allowed}.botoes{display:flex;gap:10px;flex-wrap:wrap;margin-top:5px}button{font:inherit;border:0;border-radius:10px;padding:12px 18px;font-size:12px;font-weight:700;cursor:pointer}.principal{background:#6664df;color:white}.principal:hover{background:#5351c7}.secundario{background:#efeeff;color:#5653c4}.secundario:hover{background:#e3e1ff}@media(max-width:800px){main{padding:78px 20px 48px}}@media(max-width:580px){form{grid-template-columns:1fr}.box{padding:20px}.grid,.lista{grid-template-columns:1fr}}
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
            <a class="item" href="<?php echo $tipo === 'aluno' ? 'turmas_secretaria.php' : 'consultas_secretaria.php'; ?>?tipo=<?php echo urlencode($tipo); ?>&acao=deletar"><h2>Excluir</h2><p>Excluir um registro existente.</p></a>
        </section>
    </main>
</body>
</html>
