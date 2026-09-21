<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Professor');

$id_professor = $_SESSION['id_usuario'];
$mensagem = '';

// Se visualizar uma mensagem
if (isset($_GET['visualizar']) && isset($_GET['id_msg'])) {
    $id_msg = intval($_GET['id_msg']);
    
    // Marcar como lida
    $sql = "UPDATE mensagem SET lida = 1 WHERE id_mensagem = ? AND destinatario = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ii", $id_msg, $id_professor);
    $stmt->execute();
    $stmt->close();
    
    // Buscar mensagem
    $sql = "SELECT m.*, u.nome as remetente_nome 
            FROM mensagem m
            JOIN usuario u ON m.remetente = u.id_usuario
            WHERE m.id_mensagem = ? AND m.destinatario = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ii", $id_msg, $id_professor);
    $stmt->execute();
    $result = $stmt->get_result();
    $msg = $result->fetch_assoc();
    $stmt->close();
    
    if ($msg):
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Visualizar Mensagem</title>
        <style>
            * { box-sizing: border-box; }
            body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #1f2937; }
            main { max-width: 1180px; margin: 32px auto; padding: 0 20px 40px; }
            .panel { background: #fff; border-radius: 18px; padding: 22px; border: 1px solid #e5ebf6; box-shadow: 0 10px 22px rgba(15,23,42,0.04); }
            .msg-header { border-bottom: 1px solid #edf2f9; padding-bottom: 12px; margin-bottom: 16px; }
            .msg-header p { margin: 4px 0; font-size: 0.875rem; color: #666; }
            .msg-content { line-height: 1.6; }
            a { color: #4568a8; text-decoration: none; }
            a:hover { text-decoration: underline; }
        </style>
    </head>
    <body>
        <?php include '../../includes/menu_professor.php'; ?>
        <main>
            <div class="panel">
                <div class="msg-header">
                    <p><strong>De:</strong> <?php echo htmlspecialchars($msg['remetente_nome']); ?></p>
                    <p><strong>Assunto:</strong> <?php echo htmlspecialchars($msg['assunto'] ?? 'Sem assunto'); ?></p>
                    <p><strong>Data:</strong> <?php echo (new DateTime($msg['data_envio']))->format('d/m/Y H:i'); ?></p>
                </div>
                <div class="msg-content">
                    <?php echo nl2br(htmlspecialchars($msg['conteudo'])); ?>
                </div>
                <p style="margin-top: 20px;">
                    <a href="mensagens_professor.php">&lt; Voltar</a>
                </p>
            </div>
        </main>
    </body>
    </html>
    <?php
    endif;
    exit();
}

// Se enviar mensagem
if (isset($_POST['enviar_msg'])) {
    $destinatario = intval($_POST['destinatario'] ?? 0);
    $assunto = trim($_POST['assunto'] ?? '');
    $conteudo = trim($_POST['conteudo'] ?? '');
    
    if ($destinatario > 0 && !empty($assunto) && !empty($conteudo)) {
        $sql = "INSERT INTO mensagem (remetente, destinatario, assunto, conteudo, data_envio, lida) VALUES (?, ?, ?, ?, NOW(), 0)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("iiss", $id_professor, $destinatario, $assunto, $conteudo);
        
        if ($stmt->execute()) {
            $mensagem = '<div style="background: #efe; color: #363; padding: 10px; border-radius: 5px; margin-bottom: 15px;">Mensagem enviada com sucesso!</div>';
        }
        $stmt->close();
    } else {
        $mensagem = '<div style="background: #fee; color: #c33; padding: 10px; border-radius: 5px; margin-bottom: 15px;">Preencha todos os campos.</div>';
    }
}

// Buscar destinatários possíveis
$destinatarios = [];

// Coordenação e Secretaria
$sql = "SELECT id_usuario, nome, perfil FROM usuario WHERE perfil IN ('Coordenação', 'Secretaria') AND ativo = 1";
$stmt = $conexao->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $destinatarios[] = $row;
}
$stmt->close();

// Turmas que o professor leciona
$sql = "SELECT DISTINCT t.id_turma, t.nome FROM turma t
        JOIN turma_disciplina td ON t.id_turma = td.id_turma
        WHERE td.id_professor = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$result = $stmt->get_result();
$turmas = [];
while ($row = $result->fetch_assoc()) {
    $turmas[] = $row;
}
$stmt->close();

// Buscar mensagens recebidas
$sql = "SELECT m.*, u.nome as remetente_nome
        FROM mensagem m
        JOIN usuario u ON m.remetente = u.id_usuario
        WHERE m.destinatario = ?
        ORDER BY m.data_envio DESC";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$result = $stmt->get_result();
$mensagens_recebidas = [];
while ($row = $result->fetch_assoc()) {
    $mensagens_recebidas[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor | Mensagens</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #1f2937; }
        main { max-width: 1180px; margin: 32px auto; padding: 0 20px 40px; }
        .topo { background: linear-gradient(135deg, #1f3b65, #4568a8); color: white; border-radius: 18px; padding: 30px 28px; margin-bottom: 26px; }
        .topo h1 { margin: 0 0 4px; font-size: 2rem; }
        .topo p { margin: 0; font-size: 0.9rem; opacity: 0.8; }
        .panel { background: #fff; border-radius: 18px; padding: 22px; border: 1px solid #e5ebf6; box-shadow: 0 10px 22px rgba(15,23,42,0.04); margin-bottom: 22px; }
        .panel h2 { margin-top: 0; color: #133b6d; }
        .msg-label { font-size: 0.78rem; font-weight: bold; color: #555; display: block; margin-bottom: 4px; margin-top: 12px; }
        .msg-input, .msg-select, .msg-textarea { width: 100%; border: 1px solid #dfe9f6; border-radius: 8px; padding: 9px 12px; font-size: 0.84rem; font-family: Arial, sans-serif; outline: none; }
        .msg-textarea { height: 90px; resize: vertical; }
        .btn-enviar { background: #183f73; color: #fff; border: none; border-radius: 8px; padding: 10px 22px; font-size: 0.875rem; font-weight: bold; cursor: pointer; margin-top: 14px; }
        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        thead th { text-align: left; padding: 10px 12px; font-size: 0.75rem; color: #6b7280; border-bottom: 1px solid #edf2f9; text-transform: uppercase; }
        tbody td { padding: 12px; border-bottom: 1px solid #edf2f9; color: #374151; }
        tbody tr:last-child td { border-bottom: none; }
        .assunto { color: #374151; text-decoration: none; }
        .assunto:hover { text-decoration: underline; }
        .badge { padding: 4px 10px; border-radius: 999px; font-size: 0.75rem; font-weight: bold; }
        .verde { background: #eaf7ef; color: #157c3d; }
        .vermelho { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <?php include '../../includes/menu_professor.php'; ?>
    <main>
        <section class="topo">
            <h1>Mensagens</h1>
            <p>Envie e receba mensagens</p>
        </section>
        
        <div class="panel">
            <?php echo $mensagem; ?>
            <h2>Nova Mensagem</h2>
            <form method="POST">
                <label class="msg-label">Destinatário</label>
                <select name="destinatario" class="msg-select">
                    <option value="">Selecione...</option>
                    <?php foreach ($destinatarios as $dest): ?>
                        <option value="<?php echo $dest['id_usuario']; ?>">
                            <?php echo htmlspecialchars($dest['nome'] . ' — ' . $dest['perfil']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label class="msg-label">Assunto</label>
                <input type="text" name="assunto" class="msg-input" placeholder="Digite o assunto"/>
                <label class="msg-label">Mensagem</label>
                <textarea name="conteudo" class="msg-textarea" placeholder="Digite sua mensagem..."></textarea>
                <button type="submit" name="enviar_msg" value="1" class="btn-enviar">Enviar mensagem</button>
            </form>
        </div>
        
        <div class="panel">
            <h2>Caixa de Entrada</h2>
            <?php if (count($mensagens_recebidas) > 0): ?>
                <table>
                    <thead><tr><th>Remetente</th><th>Assunto</th><th>Data</th><th>Situação</th></tr></thead>
                    <tbody>
                        <?php foreach ($mensagens_recebidas as $msg): ?>
                            <tr>
                                <td style="<?php echo $msg['lida'] ? '' : 'font-weight: bold;'; ?>">
                                    <?php echo htmlspecialchars($msg['remetente_nome']); ?>
                                </td>
                                <td>
                                    <a class="assunto" href="?visualizar=1&id_msg=<?php echo $msg['id_mensagem']; ?>">
                                        <?php echo htmlspecialchars($msg['assunto'] ?? 'Sem assunto'); ?>
                                    </a>
                                </td>
                                <td><?php echo (new DateTime($msg['data_envio']))->format('d/m/Y'); ?></td>
                                <td>
                                    <span class="badge <?php echo $msg['lida'] ? 'verde' : 'vermelho'; ?>">
                                        <?php echo $msg['lida'] ? 'Lida' : 'Não lida'; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="color: #666;">Nenhuma mensagem na caixa de entrada.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>