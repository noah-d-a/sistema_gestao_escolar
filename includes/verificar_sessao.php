<?php
// Verificar se o usuário está autenticado
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['perfil'])) {
    header('Location: ../login.php');
    exit();
}

function atlas_acesso_negado() {
    header('HTTP/1.1 403 Forbidden');
    $nome = htmlspecialchars($_SESSION['nome'] ?? 'Usuário', ENT_QUOTES, 'UTF-8');
    echo '<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Acesso negado | Instituto Atlas</title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"><style>*{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;padding:24px;background:#f7f8fc;color:#202338;font-family:Inter,Arial,sans-serif}.card{width:min(520px,100%);background:#fff;border:1px solid #e7e9f1;border-radius:20px;padding:34px;box-shadow:0 18px 55px rgba(24,28,50,.08)}.eyebrow{color:#6664df;font-size:11px;font-weight:800;letter-spacing:.14em;margin-bottom:16px}.icon{width:52px;height:52px;display:grid;place-items:center;border-radius:15px;background:#f1f0ff;color:#6664df;font-size:24px;margin-bottom:20px}h1{font-size:28px;letter-spacing:-.04em;margin:0 0 10px}p{color:#72788d;line-height:1.65;margin:0 0 24px}.actions{display:flex;gap:10px;flex-wrap:wrap}.btn{display:inline-flex;align-items:center;justify-content:center;min-height:43px;padding:0 17px;border-radius:10px;text-decoration:none;font-size:13px;font-weight:700}.primary{background:#6664df;color:#fff}.secondary{background:#fff;color:#50566c;border:1px solid #dfe2eb}@media(max-width:520px){.card{padding:25px}.actions{flex-direction:column}.btn{width:100%}}</style></head><body><main class="card"><div class="eyebrow">INSTITUTO ATLAS / PORTAL ACADÊMICO</div><div class="icon" aria-hidden="true">&#128274;</div><h1>Acesso não permitido</h1><p>'.$nome.', seu perfil não possui permissão para acessar esta área do portal.</p><div class="actions"><a class="btn primary" href="javascript:history.back()">Voltar à página anterior</a><a class="btn secondary" href="../login.php">Ir para o login</a></div></main></body></html>';
    exit();
}

function verificar_perfil($perfil_requerido) {
    if ($_SESSION['perfil'] !== $perfil_requerido) {
        atlas_acesso_negado();
    }
}

function verificar_perfis($perfis_requeridos) {
    if (!in_array($_SESSION['perfil'], $perfis_requeridos, true)) {
        atlas_acesso_negado();
    }
}

function logout() {
    session_destroy();
    header('Location: ../login.php');
    exit();
}
?>
