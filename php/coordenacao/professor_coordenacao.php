<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Coordenação');

$id_professor = intval($_GET['id'] ?? 0);

// Se não tiver ID, redirecionar
if ($id_professor == 0) {
    header('Location: professores_coordenacao.php');
    exit();
}

// Buscar dados do professor
$sql = "SELECT * FROM usuario WHERE id_usuario = ? AND perfil = 'Professor'";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$result = $stmt->get_result();
$professor = $result->fetch_assoc();
$stmt->close();

if (!$professor) {
    header('Location: professores_coordenacao.php');
    exit();
}

// Buscar turmas e disciplinas
$turmas = [];
$sql = "SELECT DISTINCT t.nome FROM turma t
        JOIN turma_disciplina td ON t.id_turma = td.id_turma
        WHERE td.id_professor = ?
        ORDER BY t.nome";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $turmas[] = $row['nome'];
}
$stmt->close();

// Buscar horários
$horarios = [];
$sql = "SELECT DISTINCT h.hora_inicio, h.hora_fim FROM horario h
        JOIN turma_disciplina td ON h.id_turma_disciplina = td.id_turma_disciplina
        WHERE td.id_professor = ?
        ORDER BY h.hora_inicio";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $horario = substr($row['hora_inicio'], 0, 5) . ' às ' . substr($row['hora_fim'], 0, 5);
    if (!in_array($horario, $horarios)) {
        $horarios[] = $horario;
    }
}
$stmt->close();

// Calcular frequência média dos alunos
$sql = "SELECT AVG(frequencia_perc) as freq_media FROM (
    SELECT 
        CASE 
            WHEN COUNT(DISTINCT f.data_aula) = 0 THEN 100
            ELSE ROUND(SUM(CASE WHEN f.presente = 1 THEN 1 ELSE 0 END) / COUNT(DISTINCT f.data_aula) * 100)
        END as frequencia_perc
    FROM matricula m
    JOIN turma_disciplina td ON m.id_turma = td.id_turma
    LEFT JOIN frequencia f ON m.id_matricula = f.id_matricula AND f.id_turma_disciplina = td.id_turma_disciplina
    WHERE td.id_professor = ?
    GROUP BY m.id_matricula
) as freq_alunos";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$freq_media = round($row['freq_media'] ?? 0);
$stmt->close();

// Calcular média de notas
$sql = "SELECT AVG(n.nota) as media_notas
        FROM nota n
        JOIN matricula m ON n.id_matricula = m.id_matricula
        JOIN turma_disciplina td ON m.id_turma = td.id_turma
        WHERE td.id_professor = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_professor);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$media_notas = round($row['media_notas'] ?? 0, 1);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordenação | Professor</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #1f2937;
        }
        nav { background: #1b2d4d; }
        main {
            max-width: 900px;
            margin: 32px auto;
            padding: 0 20px 40px;
        }
        .card {
            background: white;
            border-radius: 18px;
            border: 1px solid #e1eaf7;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
            padding: 28px;
        }
        .titulo {
            font-size: 2rem;
            color: #123d70;
            margin-bottom: 8px;
        }
        .sub {
            color: #5d6a79;
            margin-bottom: 18px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
        }
        .bloco {
            background: #f7faff;
            border-radius: 12px;
            padding: 16px 18px;
            border: 1px solid #e3ebf7;
        }
        .label {
            font-size: 0.8rem;
            color: #4d5d72;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .valor {
            margin-top: 8px;
            font-size: 1.05rem;
            font-weight: bold;
            color: #163d68;
        }
    </style>
</head>
<body>
    <?php include "../../includes/menu_coordenacao.php"; ?>

    <main>
        <section class="card">
            <div class="titulo"><?php echo htmlspecialchars($professor['nome']); ?></div>
            <div class="sub">Professor de Educação</div>

            <div class="grid">
                <div class="bloco">
                    <div class="label">Turmas</div>
                    <div class="valor"><?php echo count($turmas) > 0 ? htmlspecialchars(implode(', ', array_slice($turmas, 0, 3))) : 'N/A'; ?></div>
                </div>
                <div class="bloco">
                    <div class="label">Horário</div>
                    <div class="valor"><?php echo count($horarios) > 0 ? htmlspecialchars($horarios[0]) : 'N/A'; ?></div>
                </div>
                <div class="bloco">
                    <div class="label">Frequência</div>
                    <div class="valor"><?php echo $freq_media; ?>%</div>
                </div>
                <div class="bloco">
                    <div class="label">Média de turma</div>
                    <div class="valor"><?php echo $media_notas; ?></div>
                </div>
            </div>
            
            <p style="margin-top: 20px;">
                <a href="professores_coordenacao.php" style="color: #4568a8; text-decoration: none;">← Voltar</a>
            </p>
        </section>
    </main>
</body>
</html>
