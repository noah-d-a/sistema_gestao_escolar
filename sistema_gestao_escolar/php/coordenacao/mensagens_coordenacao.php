<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Coordenação');

$id_coordenador = $_SESSION['id_usuario'];
$mensagem = '';

// Se visualizar uma mensagem
if (isset($_GET['visualizar']) && isset($_GET['id_msg'])) {
    $id_msg = intval($_GET['id_msg']);
    
    // Marcar como lida
    $sql = "UPDATE mensagem SET lida = 1 WHERE id_mensagem = ? AND destinatario = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ii", $id_msg, $id_coordenador);
    $stmt->execute();
    $stmt->close();
    
    // Buscar mensagem
    $sql = "SELECT m.*, u.nome as remetente_nome 
            FROM mensagem m
            JOIN usuario u ON m.remetente = u.id_usuario
            WHERE m.id_mensagem = ? AND m.destinatario = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ii", $id_msg, $id_coordenador);
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Visualizar Mensagem</title>
        <style>*{box-sizing:border-box}body{margin:0;background:#f7f8fd;color:#20283e;font-family:Inter,Arial,sans-serif}main{max-width:1230px;margin:0 auto;padding:34px 32px 65px}.topo,.header{background:#fff;color:#20283e;border:1px solid #e2e5f1;border-radius:18px;padding:28px 30px;margin-bottom:22px}.topo:before,.header:before{content:"COORDENAÇÃO · PORTAL ACADÊMICO";display:block;color:#6353c7;letter-spacing:1.4px;font-size:11px;font-weight:800;margin-bottom:10px}.topo h1,.header h1{font-size:28px;letter-spacing:-.8px;margin:0}.box,.panel{background:#fff;border:1px solid #e2e5f1;border-radius:18px;padding:26px;margin-bottom:20px;box-shadow:0 5px 20px rgba(20,25,65,.025)}.panel h2{font-size:19px;margin:0 0 18px;color:#20283e}.formulario{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:17px}.campo{display:flex;flex-direction:column;gap:7px;min-width:0}.campo.full{grid-column:1/-1}label,.msg-label{display:block;font-weight:650;color:#404960;font-size:13px;margin:0 0 7px}input,select,textarea,.msg-input,.msg-select,.msg-textarea{width:100%;min-width:0;background:#fff;border:1px solid #dce0ed;border-radius:10px;padding:12px 13px;font:inherit;font-size:14px;color:#25304a;outline:none}input:focus,select:focus,textarea:focus{border-color:#6554ce;box-shadow:0 0 0 3px #6554ce18}input:disabled,select:disabled{background:#f7f8fc;color:#505b73;opacity:1}.msg-label{margin-top:17px}.msg-textarea{min-height:120px;resize:vertical}.btn-enviar,.principal{background:#6150c9;color:white;border:0;border-radius:10px;padding:12px 20px;font:inherit;font-size:14px;font-weight:700;cursor:pointer;margin-top:18px}.btn-enviar:hover,.principal:hover{background:#5140b6}.secundario{background:#f0edff;color:#5746bf;border:0;border-radius:10px;padding:12px 18px}.panel table{width:100%;border-collapse:collapse;font-size:14px}.panel th{text-align:left;font-size:11px;letter-spacing:.6px;text-transform:uppercase;color:#66718a;background:#f8f9fd;padding:14px 12px}.panel td{border-bottom:1px solid #eceef5;padding:15px 12px}.panel tr:last-child td{border-bottom:0}.assunto,a{color:#5947c4}.assunto{font-weight:650;text-decoration:none}.assunto:hover,a:hover{text-decoration:underline}.badge{display:inline-flex;padding:5px 10px;border-radius:8px;font-size:12px;font-weight:700}.verde{background:#eaf7f0;color:#24764c}.vermelho{background:#fff0e7;color:#ad5b21}.msg-header{border-bottom:1px solid #e9ebf3;padding-bottom:16px;margin-bottom:20px}.msg-header p{color:#566078;margin:8px 0;font-size:14px}.msg-content{line-height:1.8;white-space:normal;overflow-wrap:anywhere}.panel form{max-width:760px}.panel:has(table){overflow-x:auto}@media(max-width:760px){main{padding:22px 15px 40px}.topo,.header,.box,.panel{padding:21px}.topo h1,.header h1{font-size:24px}.formulario{grid-template-columns:1fr}.panel table{min-width:580px}}</style>
    </head>
    <body>
        <?php include '../../includes/menu_coordenacao.php'; ?>
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
                    <a href="mensagens_coordenacao.php">&lt; Voltar</a>
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
        $stmt->bind_param("iiss", $id_coordenador, $destinatario, $assunto, $conteudo);
        
        if ($stmt->execute()) {
            $mensagem = '<div style="background: #efe; color: #363; padding: 10px; border-radius: 5px; margin-bottom: 15px;">Mensagem enviada com sucesso!</div>';
        }
        $stmt->close();
    } else {
        $mensagem = '<div style="background: #fee; color: #c33; padding: 10px; border-radius: 5px; margin-bottom: 15px;">Preencha todos os campos.</div>';
    }
}

// Buscar destinatários possíveis (Secretaria e Professores)
$destinatarios = [];
$sql = "SELECT id_usuario, nome, perfil FROM usuario WHERE perfil IN ('Secretaria', 'Professor') AND ativo = 1";
$stmt = $conexao->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $destinatarios[] = $row;
}
$stmt->close();

// Buscar mensagens recebidas
$sql = "SELECT m.*, u.nome as remetente_nome
        FROM mensagem m
        JOIN usuario u ON m.remetente = u.id_usuario
        WHERE m.destinatario = ?
        ORDER BY m.data_envio DESC";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_coordenador);
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordenação | Mensagens</title>
    <style>*{box-sizing:border-box}body{margin:0;background:#f7f8fd;color:#20283e;font-family:Inter,Arial,sans-serif}main{max-width:1230px;margin:0 auto;padding:34px 32px 65px}.topo,.header{background:#fff;color:#20283e;border:1px solid #e2e5f1;border-radius:18px;padding:28px 30px;margin-bottom:22px}.topo:before,.header:before{content:"COORDENAÇÃO · PORTAL ACADÊMICO";display:block;color:#6353c7;letter-spacing:1.4px;font-size:11px;font-weight:800;margin-bottom:10px}.topo h1,.header h1{font-size:28px;letter-spacing:-.8px;margin:0}.box,.panel{background:#fff;border:1px solid #e2e5f1;border-radius:18px;padding:26px;margin-bottom:20px;box-shadow:0 5px 20px rgba(20,25,65,.025)}.panel h2{font-size:19px;margin:0 0 18px;color:#20283e}.formulario{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:17px}.campo{display:flex;flex-direction:column;gap:7px;min-width:0}.campo.full{grid-column:1/-1}label,.msg-label{display:block;font-weight:650;color:#404960;font-size:13px;margin:0 0 7px}input,select,textarea,.msg-input,.msg-select,.msg-textarea{width:100%;min-width:0;background:#fff;border:1px solid #dce0ed;border-radius:10px;padding:12px 13px;font:inherit;font-size:14px;color:#25304a;outline:none}input:focus,select:focus,textarea:focus{border-color:#6554ce;box-shadow:0 0 0 3px #6554ce18}input:disabled,select:disabled{background:#f7f8fc;color:#505b73;opacity:1}.msg-label{margin-top:17px}.msg-textarea{min-height:120px;resize:vertical}.btn-enviar,.principal{background:#6150c9;color:white;border:0;border-radius:10px;padding:12px 20px;font:inherit;font-size:14px;font-weight:700;cursor:pointer;margin-top:18px}.btn-enviar:hover,.principal:hover{background:#5140b6}.secundario{background:#f0edff;color:#5746bf;border:0;border-radius:10px;padding:12px 18px}.panel table{width:100%;border-collapse:collapse;font-size:14px}.panel th{text-align:left;font-size:11px;letter-spacing:.6px;text-transform:uppercase;color:#66718a;background:#f8f9fd;padding:14px 12px}.panel td{border-bottom:1px solid #eceef5;padding:15px 12px}.panel tr:last-child td{border-bottom:0}.assunto,a{color:#5947c4}.assunto{font-weight:650;text-decoration:none}.assunto:hover,a:hover{text-decoration:underline}.badge{display:inline-flex;padding:5px 10px;border-radius:8px;font-size:12px;font-weight:700}.verde{background:#eaf7f0;color:#24764c}.vermelho{background:#fff0e7;color:#ad5b21}.msg-header{border-bottom:1px solid #e9ebf3;padding-bottom:16px;margin-bottom:20px}.msg-header p{color:#566078;margin:8px 0;font-size:14px}.msg-content{line-height:1.8;white-space:normal;overflow-wrap:anywhere}.panel form{max-width:760px}.panel:has(table){overflow-x:auto}@media(max-width:760px){main{padding:22px 15px 40px}.topo,.header,.box,.panel{padding:21px}.topo h1,.header h1{font-size:24px}.formulario{grid-template-columns:1fr}.panel table{min-width:580px}}</style>
</head>
<body>
    <?php include "../../includes/menu_coordenacao.php"; ?>

    <main>
        <section class="header">
            <h1>Mensagens</h1>
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
                                <td style="<?php echo $msg['lida'] ? '' : 'font-weight: bold;'; ?>"><?php echo htmlspecialchars($msg['remetente_nome']); ?></td>
                                <td><a class="assunto" href="?visualizar=1&id_msg=<?php echo $msg['id_mensagem']; ?>"><?php echo htmlspecialchars($msg['assunto'] ?? 'Sem assunto'); ?></a></td>
                                <td><?php echo (new DateTime($msg['data_envio']))->format('d/m/Y'); ?></td>
                                <td><span class="badge <?php echo $msg['lida'] ? 'verde' : 'vermelho'; ?>"><?php echo $msg['lida'] ? 'Lida' : 'Não lida'; ?></span></td>
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
