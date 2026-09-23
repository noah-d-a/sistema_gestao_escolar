<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Secretaria');

$id_secretario = $_SESSION['id_usuario'];
$mensagem = '';

$sql = "SELECT COUNT(*) AS total FROM usuario WHERE perfil = 'Secretaria' AND ativo = 1";
$stmt = $conexao->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$total_secretarias = (int) ($result->fetch_assoc()['total'] ?? 0);
$stmt->close();
$pode_editar = $total_secretarias <= 1;

// Buscar dados do secretário
$sql = "SELECT * FROM usuario WHERE id_usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_secretario);
$stmt->execute();
$result = $stmt->get_result();
$secretario = $result->fetch_assoc();
$stmt->close();

// Se enviar formulário
if (isset($_POST['salvar']) && $pode_editar) {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');
    
    if (!empty($nome) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = "UPDATE usuario SET nome = ?, email = ?, telefone = ?, endereco = ? WHERE id_usuario = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssssi", $nome, $email, $telefone, $endereco, $id_secretario);
        
        if ($stmt->execute()) {
            $mensagem = '<div style="background: #efe; color: #363; padding: 10px; border-radius: 5px; margin-bottom: 15px;">Cadastro atualizado com sucesso!</div>';
            $_SESSION['nome'] = $nome;
            $secretario['nome'] = $nome;
            $secretario['email'] = $email;
            $secretario['telefone'] = $telefone;
            $secretario['endereco'] = $endereco;
        }
        $stmt->close();
    } else {
        $mensagem = '<div style="background: #fee; color: #9d1c1c; padding: 10px; border-radius: 5px; margin-bottom: 15px;">Informe um nome e um e-mail válido.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Secretaria | Meu cadastro</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box}body{margin:0;background:#f7f8fc;color:#202338;font-family:Inter,Arial,sans-serif}main{max-width:1120px;margin:0 auto;padding:45px 36px 75px}h1,h2,p{margin-top:0}.eyebrow{color:#6664df;font-size:11px;letter-spacing:.15em;font-weight:800;margin-bottom:12px}.heading h1{font-size:clamp(27px,3vw,35px);letter-spacing:-.045em;margin-bottom:9px}.heading p{color:#777d93;font-size:13px;line-height:1.6;margin-bottom:30px}.profile{display:flex;align-items:center;gap:20px;padding:27px 30px;background:#fff;border:1px solid #e7e9f1;border-radius:17px;margin-bottom:18px}.profile-avatar{width:60px;height:60px;border-radius:17px;display:grid;place-items:center;background:#eeedff;color:#6260d6;font-weight:800;font-size:24px;flex:none}.profile h2{font-size:21px;letter-spacing:-.035em;margin:0 0 6px;overflow-wrap:anywhere}.profile p{color:#777d93;font-size:12px;margin:0}.profile-tag{margin-left:auto;white-space:nowrap;border-radius:99px;padding:9px 12px;background:#f2f1ff;color:#5956c6;font-size:11px;font-weight:700}.sections{display:grid;grid-template-columns:1fr 1fr;gap:18px}.panel{min-width:0;background:#fff;border:1px solid #e7e9f1;border-radius:17px;padding:27px 29px}.panel h2{font-size:16px;letter-spacing:-.025em;margin:0 0 6px}.panel-desc{font-size:12px;color:#888da0;line-height:1.6;margin:0 0 22px}.details{margin:0}.detail{padding:15px 0;border-top:1px solid #eff0f5}.detail dt{font-size:11px;color:#858ba0;font-weight:650;margin-bottom:7px}.detail dd{font-size:13px;font-weight:600;color:#292d43;margin:0;line-height:1.5;overflow-wrap:anywhere}.detail dd.empty{color:#a0a4b5;font-weight:400}.note{display:flex;gap:10px;align-items:flex-start;margin-top:18px;color:#777d93;font-size:12px;line-height:1.7;padding:0 4px}.note svg{flex:none;margin-top:2px;color:#8583df}.status{margin:0 0 18px}.edit-panel{margin-top:18px}.edit-grid{display:grid;grid-template-columns:1fr 1fr;gap:17px}.field{display:flex;flex-direction:column;gap:8px}.field.full{grid-column:1/-1}.field label{font-size:12px;font-weight:700}.field input{font:inherit;font-size:13px;min-height:44px;padding:11px 12px;border:1px solid #e1e4f0;border-radius:9px;background:#fff;color:#202338;width:100%}.field input:focus-visible,button:focus-visible{outline:3px solid #b6b4ff;outline-offset:2px}.actions{display:flex;gap:10px;margin-top:22px;flex-wrap:wrap}.actions button{border:0;border-radius:9px;padding:12px 18px;font:inherit;font-size:12px;font-weight:700;cursor:pointer}.primary{background:#6664df;color:#fff}.secondary{background:#f0efff;color:#5653c4}@media(max-width:850px){.sections{grid-template-columns:1fr}main{padding:78px 20px 50px}}@media(max-width:560px){.profile{padding:22px;gap:13px;flex-wrap:wrap}.profile-avatar{width:49px;height:49px;font-size:20px}.profile-tag{margin-left:0}.panel{padding:23px 20px}.edit-grid{grid-template-columns:1fr}.field.full{grid-column:auto}}
</style>
</head>
<body>
<?php include '../../includes/menu_secretaria.php'; ?>
<main>
<header class="heading"><div class="eyebrow">INSTITUTO ATLAS / SECRETARIA</div><h1>Meu cadastro</h1><p>Consulte as informações vinculadas à sua conta institucional.</p></header>
<?php if ($mensagem): ?><div class="status" role="status"><?php echo $mensagem; ?></div><?php endif; ?>
<section class="profile" aria-label="Identificação da conta">
<div class="profile-avatar" aria-hidden="true"><?php echo htmlspecialchars(strtoupper(substr(trim($secretario['nome'] ?? 'S'),0,1)), ENT_QUOTES, 'UTF-8'); ?></div>
<div><h2><?php echo htmlspecialchars($secretario['nome'] ?? 'Secretaria', ENT_QUOTES, 'UTF-8'); ?></h2><p>Equipe administrativa · Instituto Atlas</p></div><span class="profile-tag">Conta da secretaria</span>
</section>
<div class="sections">
<section class="panel" aria-labelledby="personal-title"><h2 id="personal-title">Dados pessoais</h2><p class="panel-desc">Informações de identificação registradas no sistema.</p><dl class="details">
<?php foreach (['nome'=>'Nome completo','cpf'=>'CPF','rg'=>'RG','data_nascimento'=>'Data de nascimento'] as $key=>$label): $value=trim((string)($secretario[$key] ?? '')); if ($key==='data_nascimento' && $value !== '') { $date=DateTime::createFromFormat('Y-m-d', $value); if ($date) $value=$date->format('d/m/Y'); } ?>
<div class="detail"><dt><?php echo $label; ?></dt><dd<?php echo $value===''?' class="empty"':''; ?>><?php echo htmlspecialchars($value!==''?$value:'Não informado',ENT_QUOTES,'UTF-8'); ?></dd></div>
<?php endforeach; ?>
</dl></section>
<section class="panel" aria-labelledby="contact-title"><h2 id="contact-title">Contato e endereço</h2><p class="panel-desc">Dados utilizados para comunicação e identificação.</p><dl class="details">
<?php foreach (['telefone'=>'Telefone','email'=>'E-mail','endereco'=>'Endereço'] as $key=>$label): $value=trim((string)($secretario[$key] ?? '')); ?>
<div class="detail"><dt><?php echo $label; ?></dt><dd<?php echo $value===''?' class="empty"':''; ?>><?php echo htmlspecialchars($value!==''?$value:'Não informado',ENT_QUOTES,'UTF-8'); ?></dd></div>
<?php endforeach; ?>
</dl></section>
</div>
<?php if (!$pode_editar): ?>
<p class="note"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 11v5m0-9h.01"/></svg><span>Este cadastro é somente para consulta. Para alterar seus dados, procure outro membro da secretaria.</span></p>
<?php else: ?>
<section class="panel edit-panel" aria-labelledby="edit-title"><h2 id="edit-title">Atualizar informações</h2><p class="panel-desc">Edite os dados permitidos e salve as alterações.</p>
<form method="post" class="edit-grid">
<div class="field"><label for="nome">Nome completo</label><input id="nome" name="nome" required value="<?php echo htmlspecialchars($secretario['nome'] ?? '',ENT_QUOTES,'UTF-8'); ?>"></div>
<div class="field"><label for="telefone">Telefone</label><input id="telefone" name="telefone" value="<?php echo htmlspecialchars($secretario['telefone'] ?? '',ENT_QUOTES,'UTF-8'); ?>"></div>
<div class="field full"><label for="email">E-mail</label><input id="email" type="email" name="email" required value="<?php echo htmlspecialchars($secretario['email'] ?? '',ENT_QUOTES,'UTF-8'); ?>"></div>
<div class="field full"><label for="endereco">Endereço</label><input id="endereco" name="endereco" value="<?php echo htmlspecialchars($secretario['endereco'] ?? '',ENT_QUOTES,'UTF-8'); ?>"></div>
<div class="actions field full"><button class="primary" type="submit" name="salvar" value="1">Salvar alterações</button><button class="secondary" type="reset">Restaurar campos</button></div>
</form></section>
<?php endif; ?>
</main></body></html>
