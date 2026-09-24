<?php
// Encerrar a sessão somente por solicitação explícita do usuário.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    exit('Método não permitido.');
}

session_start();
$_SESSION = [];

// Apagar também o cookie de sessão, para não reutilizar o identificador.
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', [
        'expires' => time() - 42000,
        'path' => $params['path'],
        'domain' => $params['domain'],
        'secure' => $params['secure'],
        'httponly' => $params['httponly'],
        'samesite' => $params['samesite'] ?? 'Lax',
    ]);
}
session_destroy();
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Location: ../php/login.php', true, 303);
exit;
