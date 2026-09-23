<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Professor');

$id_professor = $_SESSION['id_usuario'];
$id_turma = intval($_POST['turma'] ?? $_GET['turma'] ?? 0);
$data_aula = trim($_POST['data'] ?? $_GET['data'] ?? date('Y-m-d'));
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_aula)) { $data_aula = date('Y-m-d'); }

$mensagem = '';

// Se clicar em salvar
if (isset($_POST['salvar_chamada'])) {
    // Buscar os dados enviados
    $presencas = $_POST['presenca'] ?? [];
    
    if ($id_turma > 0) {
        // Buscar turma_disciplina para este professor
        $sql = "SELECT td.id_turma_disciplina FROM turma_disciplina td WHERE td.id_turma = ? AND td.id_professor = ? LIMIT 1";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ii", $id_turma, $id_professor);
        $stmt->execute();
        $result = $stmt->get_result();
        $td_row = $result->fetch_assoc();
        $id_turma_disciplina = $td_row['id_turma_disciplina'] ?? 0;
        $stmt->close();
        
        if ($id_turma_disciplina > 0) {
            $faltosos = [];
            
            foreach ($presencas as $id_matricula => $presente) {
                if ($presente !== '0' && $presente !== '1' && $presente !== 0 && $presente !== 1) { continue; }
                $id_matricula = (int) $id_matricula;
                if ($id_matricula <= 0) { continue; }
                $presente = intval($presente);
                
                // Verificar se já existe registro de frequência para este dia
                $sql = "SELECT id_frequencia FROM frequencia WHERE id_matricula = ? AND id_turma_disciplina = ? AND data_aula = ?";
                $stmt = $conexao->prepare($sql);
                $stmt->bind_param("iis", $id_matricula, $id_turma_disciplina, $data_aula);
                $stmt->execute();
                $result = $stmt->get_result();
                $freq_row = $result->fetch_assoc();
                $stmt->close();
                
                if ($freq_row) {
                    // UPDATE
                    $sql = "UPDATE frequencia SET presente = ? WHERE id_frequencia = ?";
                    $stmt = $conexao->prepare($sql);
                    $stmt->bind_param("ii", $presente, $freq_row['id_frequencia']);
                } else {
                    // INSERT
                    $sql = "INSERT INTO frequencia (id_matricula, id_turma_disciplina, data_aula, presente) VALUES (?, ?, ?, ?)";
                    $stmt = $conexao->prepare($sql);
                    $stmt->bind_param("iisi", $id_matricula, $id_turma_disciplina, $data_aula, $presente);
                }
                $stmt->execute();
                $stmt->close();
                
                if (!$presente) {
                    // Buscar nome do aluno para exibir faltosos
                    $sql = "SELECT u.nome FROM matricula m JOIN usuario u ON m.id_aluno = u.id_usuario WHERE m.id_matricula = ?";
                    $stmt = $conexao->prepare($sql);
                    $stmt->bind_param("i", $id_matricula);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $aluno = $result->fetch_assoc();
                    if ($aluno) $faltosos[] = $aluno['nome'];
                    $stmt->close();
                }
            }
            
            if (count($faltosos) > 0) {
                $faltosos_str = implode(', ', $faltosos);
                $mensagem = '<div style="background: #eef9ff; color: #0369a1; padding: 10px; border-radius: 5px; margin-bottom: 15px;">Chamada salva com sucesso!<br>Faltosos: ' . htmlspecialchars($faltosos_str) . '</div>';
            } else {
                $mensagem = '<div style="background: #efe; color: #363; padding: 10px; border-radius: 5px; margin-bottom: 15px;">Chamada salva com sucesso! Nenhum aluno faltou.</div>';
            }
        }
    }
}

// Buscar turmas do professor (apenas as que têm aulas naquele dia)
$turmas = [];
$dia_semana = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta'];
$num_dia = date('N', strtotime($data_aula));
$dia_nome = $dia_semana[$num_dia - 1] ?? 'Segunda';

$sql = "SELECT DISTINCT t.id_turma, t.nome FROM turma t
        JOIN turma_disciplina td ON t.id_turma = td.id_turma
        JOIN horario h ON h.id_turma_disciplina = td.id_turma_disciplina
        WHERE td.id_professor = ? AND h.dia_semana = ?
        ORDER BY t.nome";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("is", $id_professor, $dia_nome);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $turmas[] = $row;
}
$stmt->close();

// Buscar alunos da turma selecionada
$alunos = [];
$turma_nome = '';

if ($id_turma > 0 && array_filter($turmas, fn($turma) => (int)$turma['id_turma'] === $id_turma)) {
    $sql = "SELECT t.nome AS turma_nome FROM turma t WHERE t.id_turma = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_turma);
    $stmt->execute();
    $result = $stmt->get_result();
    $t = $result->fetch_assoc();
    $turma_nome = $t['turma_nome'] ?? '';
    $stmt->close();
    
    // Buscar alunos e sua presença nesta data
    $sql = "SELECT m.id_matricula, m.rm, u.nome, COALESCE(f.presente, NULL) as presente_registro
            FROM matricula m
            JOIN usuario u ON m.id_aluno = u.id_usuario
            LEFT JOIN frequencia f ON m.id_matricula = f.id_matricula 
                AND f.id_turma_disciplina = (SELECT id_turma_disciplina FROM turma_disciplina WHERE id_turma = ? AND id_professor = ? LIMIT 1)
                AND f.data_aula = ?
            WHERE m.id_turma = ?
            ORDER BY u.nome";
    
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("iisi", $id_turma, $id_professor, $data_aula, $id_turma);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $alunos[] = $row;
    }
    $stmt->close();
}
?><!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Professor | Chamada — Instituto Atlas</title><style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');*{box-sizing:border-box}body{margin:0;background:#f7f8fc;color:#202338;font-family:Inter,Arial,sans-serif}.atlas-main{max-width:1320px;margin:0 auto;padding:36px 60px 76px}.eyebrow{font-size:11px;font-weight:800;letter-spacing:.15em;color:#777d93;text-transform:uppercase}.head{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;margin-bottom:30px}.head h1{font-size:38px;letter-spacing:-.055em;margin:13px 0 8px;font-weight:800}.head h1 span{color:#6664df}.sub{color:#777d93;font-size:14px;line-height:1.6;margin:0}.tag{border:1px solid #e7e9f1;background:#fff;border-radius:30px;padding:10px 15px;font-size:12px;color:#6664df;font-weight:700}.box{background:#fff;border:1px solid #e7e9f1;border-radius:17px;padding:28px 30px;margin-bottom:20px;box-shadow:0 7px 22px rgba(29,32,63,.025)}.box h2{font-size:17px;letter-spacing:-.03em;margin:0 0 20px}.muted{color:#777d93;font-size:13px}.filters{display:flex;gap:16px;align-items:end;flex-wrap:wrap}.field{flex:1;min-width:180px}.field label,.form-label{display:block;color:#777d93;font-size:12px;font-weight:700;margin-bottom:9px}select,input,textarea{font:inherit;font-size:13px;border:1px solid #e1e4ef;background:#fafbfe;color:#292d45;border-radius:10px;padding:12px 13px;width:100%;outline:none}select:focus,input:focus,textarea:focus{border-color:#6664df;box-shadow:0 0 0 3px #6664df18}.readonly{display:flex;align-items:center;min-height:43px;padding:10px 13px;background:#fafbfe;border:1px solid #e7e9f1;border-radius:10px;font-size:13px;font-weight:700}.btn{border:0;border-radius:10px;background:#6664df;color:white;padding:13px 20px;font:inherit;font-size:12px;font-weight:800;cursor:pointer;white-space:nowrap}.btn:hover{background:#5552c9}.table-wrap{overflow-x:auto}table{width:100%;border-collapse:collapse;font-size:13px}th{text-align:left;font-size:10px;letter-spacing:.08em;text-transform:uppercase;color:#858aa0;background:#fafbfe;padding:15px 13px;white-space:nowrap}td{padding:15px 13px;border-bottom:1px solid #eef0f6;color:#353950}tbody tr:last-child td{border-bottom:0}.badge{display:inline-block;padding:7px 11px;border-radius:100px;font-size:11px;font-weight:800}.verde{background:#e8f8ef;color:#207a4a}.amarelo{background:#fff4df;color:#946000}.vermelho{background:#ffe9ec;color:#b3334c}.empty{padding:24px;border:1px dashed #dfe2ef;border-radius:12px;color:#777d93;font-size:13px;text-align:center}.section-head{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:20px}.section-head h2{margin:0}.hint{font-size:12px;color:#858aa0}@media(max-width:1100px){.atlas-main{padding:32px 30px 65px}}@media(max-width:700px){.atlas-main{padding:28px 18px 50px}.head h1{font-size:31px}.tag{display:none}.box{padding:22px 18px}.filters{display:block}.field{margin-bottom:14px}.btn{width:100%}}.attendance-row{display:flex;justify-content:space-between;align-items:center;gap:16px;padding:17px 4px;border-bottom:1px solid #eef0f6}.attendance-row:last-child{border:0}.attendance-row strong{display:block;font-size:13px}.attendance-row small{display:block;font-size:11px;color:#858aa0;margin-top:6px}.choices{display:flex;gap:8px}.choice{position:relative;cursor:pointer}.choice input{position:absolute;opacity:0;width:1px;height:1px}.choice span{display:block;border:1px solid #dcebe1;background:#f4fbf6;color:#417c53;border-radius:9px;padding:10px 15px;font-size:12px;font-weight:800}.choice.absent span{background:#fff8f8;border-color:#f3e0e3;color:#a84a57}.choice input:checked+span{background:#dcf7e5;border-color:#2a9c59;box-shadow:0 0 0 2px #2a9c5920}.choice.absent input:checked+span{background:#ffe4e8;border-color:#d34c66;box-shadow:0 0 0 2px #d34c6620}.choice input:focus-visible+span{outline:3px solid #6664df}.save{display:flex;align-items:center;justify-content:space-between;gap:15px;margin-top:24px}@media(max-width:700px){.attendance-row{align-items:flex-start;flex-direction:column}.save{align-items:stretch;flex-direction:column}}</style></head><body><?php include '../../includes/menu_professor.php'; ?><main class="atlas-main"><header class="head"><div><div class="eyebrow">Instituto Atlas &nbsp;/&nbsp; Portal do professor</div><h1>Chamada<span>.</span></h1><p class="sub">Registre a presença dos alunos por aula.</p></div><span class="tag">Área do professor</span></header><section class="box"><div class="section-head"><h2>Selecionar aula</h2><span class="hint">Escolha a data e a turma</span></div><?php echo $mensagem;?><form method="GET" class="filters"><div class="field"><label for="data">Data da aula</label><input id="data" type="date" name="data" value="<?php echo htmlspecialchars($data_aula); ?>"></div><div class="field"><label for="turma">Turma</label><select id="turma" name="turma"><option value="">Selecione uma turma</option><?php foreach($turmas as $turma):?><option value="<?php echo (int)$turma['id_turma']; ?>" <?php echo $id_turma==(int)$turma['id_turma']?'selected':''; ?>><?php echo htmlspecialchars($turma['nome']); ?></option><?php endforeach;?></select></div><button class="btn" type="submit">Buscar alunos</button></form></section><?php if($id_turma>0&&count($alunos)>0):?><section class="box"><div class="section-head"><h2><?php echo htmlspecialchars($turma_nome.' · '.date('d/m/Y',strtotime($data_aula)));?></h2><span class="hint"><?php echo count($alunos);?> alunos</span></div><form method="POST"><input type="hidden" name="turma" value="<?php echo $id_turma;?>"><input type="hidden" name="data" value="<?php echo htmlspecialchars($data_aula);?>"><div class="attendance-list"><?php foreach($alunos as $aluno):?><div class="attendance-row"><div><strong><?php echo htmlspecialchars($aluno['nome']);?></strong><small>RM <?php echo htmlspecialchars($aluno['rm']);?></small></div><div class="choices"><label class="choice"><input type="radio" name="presenca[<?php echo (int)$aluno['id_matricula'];?>]" value="1" <?php echo $aluno['presente_registro']!==null&&(int)$aluno['presente_registro']===1?'checked':'';?>><span>Presente</span></label><label class="choice absent"><input type="radio" name="presenca[<?php echo (int)$aluno['id_matricula'];?>]" value="0" <?php echo $aluno['presente_registro']!==null&&(int)$aluno['presente_registro']===0?'checked':'';?>><span>Falta</span></label></div></div><?php endforeach;?></div><div class="save"><span class="hint">Selecione a situação de cada aluno antes de salvar.</span><button type="submit" name="salvar_chamada" value="1" class="btn">Salvar chamada</button></div></form></section><?php elseif($id_turma>0):?><section class="box"><div class="empty">Nenhum aluno encontrado nesta turma ou nenhuma aula disponível na data selecionada.</div></section><?php endif;?></main></body></html>