<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Professor');

$id_professor = $_SESSION['id_usuario'];

// Dados do professor
$sql = "SELECT nome FROM usuario WHERE id_usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$result = $stmt->get_result();
$prof = $result->fetch_assoc();
$nome_prof = $prof['nome'] ?? 'Professor';
$stmt->close();

// Total de alunos
$sql = "SELECT COUNT(DISTINCT m.id_aluno) as total_alunos
        FROM matricula m
        JOIN turma_disciplina td ON m.id_turma = td.id_turma
        WHERE td.id_professor = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$result = $stmt->get_result();
$alunos_row = $result->fetch_assoc();
$total_alunos = $alunos_row['total_alunos'] ?? 0;
$stmt->close();

// Turmas ativas
$sql = "SELECT COUNT(DISTINCT t.id_turma) as turmas_ativas
        FROM turma t
        JOIN turma_disciplina td ON t.id_turma = td.id_turma
        WHERE td.id_professor = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$result = $stmt->get_result();
$turmas_row = $result->fetch_assoc();
$turmas_ativas = $turmas_row['turmas_ativas'] ?? 0;
$stmt->close();

// Aulas hoje (contando horários com dia de hoje)
$dias_semana = [1 => 'Segunda', 2 => 'Terça', 3 => 'Quarta', 4 => 'Quinta', 5 => 'Sexta'];
$dia_semana = $dias_semana[date('N')] ?? '';
$sql = "SELECT COUNT(DISTINCT h.id_horario) as aulas_hoje
        FROM horario h
        JOIN turma_disciplina td ON h.id_turma_disciplina = td.id_turma_disciplina
        WHERE td.id_professor = ? AND h.dia_semana = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("is", $id_professor, $dia_semana);
$stmt->execute();
$result = $stmt->get_result();
$aulas_row = $result->fetch_assoc();
$aulas_hoje = $aulas_row['aulas_hoje'] ?? 0;
$stmt->close();

// Notas pendentes (notas NULL ou vazias)
$sql = "SELECT COUNT(*) as notas_pendentes
        FROM nota n
        JOIN turma_disciplina td ON n.id_turma_disciplina = td.id_turma_disciplina
        WHERE td.id_professor = ? AND (n.nota IS NULL OR n.nota = '')";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$result = $stmt->get_result();
$notas_row = $result->fetch_assoc();
$notas_pendentes = $notas_row['notas_pendentes'] ?? 0;
$stmt->close();

// Minhas turmas
$sql = "SELECT t.nome as turma_nome, d.nome as disciplina_nome, t.periodo, COUNT(DISTINCT m.id_aluno) as total_alunos, AVG(n.nota) as media
        FROM turma t
        JOIN turma_disciplina td ON t.id_turma = td.id_turma
        JOIN disciplina d ON td.id_disciplina = d.id_disciplina
        LEFT JOIN matricula m ON t.id_turma = m.id_turma
        LEFT JOIN nota n ON m.id_matricula = n.id_matricula AND n.id_turma_disciplina = td.id_turma_disciplina
        WHERE td.id_professor = ?
        GROUP BY t.nome, d.nome, t.periodo
        ORDER BY t.nome";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$result = $stmt->get_result();
$minhas_turmas = [];
while ($row = $result->fetch_assoc()) {
    $row['media'] = $row['media'] ? number_format($row['media'], 1) : '-';
    $minhas_turmas[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor | Início</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #1f2937; }
        main { max-width: 1180px; margin: 32px auto; padding: 0 20px 40px; }
        .topo { background: linear-gradient(135deg, #1f3b65, #4568a8); color: white; border-radius: 18px; padding: 30px 28px; margin-bottom: 26px; }
        .topo h1 { margin: 0 0 4px; font-size: 2rem; }
        .topo p { margin: 0; font-size: 0.9rem; opacity: 0.8; }
        .painel { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; margin-bottom: 28px; }
        .box { background: white; padding: 20px; border-radius: 16px; border: 1px solid #dfe9f6; box-shadow: 0 8px 20px rgba(15,23,42,0.04); }
        .box .titulo { color: #6b7280; font-size: 0.82rem; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 10px; }
        .box .valor { font-size: 2rem; font-weight: bold; color: #183f73; }
        .panel { background: #fff; border-radius: 18px; padding: 22px; border: 1px solid #e5ebf6; box-shadow: 0 10px 22px rgba(15,23,42,0.04); margin-bottom: 22px; }
        .panel h2 { margin-top: 0; color: #133b6d; }
        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        thead th { text-align: left; padding: 10px 12px; font-size: 0.75rem; color: #6b7280; border-bottom: 1px solid #edf2f9; text-transform: uppercase; }
        tbody td { padding: 12px; border-bottom: 1px solid #edf2f9; color: #374151; }
        tbody tr:last-child td { border-bottom: none; }
    </style>
</head>
<body>
    <?php include '../../includes/menu_professor.php'; ?>
    <main>
        <section class="topo">
            <h1>Bem-vindo, <?php echo htmlspecialchars($nome_prof); ?>!</h1>
        </section>
        <section class="painel">
            <div class="box"><div class="titulo">Total de Alunos</div><div class="valor"><?php echo $total_alunos; ?></div></div>
            <div class="box"><div class="titulo">Turmas Ativas</div><div class="valor"><?php echo $turmas_ativas; ?></div></div>
            <div class="box"><div class="titulo">Aulas Hoje</div><div class="valor"><?php echo $aulas_hoje; ?></div></div>
            <div class="box"><div class="titulo">Notas Pendentes</div><div class="valor"><?php echo $notas_pendentes; ?></div></div>
        </section>
        <div class="panel">
            <h2>Minhas Turmas</h2>
            <?php if (count($minhas_turmas) > 0): ?>
                <table>
                    <thead><tr><th>Turma</th><th>Disciplina</th><th>Período</th><th>Alunos</th><th>Média</th></tr></thead>
                    <tbody>
                        <?php foreach ($minhas_turmas as $turma): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($turma['turma_nome']); ?></td>
                                <td><?php echo htmlspecialchars($turma['disciplina_nome']); ?></td>
                                <td><?php echo htmlspecialchars($turma['periodo']); ?></td>
                                <td><?php echo $turma['total_alunos']; ?></td>
                                <td><?php echo $turma['media']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="color: #666;">Nenhuma turma atribuída.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>