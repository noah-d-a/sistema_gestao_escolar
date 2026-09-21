<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Professor');

$id_professor = $_SESSION['id_usuario'];

// Buscar horários
$sql = "SELECT h.dia_semana, h.hora_inicio, h.hora_fim, t.nome as turma_nome, d.nome as disciplina_nome
        FROM horario h
        JOIN turma_disciplina td ON h.id_turma_disciplina = td.id_turma_disciplina
        JOIN turma t ON td.id_turma = t.id_turma
        JOIN disciplina d ON td.id_disciplina = d.id_disciplina
        WHERE td.id_professor = ?
        ORDER BY FIELD(h.dia_semana, 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta'), h.hora_inicio";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$result = $stmt->get_result();

$horarios_unicos = [];
$dias_ordem = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta'];

while ($row = $result->fetch_assoc()) {
    $hora_key = $row['hora_inicio'];
    if (!isset($horarios_unicos[$hora_key])) {
        $horarios_unicos[$hora_key] = [];
    }
    $horarios_unicos[$hora_key][$row['dia_semana']] = $row['turma_nome'] . ' · ' . $row['disciplina_nome'];
}
$stmt->close();

$horarios = [];
foreach ($horarios_unicos as $hora => $dias) {
    $linha = ['hora' => $hora];
    foreach ($dias_ordem as $dia) {
        $linha[$dia] = $dias[$dia] ?? '—';
    }
    $horarios[] = $linha;
}

usort($horarios, function($a, $b) {
    return strcmp($a['hora'], $b['hora']);
});
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor | Horário</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #1f2937; }
        main { max-width: 1180px; margin: 32px auto; padding: 0 20px 40px; }
        .topo { background: linear-gradient(135deg, #1f3b65, #4568a8); color: white; border-radius: 18px; padding: 30px 28px; margin-bottom: 26px; }
        .topo h1 { margin: 0 0 4px; font-size: 2rem; }
        .topo p { margin: 0; font-size: 0.9rem; opacity: 0.8; }
        .panel { background: #fff; border-radius: 18px; padding: 22px; border: 1px solid #e5ebf6; box-shadow: 0 10px 22px rgba(15,23,42,0.04); }
        .panel h2 { margin-top: 0; color: #133b6d; }
        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        thead th { text-align: left; padding: 10px 12px; font-size: 0.75rem; color: #6b7280; border-bottom: 1px solid #edf2f9; text-transform: uppercase; }
        tbody td { padding: 12px; border-bottom: 1px solid #edf2f9; color: #374151; }
        tbody tr:last-child td { border-bottom: none; }
        .rodape { font-size: 0.75rem; color: #9ca3af; margin-top: 14px; border-top: 1px solid #edf2f9; padding-top: 10px; }
    </style>
</head>
<body>
    <?php include '../../includes/menu_professor.php'; ?>
    <main>
        <section class="topo">
            <h1>Meus Horários</h1>
            <p>Grade de aulas semanal — ano letivo 2026</p>
        </section>
        <div class="panel">
            <h2>Grade Semanal</h2>
            <?php if (count($horarios) > 0): ?>
                <table>
                    <thead><tr><th>Horário</th><th>Segunda</th><th>Terça</th><th>Quarta</th><th>Quinta</th><th>Sexta</th></tr></thead>
                    <tbody>
                        <?php foreach ($horarios as $linha): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($linha['hora']); ?></strong></td>
                                <td><?php echo htmlspecialchars($linha['Segunda']); ?></td>
                                <td><?php echo htmlspecialchars($linha['Terça']); ?></td>
                                <td><?php echo htmlspecialchars($linha['Quarta']); ?></td>
                                <td><?php echo htmlspecialchars($linha['Quinta']); ?></td>
                                <td><?php echo htmlspecialchars($linha['Sexta']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p class="rodape">* Horários sujeitos a alterações. Consulte a coordenação em caso de dúvidas.</p>
            <?php else: ?>
                <p style="color: #666;">Nenhum horário atribuído.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>