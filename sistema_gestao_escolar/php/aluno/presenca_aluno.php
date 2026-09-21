<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Aluno');

$id_aluno = $_SESSION['id_usuario'];

// Dados da turma
$sql = "SELECT t.ano_letivo FROM matricula m JOIN turma t ON m.id_turma = t.id_turma WHERE m.id_aluno = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_aluno);
$stmt->execute();
$result = $stmt->get_result();
$turma_row = $result->fetch_assoc();
$ano_letivo = $turma_row['ano_letivo'] ?? date('Y');
$stmt->close();

// Calcular frequência geral
$sql = "SELECT COUNT(*) as total, SUM(CASE WHEN presente = 1 THEN 1 ELSE 0 END) as presentes
        FROM frequencia f
        JOIN matricula m ON f.id_matricula = m.id_matricula
        WHERE m.id_aluno = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_aluno);
$stmt->execute();
$result = $stmt->get_result();
$freq_row = $result->fetch_assoc();
$total_geral = $freq_row['total'] ?? 0;
$presentes_geral = $freq_row['presentes'] ?? 0;
$faltas_gerais = $total_geral - $presentes_geral;
$freq_geral = $total_geral > 0 ? round(($presentes_geral / $total_geral) * 100) : 0;
$stmt->close();

// Por disciplina
$sql = "SELECT d.nome, COUNT(*) as total, SUM(CASE WHEN f.presente = 1 THEN 1 ELSE 0 END) as presentes
        FROM frequencia f
        JOIN turma_disciplina td ON f.id_turma_disciplina = td.id_turma_disciplina
        JOIN disciplina d ON td.id_disciplina = d.id_disciplina
        JOIN matricula m ON f.id_matricula = m.id_matricula
        WHERE m.id_aluno = ?
        GROUP BY d.nome
        ORDER BY d.nome";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_aluno);
$stmt->execute();
$result = $stmt->get_result();
$disciplinas = [];
$em_risco = 0;
while ($row = $result->fetch_assoc()) {
    $faltas = $row['total'] - $row['presentes'];
    $freq = $row['total'] > 0 ? round(($row['presentes'] / $row['total']) * 100) : 0;
    
    if ($freq < 75) {
        $situacao = 'Risco';
        $em_risco++;
        $classe = 'vermelho';
    } elseif ($freq < 90) {
        $situacao = 'Atenção';
        $classe = 'amarelo';
    } else {
        $situacao = 'Regular';
        $classe = 'verde';
    }
    
    $disciplinas[] = [
        'nome' => $row['nome'],
        'total' => $row['total'],
        'presentes' => $row['presentes'],
        'faltas' => $faltas,
        'frequencia' => $freq,
        'situacao' => $situacao,
        'classe' => $classe
    ];
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aluno | Presença</title>
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
        .badge { padding: 4px 10px; border-radius: 999px; font-size: 0.75rem; font-weight: bold; }
        .verde { background: #eaf7ef; color: #157c3d; }
        .amarelo { background: #fff7e8; color: #996000; }
        .vermelho { background: #fee2e2; color: #991b1b; }
        .aviso { background: #fff7e8; border-left: 4px solid #f59e0b; border-radius: 10px; padding: 14px 18px; font-size: 0.875rem; color: #92400e; margin-bottom: 22px; }
        .rodape { font-size: 0.75rem; color: #9ca3af; margin-top: 14px; border-top: 1px solid #edf2f9; padding-top: 10px; }
    </style>
</head>
<body>
    <?php include '../../includes/menu_aluno.php'; ?>
    <main>
        <section class="topo">
            <h1>Presença</h1>
            <p>Acompanhe sua frequência por disciplina — ano letivo <?php echo htmlspecialchars($ano_letivo); ?></p>
        </section>

        <section class="painel">
            <div class="box"><div class="titulo">Frequência Geral</div><div class="valor"><?php echo $freq_geral; ?>%</div></div>
            <div class="box"><div class="titulo">Total de Faltas</div><div class="valor"><?php echo $faltas_gerais; ?></div></div>
            <div class="box"><div class="titulo">Em Risco</div><div class="valor"><?php echo $em_risco; ?></div></div>
            <div class="box"><div class="titulo">Totais Aulas</div><div class="valor"><?php echo $total_geral; ?></div></div>
        </section>

        <?php if ($em_risco > 0 && count($disciplinas) > 0): ?>
            <div class="aviso">⚠ Sua frequência em <strong><?php echo htmlspecialchars($disciplinas[0]['nome']); ?></strong> está em <strong><?php echo $disciplinas[0]['frequencia']; ?>%</strong>, abaixo do mínimo exigido de 75%.</div>
        <?php endif; ?>

        <div class="panel">
            <h2>Frequência por Disciplina</h2>
            <?php if (count($disciplinas) > 0): ?>
                <table>
                    <thead><tr><th>Disciplina</th><th>Presenças</th><th>Faltas</th><th>Total</th><th>Frequência</th><th>Situação</th></tr></thead>
                    <tbody>
                        <?php foreach ($disciplinas as $disc): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($disc['nome']); ?></td>
                                <td><?php echo $disc['presentes']; ?></td>
                                <td><?php echo $disc['faltas']; ?></td>
                                <td><?php echo $disc['total']; ?></td>
                                <td><?php echo $disc['frequencia']; ?>%</td>
                                <td><span class="badge <?php echo $disc['classe']; ?>"><?php echo htmlspecialchars($disc['situacao']); ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p class="rodape">* Frequência mínima exigida: 75% | Abaixo disso o aluno fica em risco de reprovação por falta.</p>
            <?php else: ?>
                <p style="color: #666;">Nenhum registro de frequência ainda.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>