<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Professor');

$id_professor = $_SESSION['id_usuario'];
$id_turma = intval($_POST['turma'] ?? $_GET['turma'] ?? 0);
$data_aula = trim($_POST['data'] ?? $_GET['data'] ?? date('Y-m-d'));

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

if ($id_turma > 0) {
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
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor | Chamada</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #1f2937; }
        main { max-width: 1180px; margin: 32px auto; padding: 0 20px 40px; }
        .topo { background: linear-gradient(135deg, #1f3b65, #4568a8); color: white; border-radius: 18px; padding: 30px 28px; margin-bottom: 26px; }
        .topo h1 { margin: 0 0 4px; font-size: 2rem; }
        .topo p { margin: 0; font-size: 0.9rem; opacity: 0.8; }
        .panel { background: #fff; border-radius: 18px; padding: 22px; border: 1px solid #e5ebf6; box-shadow: 0 10px 22px rgba(15,23,42,0.04); margin-bottom: 22px; }
        .panel h2 { margin-top: 0; color: #133b6d; }
        .filtros { display: flex; gap: 12px; align-items: flex-end; margin-bottom: 20px; }
        .filtros label { font-size: 0.78rem; font-weight: bold; color: #555; display: block; margin-bottom: 4px; }
        .filtros select, .filtros input { border: 1px solid #dfe9f6; border-radius: 8px; padding: 8px 12px; font-size: 0.84rem; outline: none; }
        .filtros button { background: #183f73; color: #fff; border: none; border-radius: 8px; padding: 8px 16px; font-size: 0.84rem; font-weight: bold; cursor: pointer; }
        .chamada-row { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #edf2f9; }
        .chamada-row:last-of-type { border-bottom: none; }
        .aluno-nome { font-size: 0.875rem; font-weight: bold; color: #1f2937; }
        .aluno-rm { font-size: 0.75rem; color: #9ca3af; }
        .btn-presente { background: #eaf7ef; color: #157c3d; border: 1px solid #bbf7d0; border-radius: 999px; padding: 6px 14px; font-size: 0.78rem; font-weight: bold; cursor: pointer; }
        .btn-falta { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; border-radius: 999px; padding: 6px 14px; font-size: 0.78rem; font-weight: bold; cursor: pointer; }
        .btn-salvar { background: #183f73; color: #fff; border: none; border-radius: 8px; padding: 10px 22px; font-size: 0.875rem; font-weight: bold; cursor: pointer; margin-top: 16px; }
    </style>
</head>
<body>
    <?php include '../../includes/menu_professor.php'; ?>
    <main>
        <section class="topo">
            <h1>Chamada</h1>
            <p>Registre a presença dos alunos por aula</p>
        </section>
        <div class="panel">
            <?php echo $mensagem; ?>
            <form method="POST">
                <div class="filtros">
                    <div>
                        <label>Turma</label>
                        <select name="turma" onchange="document.querySelector('input[name=data]').value='<?php echo $data_aula; ?>'; this.form.submit();">
                            <option value="">Selecione uma turma</option>
                            <?php foreach ($turmas as $turma): ?>
                                <option value="<?php echo $turma['id_turma']; ?>" <?php echo $id_turma == $turma['id_turma'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($turma['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label>Data</label>
                        <input type="date" name="data" value="<?php echo htmlspecialchars($data_aula); ?>" onchange="this.form.submit()"/>
                    </div>
                    <button type="submit" name="buscar" value="1">Buscar</button>
                </div>
            </form>
            
            <?php if ($id_turma > 0 && count($alunos) > 0): ?>
                <h2><?php echo htmlspecialchars($turma_nome . ' · ' . date('d/m/Y', strtotime($data_aula))); ?></h2>
                <form method="POST">
                    <input type="hidden" name="turma" value="<?php echo $id_turma; ?>">
                    <input type="hidden" name="data" value="<?php echo htmlspecialchars($data_aula); ?>">
                    
                    <?php foreach ($alunos as $aluno): ?>
                        <div class="chamada-row">
                            <div>
                                <div class="aluno-nome"><?php echo htmlspecialchars($aluno['nome']); ?></div>
                                <div class="aluno-rm">RM-<?php echo htmlspecialchars($aluno['rm']); ?></div>
                            </div>
                            <div style="display:flex;gap:8px;">
                                <button type="button" class="btn-presente" onclick="marcarPresenca(<?php echo $aluno['id_matricula']; ?>, 1, this)">Presente</button>
                                <button type="button" class="btn-falta" onclick="marcarPresenca(<?php echo $aluno['id_matricula']; ?>, 0, this)">Falta</button>
                                <input type="hidden" name="presenca[<?php echo $aluno['id_matricula']; ?>]" id="presenca_<?php echo $aluno['id_matricula']; ?>" value="<?php echo $aluno['presente_registro'] !== null ? ($aluno['presente_registro'] ? '1' : '0') : ''; ?>">
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <div style="text-align:right;"><button type="submit" name="salvar_chamada" value="1" class="btn-salvar">Salvar chamada</button></div>
                </form>
            <?php elseif ($id_turma > 0): ?>
                <p style="color: #666;">Nenhum aluno encontrado nesta turma.</p>
            <?php endif; ?>
        </div>
    </main>
    
    <script>
        function marcarPresenca(id_matricula, presente, btn) {
            document.getElementById('presenca_' + id_matricula).value = presente;
            
            // Alternar cor do botão
            const pai = btn.parentElement;
            pai.querySelectorAll('button').forEach(b => {
                if (b.value !== 'Buscar' && b.name !== 'salvar_chamada') {
                    b.style.opacity = '0.5';
                }
            });
            btn.style.opacity = '1';
        }
    </script>
</body>
</html>