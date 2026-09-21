<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

// Verificar se é aluno
verificar_perfil('Aluno');

$id_aluno = $_SESSION['id_usuario'];

// Consultar dados do aluno e sua turma
$sql = "SELECT u.nome, u.email, m.rm, t.nome as turma_nome, t.periodo, t.ano_letivo 
        FROM usuario u 
        JOIN matricula m ON u.id_usuario = m.id_aluno
        JOIN turma t ON m.id_turma = t.id_turma
        WHERE u.id_usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_aluno);
$stmt->execute();
$result = $stmt->get_result();
$aluno = $result->fetch_assoc();
$stmt->close();

if (!$aluno) {
    echo "Dados do aluno não encontrados.";
    exit();
}

// Calcular média geral
$sql = "SELECT AVG(n.nota) as media_geral
        FROM nota n
        JOIN matricula m ON n.id_matricula = m.id_matricula
        WHERE m.id_aluno = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_aluno);
$stmt->execute();
$result = $stmt->get_result();
$media_row = $result->fetch_assoc();
$media_geral = $media_row['media_geral'] ?? 0;
$media_geral = number_format($media_geral, 1);
$stmt->close();

// Calcular frequência geral e contar faltas
$sql = "SELECT COUNT(*) as total_aulas, SUM(CASE WHEN presente = 1 THEN 1 ELSE 0 END) as aulas_presentes
        FROM frequencia f
        JOIN matricula m ON f.id_matricula = m.id_matricula
        WHERE m.id_aluno = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_aluno);
$stmt->execute();
$result = $stmt->get_result();
$freq_row = $result->fetch_assoc();
$total_aulas = $freq_row['total_aulas'] ?? 0;
$aulas_presentes = $freq_row['aulas_presentes'] ?? 0;
$frequencia = $total_aulas > 0 ? round(($aulas_presentes / $total_aulas) * 100, 1) : 0;
$faltas = $total_aulas - $aulas_presentes;
$stmt->close();

// Contar questionários pendentes
$sql = "SELECT COUNT(*) as pendentes FROM questionario WHERE criado_por != ? AND id_questionario NOT IN (SELECT id_questionario FROM pergunta WHERE id_pergunta IN (SELECT id_pergunta FROM resposta WHERE id_usuario = ?))";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ii", $id_aluno, $id_aluno);
$stmt->execute();
$result = $stmt->get_result();
$quest_row = $result->fetch_assoc();
$questionarios_pendentes = $quest_row['pendentes'] ?? 0;
$stmt->close();

// Buscar disciplinas com frequência < 75%
$disciplinas_risco = [];
$sql = "SELECT td.id_turma_disciplina, d.nome, COUNT(*) as total, SUM(CASE WHEN f.presente = 1 THEN 1 ELSE 0 END) as presentes
        FROM frequencia f
        JOIN turma_disciplina td ON f.id_turma_disciplina = td.id_turma_disciplina
        JOIN disciplina d ON td.id_disciplina = d.id_disciplina
        JOIN matricula m ON f.id_matricula = m.id_matricula
        WHERE m.id_aluno = ?
        GROUP BY td.id_turma_disciplina, d.nome
        HAVING (SUM(CASE WHEN f.presente = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100 < 75";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_aluno);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $freq_disc = $row['presentes'] > 0 ? round(($row['presentes'] / $row['total']) * 100, 1) : 0;
    $disciplinas_risco[] = ['nome' => $row['nome'], 'frequencia' => $freq_disc];
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aluno | Início</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #1f2937;
        }
        main {
            max-width: 1180px;
            margin: 32px auto;
            padding: 0 20px 40px;
        }
        .topo {
            background: linear-gradient(135deg, #1f3b65, #4568a8);
            color: white;
            border-radius: 18px;
            padding: 30px 28px;
            margin-bottom: 26px;
        }
        .topo h1 { margin: 0 0 4px; font-size: 2rem; }
        .topo p  { margin: 0; font-size: 0.9rem; opacity: 0.8; }
        .painel {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }
        .box {
            background: white;
            padding: 20px;
            border-radius: 16px;
            border: 1px solid #dfe9f6;
            box-shadow: 0 8px 20px rgba(15,23,42,0.04);
        }
        .box .titulo {
            color: #6b7280;
            font-size: 0.82rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .box .valor {
            font-size: 2rem;
            font-weight: bold;
            color: #183f73;
        }
        .grid {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: 22px;
            margin-bottom: 22px;
        }
        .panel {
            background: #fff;
            border-radius: 18px;
            padding: 22px;
            border: 1px solid #e5ebf6;
            box-shadow: 0 10px 22px rgba(15,23,42,0.04);
        }
        .panel h2 { margin-top: 0; color: #133b6d; }
        .perfil-foto {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #dfe9f6;
            margin-bottom: 14px;
        }
        .perfil-dados p {
            font-size: 0.875rem;
            color: #374151;
            margin-bottom: 7px;
        }
        .badge-cursando {
            background: #eaf7ef;
            color: #157c3d;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: bold;
        }
        .lista { list-style: none; margin: 0; padding: 0; }
        .lista li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #edf2f9;
            font-size: 0.875rem;
        }
        .lista li:last-child { border-bottom: none; }
        .badge {
            background: #eaf7ef;
            color: #157c3d;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: bold;
        }
        .alerta { background: #fff7e8; color: #996000; }
        .aviso {
            background: #fff7e8;
            border-left: 4px solid #f59e0b;
            border-radius: 10px;
            padding: 14px 18px;
            font-size: 0.875rem;
            color: #92400e;
            margin-top: 22px;
        }
        .aviso strong { font-weight: bold; }
    </style>
</head>
<body>

    <?php include '../../includes/menu_aluno.php'; ?>

    <main>
        <section class="topo">
            <h1>Bem-vindo, <?php echo htmlspecialchars($aluno['nome']); ?>!</h1>
        </section>

        <section class="painel">
            <div class="box">
                <div class="titulo">Média Geral</div>
                <div class="valor"><?php echo $media_geral; ?></div>
            </div>
            <div class="box">
                <div class="titulo">Frequência</div>
                <div class="valor"><?php echo $frequencia; ?>%</div>
            </div>
            <div class="box">
                <div class="titulo">Faltas</div>
                <div class="valor"><?php echo $faltas; ?></div>
            </div>
            <div class="box">
                <div class="titulo">Questionários Pendentes</div>
                <div class="valor"><?php echo $questionarios_pendentes; ?></div>
            </div>
        </section>

        <section class="grid">
            <div class="panel">
                <h2>Informações do Aluno</h2>
                <div class="perfil-dados">
                    <p><strong>Unidade:</strong> Instituto Atlas</p>
                    <p><strong>RM:</strong> <?php echo htmlspecialchars($aluno['rm']); ?></p>
                    <p><strong>Nome:</strong> <?php echo htmlspecialchars($aluno['nome']); ?></p>
                    <p><strong>Turma:</strong> <?php echo htmlspecialchars($aluno['turma_nome']); ?></p>
                    <p><strong>Período:</strong> <?php echo htmlspecialchars($aluno['periodo']); ?></p>
                    <p><strong>Ano Letivo:</strong> <?php echo htmlspecialchars($aluno['ano_letivo']); ?></p>
                    <p><strong>Sit. Matrícula:</strong> <span class="badge-cursando">Cursando</span></p>
                </div>
            </div>

            <div class="panel">
                <h2>⚠ Disciplinas com Frequência Baixa</h2>
                <?php if (count($disciplinas_risco) > 0): ?>
                    <ul class="lista">
                        <?php foreach ($disciplinas_risco as $disc): ?>
                            <li>
                                <span><?php echo htmlspecialchars($disc['nome']); ?></span>
                                <span class="badge alerta"><?php echo $disc['frequencia']; ?>%</span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p style="color: #666; font-size: 0.875rem;">Você não possui disciplinas com frequência baixa.</p>
                <?php endif; ?>
            </div>
        </section>

        <?php if (count($disciplinas_risco) > 0): ?>
            <div class="aviso">
                ⚠ Sua frequência em <strong><?php echo htmlspecialchars($disciplinas_risco[0]['nome']); ?></strong> está em <strong><?php echo $disciplinas_risco[0]['frequencia']; ?>%</strong>, abaixo do mínimo exigido de 75%. Você pode ser reprovado por falta.
            </div>
        <?php endif; ?>

    </main>

</body>
</html>