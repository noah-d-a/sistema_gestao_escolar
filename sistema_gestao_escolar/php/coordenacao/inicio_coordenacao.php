<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Coordenação');

$id_coordenador = $_SESSION['id_usuario'];

// Contar alunos
$sql = "SELECT COUNT(*) as total FROM usuario WHERE perfil = 'Aluno' AND ativo = 1";
$stmt = $conexao->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_alunos = $row['total'] ?? 0;
$stmt->close();

// Contar professores
$sql = "SELECT COUNT(*) as total FROM usuario WHERE perfil = 'Professor' AND ativo = 1";
$stmt = $conexao->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_professores = $row['total'] ?? 0;
$stmt->close();

// Contar turmas
$sql = "SELECT COUNT(*) as total FROM turma";
$stmt = $conexao->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_turmas = $row['total'] ?? 0;
$stmt->close();

// Indicadores pedagógicos calculados a partir das tabelas já existentes.
$turmas_pedagogicas = [];
$sql_pedagogico = "SELECT t.id_turma, t.nome, t.ano_letivo,
    (SELECT COUNT(*) FROM matricula m WHERE m.id_turma = t.id_turma) AS matriculados,
    (SELECT ROUND(AVG(n.nota), 2) FROM nota n
      JOIN matricula m ON m.id_matricula = n.id_matricula
      JOIN turma_disciplina td ON td.id_turma_disciplina = n.id_turma_disciplina
      WHERE m.id_turma = t.id_turma AND td.id_turma = t.id_turma) AS media_notas,
    (SELECT ROUND(100 * AVG(f.presente), 1) FROM frequencia f
      JOIN matricula m ON m.id_matricula = f.id_matricula
      JOIN turma_disciplina td ON td.id_turma_disciplina = f.id_turma_disciplina
      WHERE m.id_turma = t.id_turma AND td.id_turma = t.id_turma) AS frequencia
    FROM turma t ORDER BY t.ano_letivo DESC, t.nome";
$resultado_pedagogico = $conexao->query($sql_pedagogico);
if ($resultado_pedagogico) {
    while ($turma = $resultado_pedagogico->fetch_assoc()) {
        $turmas_pedagogicas[] = $turma;
    }
    $resultado_pedagogico->free();
}

// Sem registros de presença, a frequência é desconhecida (não 100%).
$sql_frequencia_real = "SELECT ROUND(100 * AVG(presente), 1) AS percentual FROM frequencia";
$resultado_frequencia = $conexao->query($sql_frequencia_real);
$frequencia_real = $resultado_frequencia ? $resultado_frequencia->fetch_assoc()['percentual'] : null;
if ($resultado_frequencia) $resultado_frequencia->free();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordenação | Início</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', Arial, sans-serif;
            background: #f6f7fb;
            color: #1f2937;
        }
        nav { background: #1b2d4d; }
        main {
            max-width: 1220px;
            margin: 32px auto;
            padding: 0 20px 40px;
        }
        .topo {
            background: #fff; border: 1px solid #e7e8ef;
            color: #1b1b2c;
            border-radius: 18px;
            padding: 30px 28px;
            margin-bottom: 26px;
        }
        .topo h1 { margin: 0; font-size: 2rem; }
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
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
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
            color: #6d4acb;
        }
        .grid {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: 22px;
        }
        .panel {
            background: #fff;
            border-radius: 18px;
            padding: 22px;
            border: 1px solid #e5ebf6;
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.04);
        }
        .panel h2 {
            margin-top: 0;
            color: #242238;
        }
        .lista { list-style: none; margin: 0; padding: 0; }
        .lista li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #edf2f9;
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
        .alerta {
            background: #fff7e8;
            color: #996000;
        }
        .topo p { margin: 10px 0 0; color: #737487; font-size: .94rem; }
        .topo h1 { font-size: 1.6rem; letter-spacing: -.04em; }
        .painel { gap: 14px; }
        .box, .panel { box-shadow: 0 3px 15px rgba(26,25,49,.025); border-color: #e8e8f0; }
        .box .titulo { text-transform: none; letter-spacing: 0; font-weight: 600; }
        .panel h2 { font-size: 1.13rem; letter-spacing: -.025em; margin-bottom: 6px; }
        .panel .sub { color: #7b7c8e; font-size: .85rem; margin: 0 0 18px; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: .89rem; }
        th { color: #797a8b; font-weight: 600; font-size: .78rem; padding: 13px 10px; border-bottom: 1px solid #e9e9f0; white-space: nowrap; }
        td { padding: 16px 10px; border-bottom: 1px solid #f0f0f4; }
        tr:last-child td { border-bottom: 0; }
        .turma-nome { font-weight: 700; color: #25253b; }
        .muted { color: #858597; }
        .pill { display: inline-block; background: #f0eaff; color: #6948b8; border-radius: 8px; padding: 6px 9px; font-weight: 700; }
        .hint { background: #f7f4ff; color: #65557e; padding: 13px 15px; border-radius: 11px; font-size: .84rem; line-height: 1.6; margin-top: 15px; }
        .empty { color: #858597; padding: 22px 8px; text-align: center; }
        .quicklinks { display: grid; gap: 10px; }
        .quicklinks a { display: flex; justify-content: space-between; gap: 12px; padding: 14px 15px; text-decoration: none; color: #3e365e; font-weight: 600; background: #faf9fe; border: 1px solid #ece8f7; border-radius: 11px; }
        .quicklinks a:hover { border-color: #b6a2ec; background: #f4efff; }
        .quicklinks span { color: #876ac9; }
        @media (max-width: 900px) { .grid { grid-template-columns: 1fr; } }
        @media (max-width: 560px) { main { padding: 0 14px 30px; margin-top: 20px; } .topo { padding: 23px 20px; } .painel { grid-template-columns: repeat(2,minmax(0,1fr)); } .box { padding: 16px; } .box .valor { font-size: 1.55rem; } }
    </style>
</head>
<body>
    <?php include "../../includes/menu_coordenacao.php"; ?>

    <main>
        <section class="topo">
            <h1>Visão pedagógica</h1>
            <p>Acompanhe os dados das turmas e acesse as consultas da coordenação.</p>
        </section>

        <section class="painel">
            <div class="box">
                <div class="titulo">Alunos matriculados</div>
                <div class="valor"><?php echo number_format($total_alunos, 0, ',', '.'); ?></div>
            </div>
            <div class="box">
                <div class="titulo">Professores</div>
                <div class="valor"><?php echo number_format($total_professores, 0, ',', '.'); ?></div>
            </div>
            <div class="box">
                <div class="titulo">Turmas ativas</div>
                <div class="valor"><?php echo number_format($total_turmas, 0, ',', '.'); ?></div>
            </div>
            <div class="box">
                <div class="titulo">Frequência geral</div>
                <div class="valor"><?php echo $frequencia_real === null ? "—" : number_format((float)$frequencia_real, 1, ",", ".") . "%"; ?></div>
            </div>
        </section>

        <section class="grid" aria-label="Acompanhamento pedagógico">
            <div class="panel">
                <h2>Desempenho das turmas</h2>
                <p class="sub">Média das notas lançadas e presença registrada por turma.</p>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>Turma</th><th>Alunos</th><th>Média das notas</th><th>Presença</th></tr></thead>
                        <tbody>
                        <?php if (!$turmas_pedagogicas): ?>
                            <tr><td colspan="4" class="empty">Nenhuma turma cadastrada.</td></tr>
                        <?php else: foreach ($turmas_pedagogicas as $turma): ?>
                            <tr>
                                <td><span class="turma-nome"><?php echo htmlspecialchars($turma['nome'], ENT_QUOTES, 'UTF-8'); ?></span><br><small class="muted"><?php echo htmlspecialchars((string)$turma['ano_letivo'], ENT_QUOTES, 'UTF-8'); ?></small></td>
                                <td><?php echo (int)$turma['matriculados']; ?></td>
                                <td><?php echo $turma['media_notas'] === null ? '<span class="muted">Sem notas</span>' : '<span class="pill">' . number_format((float)$turma['media_notas'], 2, ',', '.') . '</span>'; ?></td>
                                <td><?php echo $turma['frequencia'] === null ? '<span class="muted">Sem registros</span>' : number_format((float)$turma['frequencia'], 1, ',', '.') . '%'; ?></td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="hint">Os valores consideram somente notas e presenças já registradas no sistema. A média é calculada por lançamento de nota; não representa necessariamente a média final do boletim.</div>
            </div>
            <div class="panel">
                <h2>Acesso rápido</h2>
                <p class="sub">Consulte os registros e converse com a comunidade escolar.</p>
                <div class="quicklinks">
                    <a href="alunos_coordenacao.php">Consultar alunos <span>↗</span></a>
                    <a href="professores_coordenacao.php">Consultar professores <span>↗</span></a>
                    <a href="mensagens_coordenacao.php">Mensagens <span>↗</span></a>
                </div>
                <div class="hint">A coordenação acompanha os dados pedagógicos. Cadastros e matrículas continuam sob responsabilidade da secretaria.</div>
            </div>
        </section>
    </main>
</body>
</html>
