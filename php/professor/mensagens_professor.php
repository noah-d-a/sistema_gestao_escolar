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
    <!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Professor | Visualizar mensagem — Instituto Atlas</title><style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');*{box-sizing:border-box}body{margin:0;background:#f7f8fc;color:#202338;font-family:Inter,Arial,sans-serif}.atlas-main{max-width:1320px;margin:0 auto;padding:36px 60px 76px}.eyebrow{font-size:11px;font-weight:800;letter-spacing:.15em;color:#777d93;text-transform:uppercase}.head{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;margin-bottom:30px}.head h1{font-size:38px;letter-spacing:-.055em;margin:13px 0 8px;font-weight:800}.head h1 span{color:#6664df}.sub{color:#777d93;font-size:14px;line-height:1.6;margin:0}.tag{border:1px solid #e7e9f1;background:#fff;border-radius:30px;padding:10px 15px;font-size:12px;color:#6664df;font-weight:700}.box{background:#fff;border:1px solid #e7e9f1;border-radius:17px;padding:28px 30px;margin-bottom:20px;box-shadow:0 7px 22px rgba(29,32,63,.025)}.box h2{font-size:17px;letter-spacing:-.03em;margin:0 0 20px}.muted{color:#777d93;font-size:13px}.filters{display:flex;gap:16px;align-items:end;flex-wrap:wrap}.field{flex:1;min-width:180px}.field label,.form-label{display:block;color:#777d93;font-size:12px;font-weight:700;margin-bottom:9px}select,input,textarea{font:inherit;font-size:13px;border:1px solid #e1e4ef;background:#fafbfe;color:#292d45;border-radius:10px;padding:12px 13px;width:100%;outline:none}select:focus,input:focus,textarea:focus{border-color:#6664df;box-shadow:0 0 0 3px #6664df18}.readonly{display:flex;align-items:center;min-height:43px;padding:10px 13px;background:#fafbfe;border:1px solid #e7e9f1;border-radius:10px;font-size:13px;font-weight:700}.btn{border:0;border-radius:10px;background:#6664df;color:white;padding:13px 20px;font:inherit;font-size:12px;font-weight:800;cursor:pointer;white-space:nowrap}.btn:hover{background:#5552c9}.table-wrap{overflow-x:auto}table{width:100%;border-collapse:collapse;font-size:13px}th{text-align:left;font-size:10px;letter-spacing:.08em;text-transform:uppercase;color:#858aa0;background:#fafbfe;padding:15px 13px;white-space:nowrap}td{padding:15px 13px;border-bottom:1px solid #eef0f6;color:#353950}tbody tr:last-child td{border-bottom:0}.badge{display:inline-block;padding:7px 11px;border-radius:100px;font-size:11px;font-weight:800}.verde{background:#e8f8ef;color:#207a4a}.amarelo{background:#fff4df;color:#946000}.vermelho{background:#ffe9ec;color:#b3334c}.empty{padding:24px;border:1px dashed #dfe2ef;border-radius:12px;color:#777d93;font-size:13px;text-align:center}.section-head{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:20px}.section-head h2{margin:0}.hint{font-size:12px;color:#858aa0}@media(max-width:1100px){.atlas-main{padding:32px 30px 65px}}@media(max-width:700px){.atlas-main{padding:28px 18px 50px}.head h1{font-size:31px}.tag{display:none}.box{padding:22px 18px}.filters{display:block}.field{margin-bottom:14px}.btn{width:100%}} .message-body{font-size:14px;line-height:1.8;white-space:normal;overflow-wrap:anywhere}.meta{font-size:12px;color:#858aa0;margin:0 0 10px}.back{color:#6664df;text-decoration:none;font-weight:800;font-size:12px}</style></head><body><?php include '../../includes/menu_professor.php';?><main class="atlas-main"><header class="head"><div><div class="eyebrow">Instituto Atlas &nbsp;/&nbsp; Portal do professor</div><h1>Mensagem<span>.</span></h1><p class="sub">Leia a mensagem recebida.</p></div><a class="back" href="mensagens_professor.php">← Voltar à caixa de entrada</a></header><section class="box"><p class="meta">De: <?php echo htmlspecialchars($msg['remetente_nome']);?> · <?php echo (new DateTime($msg['data_envio']))->format('d/m/Y H:i');?></p><h2 style="font-size:23px;margin:12px 0 25px"><?php echo htmlspecialchars($msg['assunto']??'Sem assunto');?></h2><div class="message-body"><?php echo nl2br(htmlspecialchars($msg['conteudo']));?></div></section></main></body></html>
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

<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Professor | Mensagens — Instituto Atlas</title><style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');*{box-sizing:border-box}body{margin:0;background:#f7f8fc;color:#202338;font-family:Inter,Arial,sans-serif}.atlas-main{max-width:1320px;margin:0 auto;padding:36px 60px 76px}.eyebrow{font-size:11px;font-weight:800;letter-spacing:.15em;color:#777d93;text-transform:uppercase}.head{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;margin-bottom:30px}.head h1{font-size:38px;letter-spacing:-.055em;margin:13px 0 8px;font-weight:800}.head h1 span{color:#6664df}.sub{color:#777d93;font-size:14px;line-height:1.6;margin:0}.tag{border:1px solid #e7e9f1;background:#fff;border-radius:30px;padding:10px 15px;font-size:12px;color:#6664df;font-weight:700}.box{background:#fff;border:1px solid #e7e9f1;border-radius:17px;padding:28px 30px;margin-bottom:20px;box-shadow:0 7px 22px rgba(29,32,63,.025)}.box h2{font-size:17px;letter-spacing:-.03em;margin:0 0 20px}.muted{color:#777d93;font-size:13px}.filters{display:flex;gap:16px;align-items:end;flex-wrap:wrap}.field{flex:1;min-width:180px}.field label,.form-label{display:block;color:#777d93;font-size:12px;font-weight:700;margin-bottom:9px}select,input,textarea{font:inherit;font-size:13px;border:1px solid #e1e4ef;background:#fafbfe;color:#292d45;border-radius:10px;padding:12px 13px;width:100%;outline:none}select:focus,input:focus,textarea:focus{border-color:#6664df;box-shadow:0 0 0 3px #6664df18}.readonly{display:flex;align-items:center;min-height:43px;padding:10px 13px;background:#fafbfe;border:1px solid #e7e9f1;border-radius:10px;font-size:13px;font-weight:700}.btn{border:0;border-radius:10px;background:#6664df;color:white;padding:13px 20px;font:inherit;font-size:12px;font-weight:800;cursor:pointer;white-space:nowrap}.btn:hover{background:#5552c9}.table-wrap{overflow-x:auto}table{width:100%;border-collapse:collapse;font-size:13px}th{text-align:left;font-size:10px;letter-spacing:.08em;text-transform:uppercase;color:#858aa0;background:#fafbfe;padding:15px 13px;white-space:nowrap}td{padding:15px 13px;border-bottom:1px solid #eef0f6;color:#353950}tbody tr:last-child td{border-bottom:0}.badge{display:inline-block;padding:7px 11px;border-radius:100px;font-size:11px;font-weight:800}.verde{background:#e8f8ef;color:#207a4a}.amarelo{background:#fff4df;color:#946000}.vermelho{background:#ffe9ec;color:#b3334c}.empty{padding:24px;border:1px dashed #dfe2ef;border-radius:12px;color:#777d93;font-size:13px;text-align:center}.section-head{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:20px}.section-head h2{margin:0}.hint{font-size:12px;color:#858aa0}@media(max-width:1100px){.atlas-main{padding:32px 30px 65px}}@media(max-width:700px){.atlas-main{padding:28px 18px 50px}.head h1{font-size:31px}.tag{display:none}.box{padding:22px 18px}.filters{display:block}.field{margin-bottom:14px}.btn{width:100%}}.subject{color:#5552c9;font-weight:700;text-decoration:none}.subject:hover{text-decoration:underline}textarea{resize:vertical;line-height:1.6}</style></head><body><?php include '../../includes/menu_professor.php'; ?><main class="atlas-main"><header class="head"><div><div class="eyebrow">Instituto Atlas &nbsp;/&nbsp; Portal do professor</div><h1>Mensagens<span>.</span></h1><p class="sub">Envie mensagens e acompanhe sua caixa de entrada.</p></div><span class="tag">Área do professor</span></header><section class="box"><div class="section-head"><h2>Nova mensagem</h2><span class="hint">Comunicação institucional</span></div><?php echo $mensagem;?><form method="POST"><div class="field"><label for="destinatario">Destinatário</label><select id="destinatario" name="destinatario" required><option value="">Selecione...</option><?php foreach($destinatarios as $dest):?><option value="<?php echo (int)$dest['id_usuario'];?>"><?php echo htmlspecialchars($dest['nome'].' — '.$dest['perfil']);?></option><?php endforeach;?></select></div><div class="field" style="margin-top:18px"><label for="assunto">Assunto</label><input id="assunto" type="text" name="assunto" placeholder="Digite o assunto" required></div><div class="field" style="margin-top:18px"><label for="conteudo">Mensagem</label><textarea id="conteudo" name="conteudo" rows="5" placeholder="Escreva sua mensagem..." required></textarea></div><div style="display:flex;justify-content:flex-end;margin-top:20px"><button class="btn" type="submit" name="enviar_msg" value="1">Enviar mensagem</button></div></form></section><section class="box"><div class="section-head"><h2>Caixa de entrada</h2><span class="hint"><?php echo count($mensagens_recebidas);?> mensagens recebidas</span></div><?php if(count($mensagens_recebidas)>0):?><div class="table-wrap"><table><thead><tr><th>Remetente</th><th>Assunto</th><th>Data</th><th>Situação</th></tr></thead><tbody><?php foreach($mensagens_recebidas as $msg):?><tr><td><strong><?php echo htmlspecialchars($msg['remetente_nome']);?></strong></td><td><a class="subject" href="?visualizar=1&amp;id_msg=<?php echo (int)$msg['id_mensagem'];?>"><?php echo htmlspecialchars($msg['assunto']??'Sem assunto');?></a></td><td><?php echo (new DateTime($msg['data_envio']))->format('d/m/Y');?></td><td><span class="badge <?php echo $msg['lida']?'verde':'amarelo';?>"><?php echo $msg['lida']?'Lida':'Não lida';?></span></td></tr><?php endforeach;?></tbody></table></div><?php else:?><div class="empty">Nenhuma mensagem na caixa de entrada.</div><?php endif;?></section></main></body></html>