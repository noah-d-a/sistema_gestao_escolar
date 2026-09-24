<?php
session_start();
require __DIR__ . '/../includes/conexao.php';

$enviado = false;
$erro = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if ($email === '') {
        $erro = 'Informe seu e-mail para continuar.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Digite um e-mail válido.';
    } else {
        $stmt = $conexao->prepare('SELECT id_usuario FROM usuario WHERE email = ? AND ativo = 1 LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Demonstração: a conta é validada no banco, mas nenhum e-mail é enviado de verdade.
            $enviado = true;
        } else {
            $erro = 'Não encontramos nenhuma conta ativa cadastrada com esse e-mail.';
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Recuperar senha | Instituto Atlas</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
<style>
:root{--navy:#192b49;--purple:#7654d8;--ink:#202b40;--muted:#657187;--line:#dfe4f0}*{box-sizing:border-box}body{margin:0;min-height:100vh;font-family:'DM Sans',Arial,sans-serif;color:var(--ink);background:#f7f7ff}a{color:inherit;text-decoration:none}button,input{font:inherit}.page{min-height:100vh;display:grid;grid-template-columns:minmax(0,1.1fr) minmax(430px,.9fr)}.visual{position:relative;isolation:isolate;min-height:100vh;display:flex;flex-direction:column;justify-content:space-between;padding:42px clamp(30px,4.6vw,76px);color:#fff;background:linear-gradient(145deg,#101d31,#192b49 58%,#2a2452);overflow:hidden}.visual:before{content:'';position:absolute;width:560px;height:560px;border:110px solid rgba(118,84,216,.2);border-radius:50%;right:-280px;bottom:-280px;z-index:-1}.visual-top{display:flex;align-items:center;justify-content:space-between;gap:24px;flex-wrap:wrap}.brand{display:inline-flex;align-items:center;gap:10px}.brand svg{width:45px;height:45px}.brand-text{display:flex;flex-direction:column;line-height:1}.brand-text span{font-size:10px;letter-spacing:.26em;font-weight:800;margin-bottom:5px}.brand-text strong{font:800 23px Montserrat,sans-serif;letter-spacing:.04em}.back{display:inline-flex;align-items:center;gap:9px;padding:11px 14px;border:1px solid rgba(255,255,255,.4);border-radius:9px;color:#fff;font-size:13px;font-weight:700;background:rgba(10,20,35,.25)}.visual-content{max-width:570px;padding:70px 0}.eyebrow{font-size:11px;font-weight:800;letter-spacing:.25em;text-transform:uppercase;color:#e4d9ff}.visual h1{font:800 clamp(40px,4.2vw,66px)/1.13 Montserrat,sans-serif;letter-spacing:-.055em;margin:23px 0}.visual h1 em{font-style:normal;color:#d6c3ff}.visual-content p{font-size:16px;line-height:1.85;color:#f2f3f9;max-width:455px}.visual-foot{max-width:390px;padding-left:19px;border-left:3px solid #b59aff;font-size:12px;letter-spacing:.16em;line-height:1.7;text-transform:uppercase;color:#f0ecff}.access{position:relative;display:flex;align-items:center;justify-content:center;padding:56px clamp(24px,4vw,65px);overflow:hidden}.access:before,.access:after{content:'';position:absolute;border-radius:50%;border:70px solid #eae5ff;opacity:.48}.access:before{width:330px;height:330px;right:-230px;top:-280px}.access:after{width:360px;height:360px;right:-280px;bottom:-300px}.card{position:relative;z-index:1;width:100%;max-width:515px;background:#fff;border:1px solid #ececf6;border-radius:22px;box-shadow:0 22px 65px rgba(32,32,85,.09);padding:clamp(30px,3.2vw,53px)}.card-brand{display:flex;align-items:center;justify-content:center;gap:12px;margin:0 auto 37px;width:max-content}.card-brand svg{width:54px;height:54px}.card-brand .brand-text span{color:#263651}.card-brand .brand-text strong{color:#192b49;font-size:26px}.card h2{font:800 clamp(26px,2.5vw,33px)/1.25 Montserrat,sans-serif;letter-spacing:-.045em;text-align:center;margin:0 0 10px;color:var(--navy)}.sub{text-align:center;color:var(--muted);font-size:14px;line-height:1.65;margin:0 0 32px}.field{margin-bottom:20px}.field label{display:block;font-size:13px;font-weight:700;margin-bottom:10px}.field input{width:100%;height:53px;border:1px solid #dce2ee;border-radius:10px;background:#fff;padding:0 16px;color:var(--ink)}.field input:focus{border-color:var(--purple);box-shadow:0 0 0 4px #7654d819;outline:none}.submit{width:100%;height:55px;border:0;border-radius:10px;background:#7251d3;color:#fff;font-weight:800;cursor:pointer}.submit:hover{background:#5d3dbf}.error,.success{padding:14px 15px;border-radius:10px;font-size:13px;line-height:1.55;margin-bottom:22px}.error{background:#fff0f0;border:1px solid #f3caca;color:#a02d35}.success{background:#f1fbf6;border:1px solid #cbe9d8;color:#286344}.success strong{display:block;margin-bottom:4px;color:#1f5539}.return{display:block;text-align:center;margin-top:23px;color:#6849c8;font-size:13px;font-weight:700;text-decoration:underline;text-underline-offset:3px}.mail-icon{width:64px;height:64px;border-radius:50%;display:grid;place-items:center;margin:0 auto 22px;background:#f0ecff;color:#6849c8}.mail-icon svg{width:29px;height:29px}.copyright{text-align:center;color:#8891a5;font-size:11px;margin:21px 0 0}@media(max-width:1000px){.page{grid-template-columns:1fr}.visual{min-height:330px;padding:28px}.visual-content{padding:40px 0 15px}.visual h1{font-size:38px}.visual-foot{display:none}.access{padding:38px 22px 60px}}@media(max-width:520px){.visual{min-height:290px;padding:22px}.visual h1{font-size:31px}.access{padding:24px 14px 40px}.card{padding:30px 22px;border-radius:17px}}
</style>
</head>
<body><main class="page">
<section class="visual" aria-label="Instituto Atlas"><div class="visual-top"><a class="brand" href="../index.html"><svg viewBox="0 0 64 64" aria-hidden="true"><path fill="#fff" d="M26 5h12L61 59H46L32 25 17 59H3z"/><path fill="#7654d8" d="M7 58C19 41 31 31 52 24c-15 11-23 21-30 34z"/><path fill="#fff" d="M6 55c15-16 29-24 48-29-17 8-30 18-40 29z"/><path fill="#b79aff" d="m54 8 2.4 5.6L62 16l-5.6 2.4L54 24l-2.4-5.6L46 16l5.6-2.4z"/></svg><span class="brand-text"><span>INSTITUTO</span><strong>ATLAS</strong></span></a><a class="back" href="login.php">← Voltar ao login</a></div><div class="visual-content"><span class="eyebrow">Portal escolar</span><h1>Recupere seu<br><em>acesso.</em></h1><p>Informe o e-mail vinculado à sua conta para receber as instruções de redefinição de senha.</p></div><div class="visual-foot">Instituto Atlas · Ensino Médio<br>Conhecimento que abre novos caminhos.</div></section>
<section class="access"><div><div class="card"><div class="card-brand"><svg viewBox="0 0 64 64" aria-hidden="true"><path fill="#192b49" d="M26 5h12L61 59H46L32 25 17 59H3z"/><path fill="#7654d8" d="M7 58C19 41 31 31 52 24c-15 11-23 21-30 34z"/><path fill="#fff" d="M6 55c15-16 29-24 48-29-17 8-30 18-40 29z"/><path fill="#7654d8" d="m54 8 2.4 5.6L62 16l-5.6 2.4L54 24l-2.4-5.6L46 16l5.6-2.4z"/></svg><span class="brand-text"><span>INSTITUTO</span><strong>ATLAS</strong></span></div>
<?php if ($enviado): ?>
<div class="mail-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v16H4z"/><path d="m4 6 8 6 8-6"/></svg></div><h2>Confira seu e-mail</h2><p class="sub">Enviamos as instruções para redefinir sua senha.</p><div class="success" role="status"><strong>E-mail enviado!</strong>Enviamos as instruções de recuperação para <b><?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></b>.</div><a class="return" href="login.php">← Voltar para o login</a>
<?php else: ?>
<h2>Esqueceu sua senha?</h2><p class="sub">Sem problema. Digite o e-mail cadastrado no portal e enviaremos as instruções para você.</p><?php if ($erro !== ''): ?><div class="error" role="alert"><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?><form method="POST" action=""><div class="field"><label for="email">E-mail</label><input id="email" type="email" name="email" placeholder="seuemail@exemplo.com" autocomplete="email" required value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>"></div><button class="submit" type="submit">Enviar instruções →</button></form><a class="return" href="login.php">← Voltar para o login</a>
<?php endif; ?>
</div><p class="copyright">© <?php echo date('Y'); ?> Instituto Atlas · Projeto escolar fictício</p></div></section></main></body></html>
