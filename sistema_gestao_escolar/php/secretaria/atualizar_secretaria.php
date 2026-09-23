<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';
verificar_perfil('Secretaria');

$tipos = ['aluno' => 'Aluno', 'professor' => 'Professor', 'coordenacao' => 'Coordenação', 'secretaria' => 'Secretaria', 'turma' => 'Turma', 'disciplina' => 'Disciplina'];
$tipo = strtolower(trim($_GET['tipo'] ?? $_POST['tipo'] ?? ''));
$acao = strtolower(trim($_GET['acao'] ?? $_POST['acao'] ?? 'atualizar'));
$id = intval($_GET['id'] ?? $_POST['id'] ?? 0);
$turma_origem = intval($_GET['turma'] ?? $_POST['turma_origem'] ?? 0);
if (!isset($tipos[$tipo]) || $id <= 0) { header('Location: cadastros_secretaria.php'); exit(); }
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sucesso = false;
    if ($tipo === 'turma') {
        $nome = trim($_POST['nome'] ?? ''); $ano = intval($_POST['ano_letivo'] ?? 0); $periodo = $_POST['periodo'] ?? '';
        if ($nome !== '' && $ano >= 2000 && in_array($periodo, ['Manhã', 'Tarde', 'Noite'], true)) {
            $stmt = $conexao->prepare('UPDATE turma SET nome=?, ano_letivo=?, periodo=? WHERE id_turma=?'); $stmt->bind_param('sisi', $nome, $ano, $periodo, $id); $sucesso = $stmt->execute(); $stmt->close();
        }
    } elseif ($tipo === 'disciplina') {
        $nome = trim($_POST['nome'] ?? ''); $carga = intval($_POST['carga_horaria'] ?? 0);
        if ($nome !== '' && $carga > 0) { $stmt = $conexao->prepare('UPDATE disciplina SET nome=?, carga_horaria=? WHERE id_disciplina=?'); $stmt->bind_param('sii', $nome, $carga, $id); $sucesso = $stmt->execute(); $stmt->close(); }
    } else {
        $nome = trim($_POST['nome'] ?? ''); $cpf = trim($_POST['cpf'] ?? ''); $rg = trim($_POST['rg'] ?? ''); $nascimento = trim($_POST['data_nascimento'] ?? ''); $email = trim($_POST['email'] ?? ''); $telefone = trim($_POST['telefone'] ?? ''); $endereco = trim($_POST['endereco'] ?? ''); $perfil = $tipos[$tipo];
        if ($nome !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $conexao->begin_transaction();
            $stmt = $conexao->prepare('UPDATE usuario SET nome=?, cpf=NULLIF(?, ""), rg=NULLIF(?, ""), data_nascimento=NULLIF(?, ""), email=?, telefone=?, endereco=? WHERE id_usuario=? AND perfil=?');
            $stmt->bind_param('sssssssis', $nome, $cpf, $rg, $nascimento, $email, $telefone, $endereco, $id, $perfil); $sucesso = $stmt->execute(); $stmt->close();
            if ($sucesso && $tipo === 'aluno') {
                $rm = trim($_POST['rm'] ?? ''); $id_turma = intval($_POST['id_turma'] ?? 0); $data_matricula = trim($_POST['data_matricula'] ?? '');
                if ($rm === '' || $id_turma <= 0 || $data_matricula === '') { $sucesso = false; }
                else { $stmt = $conexao->prepare('UPDATE matricula SET rm=?, id_turma=?, data_matricula=? WHERE id_aluno=?'); $stmt->bind_param('sisi', $rm, $id_turma, $data_matricula, $id); $sucesso = $stmt->execute(); $stmt->close(); }
            }
            if ($sucesso) { $conexao->commit(); } else { $conexao->rollback(); }
        }
    }
    $mensagem = $sucesso ? '<div class="sucesso">' . htmlspecialchars($tipos[$tipo]) . ' atualizado(a) com sucesso.</div>' : '<div class="erro">Não foi possível atualizar o registro. Verifique os dados informados.</div>';
}

if ($tipo === 'aluno') { $stmt = $conexao->prepare('SELECT u.*,m.rm,m.data_matricula,t.id_turma,t.nome AS turma_nome FROM usuario u JOIN matricula m ON m.id_aluno=u.id_usuario JOIN turma t ON t.id_turma=m.id_turma WHERE u.id_usuario=? AND u.perfil="Aluno"'); }
elseif (in_array($tipo, ['professor', 'coordenacao', 'secretaria'], true)) { $stmt = $conexao->prepare('SELECT * FROM usuario WHERE id_usuario=? AND perfil=?'); $perfil = $tipos[$tipo]; $stmt->bind_param('is', $id, $perfil); }
elseif ($tipo === 'turma') { $stmt = $conexao->prepare('SELECT * FROM turma WHERE id_turma=?'); }
else { $stmt = $conexao->prepare('SELECT * FROM disciplina WHERE id_disciplina=?'); }
if (in_array($tipo, ['aluno', 'turma', 'disciplina'], true)) { $stmt->bind_param('i', $id); }
$stmt->execute(); $registro = $stmt->get_result()->fetch_assoc(); $stmt->close();
if (!$registro) { header('Location: consultas_secretaria.php?tipo=' . urlencode($tipo) . '&acao=' . urlencode($acao)); exit(); }
$turmas = [];
if ($tipo === 'aluno') { $result = $conexao->query('SELECT id_turma,nome,ano_letivo,periodo FROM turma ORDER BY nome'); while ($row = $result->fetch_assoc()) { $turmas[] = $row; } }
$retorno = 'consultas_secretaria.php?tipo=' . urlencode($tipo) . '&acao=' . urlencode($acao) . ($turma_origem ? '&turma=' . $turma_origem : '');
?>
<!DOCTYPE html>
<html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Secretaria | Atualizar</title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"><style>
*{box-sizing:border-box}body{margin:0;background:#f7f8fc;color:#202338;font-family:Inter,Arial,sans-serif}main{max-width:1110px;margin:0 auto;padding:44px 36px 70px}h1,h2{letter-spacing:-.04em}a:focus-visible,button:focus-visible,input:focus-visible,select:focus-visible{outline:3px solid #b6b4ff;outline-offset:2px}.header{background:none;color:#202338;padding:0;margin:0 0 26px;border-radius:0}.header:before{content:'INSTITUTO ATLAS / SECRETARIA';display:block;color:#6664df;font-size:11px;font-weight:800;letter-spacing:.14em;margin-bottom:12px}.header h1{font-size:clamp(26px,3vw,34px);line-height:1.2;margin:0}.box{background:#fff;border:1px solid #e7e9f1;border-radius:16px;padding:30px;box-shadow:0 8px 26px #1b224006}.acoes{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-top:25px}.acoes a,.acoes button{display:inline-flex;align-items:center;justify-content:center;border:0;border-radius:10px;padding:12px 18px;font:inherit;font-size:12px;font-weight:700;cursor:pointer;text-decoration:none}.principal{background:#6664df;color:#fff}.principal:hover{background:#5351c7}.secundario,.cancelar{background:#efeeff;color:#5653c4}.secundario:hover,.cancelar:hover{background:#e3e1ff}.erro,.sucesso{border-radius:10px;padding:14px 16px;margin-bottom:20px;font-size:13px}.erro{background:#fff1f2;color:#9e2738;border:1px solid #ffd5dc}.sucesso{background:#ecfdf3;color:#187448;border:1px solid #c8efd9}@media(max-width:800px){main{padding:78px 20px 48px}}@media(max-width:580px){.box{padding:20px}}form{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px}.campo{display:flex;flex-direction:column;gap:8px;min-width:0}.full,.acoes{grid-column:1/-1}label{font-size:12px;font-weight:700;color:#363a52}input,select{width:100%;min-height:46px;padding:11px 13px;border-radius:10px;border:1px solid #e1e4f0;background:#fff;font:inherit;font-size:13px;color:#252741}input:hover,select:hover{border-color:#b4b3e7}@media(max-width:580px){form{grid-template-columns:1fr}}
</style></head><body><?php include '../../includes/menu_secretaria.php';?><main><section class="header"><h1>Atualizar <?php echo htmlspecialchars($tipos[$tipo]);?></h1></section><section class="box"><?php echo $mensagem;?><form method="POST"><input type="hidden" name="tipo" value="<?php echo htmlspecialchars($tipo);?>"><input type="hidden" name="acao" value="<?php echo htmlspecialchars($acao);?>"><input type="hidden" name="turma_origem" value="<?php echo $turma_origem;?>"><input type="hidden" name="id" value="<?php echo $id;?>">
<?php if($tipo==='turma'): ?><div class="campo"><label>Nome</label><input name="nome" value="<?php echo htmlspecialchars($registro['nome']);?>" required></div><div class="campo"><label>Ano letivo</label><input name="ano_letivo" type="number" value="<?php echo htmlspecialchars($registro['ano_letivo']);?>" required></div><div class="campo"><label>Período</label><select name="periodo"><option <?php echo $registro['periodo']==='Manhã'?'selected':'';?>>Manhã</option><option <?php echo $registro['periodo']==='Tarde'?'selected':'';?>>Tarde</option><option <?php echo $registro['periodo']==='Noite'?'selected':'';?>>Noite</option></select></div>
<?php elseif($tipo==='disciplina'): ?><div class="campo"><label>Nome</label><input name="nome" value="<?php echo htmlspecialchars($registro['nome']);?>" required></div><div class="campo"><label>Carga horária</label><input name="carga_horaria" type="number" value="<?php echo htmlspecialchars($registro['carga_horaria']);?>" required></div>
<?php else: ?><div class="campo"><label>Nome completo</label><input name="nome" value="<?php echo htmlspecialchars($registro['nome']);?>" required></div><div class="campo"><label>CPF</label><input name="cpf" value="<?php echo htmlspecialchars($registro['cpf']??'');?>"></div><div class="campo"><label>RG</label><input name="rg" value="<?php echo htmlspecialchars($registro['rg']??'');?>"></div><div class="campo"><label>Data de nascimento</label><input name="data_nascimento" type="date" value="<?php echo htmlspecialchars($registro['data_nascimento']??'');?>"></div><div class="campo"><label>E-mail</label><input name="email" type="email" value="<?php echo htmlspecialchars($registro['email']??''); ?>" required></div><div class="campo"><label>Telefone</label><input name="telefone" value="<?php echo htmlspecialchars($registro['telefone']??'');?>"></div><div class="campo full"><label>Endereço</label><input name="endereco" value="<?php echo htmlspecialchars($registro['endereco']??'');?>"></div><?php if($tipo==='aluno'): ?><div class="campo"><label>RM</label><input name="rm" value="<?php echo htmlspecialchars($registro['rm']);?>" required></div><div class="campo"><label>Data da matrícula</label><input name="data_matricula" type="date" value="<?php echo htmlspecialchars($registro['data_matricula']);?>" required></div><div class="campo full"><label>Turma</label><select name="id_turma" required><?php foreach($turmas as $item):?><option value="<?php echo $item['id_turma'];?>" <?php echo $registro['id_turma']==$item['id_turma']?'selected':'';?>><?php echo htmlspecialchars($item['nome'].' - '.$item['ano_letivo'].' - '.$item['periodo']);?></option><?php endforeach;?></select></div><?php endif;?><?php endif;?><div class="acoes"><button class="principal" type="submit">Salvar alterações</button><a class="secundario" href="<?php echo htmlspecialchars($retorno);?>">Cancelar</a></div></form></section></main></body></html>
