<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';
verificar_perfil('Secretaria');
$mensagem='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $titulo=trim($_POST['titulo']??''); $descricao=trim($_POST['descricao']??''); $enunciados=$_POST['enunciado']??[]; $alternativas=$_POST['alternativas']??[];
    $tem_pergunta = false;
    foreach ($enunciados as $enunciado) { if (trim($enunciado) !== '') { $tem_pergunta = true; break; } }
    if ($titulo==='' || !$tem_pergunta) { $mensagem='<div style="background:#fee;color:#9d1c1c;padding:10px;border-radius:8px;margin-bottom:15px;">Informe o título e pelo menos uma pergunta.</div>'; }
    else {
        $conexao->begin_transaction(); $ok=true;
        $stmt=$conexao->prepare('INSERT INTO questionario (titulo,descricao,criado_por,data_criacao) VALUES (?,?,?,NOW())'); $criador=$_SESSION['id_usuario']; $stmt->bind_param('ssi',$titulo,$descricao,$criador); $ok=$stmt->execute(); $id_questionario=$conexao->insert_id; $stmt->close();
        if($ok) { $stmt_pergunta=$conexao->prepare('INSERT INTO pergunta (id_questionario,enunciado) VALUES (?,?)'); $stmt_alternativa=$conexao->prepare('INSERT INTO alternativa (id_pergunta,texto) VALUES (?,?)'); foreach($enunciados as $indice=>$enunciado) { $enunciado=trim($enunciado); if($enunciado==='') continue; $stmt_pergunta->bind_param('is',$id_questionario,$enunciado); if(!$stmt_pergunta->execute()){ $ok=false; break; } $id_pergunta=$conexao->insert_id; foreach(($alternativas[$indice]??[]) as $texto) { $texto=trim($texto); if($texto==='') continue; $stmt_alternativa->bind_param('is',$id_pergunta,$texto); if(!$stmt_alternativa->execute()){ $ok=false; break 2; } } } $stmt_pergunta->close(); $stmt_alternativa->close(); }
        if($ok) { $conexao->commit(); $mensagem='<div style="background:#eaf7ee;color:#1d6f3b;padding:10px;border-radius:8px;margin-bottom:15px;">Questionário criado com sucesso.</div>'; } else { $conexao->rollback(); $mensagem='<div style="background:#fee;color:#9d1c1c;padding:10px;border-radius:8px;margin-bottom:15px;">Não foi possível criar o questionário.</div>'; }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Secretaria | Criar questionário</title>
<style>*{box-sizing:border-box}body{margin:0;font-family:Arial,sans-serif;background:#f3f6fb;color:#1f2937}main{max-width:980px;margin:32px auto;padding:0 20px 40px}.header{background:linear-gradient(135deg,#0d3d70,#1b8ac0);color:#fff;border-radius:18px;padding:26px 28px;margin-bottom:24px}.header h1{margin:0;font-size:2rem}.box{background:#fff;border:1px solid #e2eaf5;border-radius:18px;padding:24px;box-shadow:0 10px 22px rgba(15,23,42,.04)}.campo{display:flex;flex-direction:column;gap:7px;margin-bottom:15px}label{font-weight:bold;color:#25445d}input,textarea{width:100%;padding:10px 12px;border:1px solid #dfe8f4;border-radius:9px;background:#f9fbff}.pergunta{border:1px solid #e1eaf5;border-radius:12px;padding:16px;margin:16px 0}.resposta{display:flex;gap:8px;margin-top:8px}.resposta input{flex:1}.botoes{display:flex;gap:10px;margin-top:18px}button{border:0;border-radius:9px;padding:11px 16px;background:#0d4a8f;color:#fff;font-weight:bold;cursor:pointer}.secundario{background:#eaf3ff;color:#0b447d}</style></head><body><?php include '../../includes/menu_secretaria.php'; ?><main><section class="header"><h1>Criar questionário</h1></section><section class="box"><?php echo $mensagem; ?><form method="POST"><div class="campo"><label for="titulo">Título</label><input id="titulo" name="titulo" required></div><div class="campo"><label for="descricao">Descrição</label><textarea id="descricao" name="descricao" rows="3"></textarea></div><div id="perguntas"></div><div class="botoes"><button type="button" class="secundario" onclick="novaPergunta()">Nova pergunta</button><button type="submit">Criar questionário</button></div></form></section></main><script>
let perguntaAtual=0;
function novaPergunta(){const indice=perguntaAtual++;const bloco=document.createElement('div');bloco.className='pergunta';bloco.innerHTML='<div class="campo"><label>Pergunta</label><input name="enunciado['+indice+']" required></div><div class="respostas" data-indice="'+indice+'"><label>Respostas</label></div><button type="button" class="secundario" onclick="novaResposta('+indice+')">Nova resposta</button>';document.getElementById('perguntas').appendChild(bloco);novaResposta(indice)}
function novaResposta(indice){const container=document.querySelector('.respostas[data-indice="'+indice+'"]');const campo=document.createElement('div');campo.className='resposta';campo.innerHTML='<input name="alternativas['+indice+'][]" placeholder="Resposta">';container.appendChild(campo)}
novaPergunta();
</script></body></html>
