<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';
verificar_perfil('Professor');
$id = $_SESSION['id_usuario'];
$stmt = $conexao->prepare('SELECT * FROM usuario WHERE id_usuario=? AND perfil="Professor" AND ativo=1');
$stmt->bind_param('i', $id); $stmt->execute(); $professor = $stmt->get_result()->fetch_assoc(); $stmt->close();
if (!$professor) { header('Location: inicio_professor.php'); exit(); }
function mostrar($campo, $valor) { echo '<div class="campo"><label>' . htmlspecialchars($campo) . '</label><input value="' . htmlspecialchars((string)($valor ?? '')) . '" disabled></div>'; }
?>
<!DOCTYPE html>
<html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Professor | Cadastro</title><style>
*{box-sizing:border-box}body{margin:0;font-family:Arial,sans-serif;background:#f3f7fb;color:#1f2937}main{max-width:980px;margin:32px auto;padding:0 20px 40px}.topo{background:linear-gradient(135deg,#1f3b65,#4568a8);color:#fff;border-radius:18px;padding:26px 28px;margin-bottom:24px}.topo h1{margin:0;font-size:2rem}.box{background:#fff;border:1px solid #e3ebf7;border-radius:18px;padding:28px;box-shadow:0 10px 25px rgba(15,23,42,.05)}.formulario{display:grid;grid-template-columns:repeat(2,minmax(220px,1fr));gap:18px 22px}.campo{display:flex;flex-direction:column;gap:7px}.campo.full{grid-column:1/-1}label{font-weight:bold;color:#2c4564}input{padding:11px 12px;border-radius:10px;border:1px solid #dfe8f4;background:#f1f4f8;font-size:.95rem}
</style></head><body><?php include '../../includes/menu_professor.php';?><main><section class="topo"><h1>Meu cadastro</h1></section><section class="box"><div style="background:#edf5ff;color:#17477c;padding:10px;border-radius:5px;margin-bottom:18px;">Este cadastro é somente para consulta.</div><div class="formulario"><?php mostrar('Perfil',$professor['perfil']);mostrar('Nome completo',$professor['nome']);mostrar('CPF',$professor['cpf']);mostrar('RG',$professor['rg']);mostrar('Data de nascimento',$professor['data_nascimento']);mostrar('Telefone',$professor['telefone']);mostrar('E-mail',$professor['email']);mostrar('Endereço',$professor['endereco']);?></div></section></main></body></html>
