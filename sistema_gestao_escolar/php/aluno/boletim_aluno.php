<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Aluno');

$id_aluno = $_SESSION['id_usuario'];

// Consultar dados da turma
$sql = "SELECT t.ano_letivo FROM matricula m JOIN turma t ON m.id_turma = t.id_turma WHERE m.id_aluno = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_aluno);
$stmt->execute();
$result = $stmt->get_result();
$turma_row = $result->fetch_assoc();
$ano_letivo = $turma_row['ano_letivo'] ?? date('Y');
$stmt->close();

// Calcular estatísticas gerais
$sql = "SELECT AVG(n.nota) as media_geral, 
               SUM(CASE WHEN n.nota >= 6 THEN 1 ELSE 0 END) as aprovados,
               SUM(CASE WHEN n.nota < 4 THEN 1 ELSE 0 END) as reprovados
        FROM nota n
        JOIN matricula m ON n.id_matricula = m.id_matricula
        WHERE m.id_aluno = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_aluno);
$stmt->execute();
$result = $stmt->get_result();
$stats = $result->fetch_assoc();
$media_geral = $stats['media_geral'] ? number_format($stats['media_geral'], 1) : 0;
$aprovados = $stats['aprovados'] ?? 0;
$reprovados = $stats['reprovados'] ?? 0;
$stmt->close();

// Buscar disciplinas com notas
$sql = "SELECT d.nome, u.nome as professor_nome, 
               GROUP_CONCAT(DISTINCT n.avaliacao) as avaliacoes,
               AVG(n.nota) as media
        FROM nota n
        JOIN matricula m ON n.id_matricula = m.id_matricula
        JOIN turma_disciplina td ON n.id_turma_disciplina = td.id_turma_disciplina
        JOIN disciplina d ON td.id_disciplina = d.id_disciplina
        JOIN usuario u ON td.id_professor = u.id_usuario
        WHERE m.id_aluno = ?
        GROUP BY d.nome, u.nome
        ORDER BY d.nome";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_aluno);
$stmt->execute();
$result = $stmt->get_result();
$disciplinas = [];
while ($row = $result->fetch_assoc()) {
    $row['media'] = number_format($row['media'], 1);
    $row['situacao'] = $row['media'] >= 6 ? 'Aprovado' : ($row['media'] >= 4 ? 'Recuperação' : 'Reprovado');
    $disciplinas[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aluno | Boletim</title>
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
        .panel h2 { margin-top: 0; color: #133b6d; display: flex; justify-content: space-between; align-items: center; }
        select { border: 1px solid #dfe9f6; border-radius: 8px; padding: 6px 12px; font-size: 0.84rem; color: #374151; outline: none; }
        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        thead th { text-align: left; padding: 10px 12px; font-size: 0.75rem; color: #6b7280; border-bottom: 1px solid #edf2f9; text-transform: uppercase; letter-spacing: 0.05em; }
        tbody td { padding: 12px; border-bottom: 1px solid #edf2f9; color: #374151; }
        tbody tr:last-child td { border-bottom: none; }
        .badge { padding: 4px 10px; border-radius: 999px; font-size: 0.75rem; font-weight: bold; }
        .verde { background: #eaf7ef; color: #157c3d; }
        .amarelo { background: #fff7e8; color: #996000; }
        .rodape { font-size: 0.75rem; color: #9ca3af; margin-top: 14px; border-top: 1px solid #edf2f9; padding-top: 10px; }
    </style>
</head>
<body>
    <?php include '../../includes/menu_aluno.php'; ?>
    <main>
        <section class="topo">
            <h1>Boletim</h1>
            <p>Confira suas notas por disciplina — ano letivo <?php echo htmlspecialchars($ano_letivo); ?></p>
        </section>

        <section class="painel">
            <div class="box"><div class="titulo">Média Geral</div><div class="valor"><?php echo $media_geral; ?></div></div>
            <div class="box"><div class="titulo">Aprovado</div><div class="valor"><?php echo $aprovados; ?></div></div>
            <div class="box"><div class="titulo">Reprovado</div><div class="valor"><?php echo $reprovados; ?></div></div>
        </section>

        <div class="panel">
            <h2>Notas por Disciplina</h2>
            <?php if (count($disciplinas) > 0): ?>
                <table>
                    <thead>
                        <tr><th>Disciplina</th><th>Professor</th><th>Avaliações</th><th>Média</th><th>Situação</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($disciplinas as $disc): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($disc['nome']); ?></td>
                                <td><?php echo htmlspecialchars($disc['professor_nome']); ?></td>
                                <td><?php echo htmlspecialchars($disc['avaliacoes'] ?? 'N/A'); ?></td>
                                <td><strong><?php echo $disc['media']; ?></strong></td>
                                <td>
                                    <?php 
                                    $classe = 'verde';
                                    if ($disc['situacao'] === 'Recuperação') $classe = 'amarelo';
                                    elseif ($disc['situacao'] === 'Reprovado') $classe = 'verde';
                                    ?>
                                    <span class="badge <?php echo $classe; ?>"><?php echo htmlspecialchars($disc['situacao']); ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p class="rodape">* Nota mínima para aprovação: 6.0 | Mínimo para recuperação: 4.0</p>
            <?php else: ?>
                <p style="color: #666;">Nenhuma nota registrada ainda.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>