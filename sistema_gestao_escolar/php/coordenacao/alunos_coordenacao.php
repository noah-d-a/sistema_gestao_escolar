<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Coordenação');

$id_turma = intval($_GET['turma'] ?? $_POST['turma'] ?? 0);

// Buscar turmas
$turmas = [];
$sql = "SELECT id_turma, nome FROM turma ORDER BY nome";
$stmt = $conexao->prepare($sql);
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
    
    $sql = "SELECT m.rm, u.nome, u.id_usuario,
                   AVG(n.nota) as media_notas,
                   CASE 
                       WHEN COUNT(DISTINCT f.data_aula) = 0 THEN 100
                       ELSE ROUND(SUM(CASE WHEN f.presente = 1 THEN 1 ELSE 0 END) / COUNT(DISTINCT f.data_aula) * 100)
                   END as frequencia_perc
            FROM matricula m
            JOIN usuario u ON m.id_aluno = u.id_usuario
            LEFT JOIN nota n ON m.id_matricula = n.id_matricula
            LEFT JOIN frequencia f ON m.id_matricula = f.id_matricula
            WHERE m.id_turma = ?
            GROUP BY m.id_matricula, m.rm, u.nome, u.id_usuario
            ORDER BY u.nome";
    
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_turma);
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
    <title>Coordenação | Alunos</title>
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
            max-width: 1100px;
            margin: 32px auto;
            padding: 0 20px 40px;
        }
        .header {
            background: linear-gradient(135deg, #1a3f75, #4270b6);
            color: white;
            border-radius: 18px;
            padding: 26px 28px;
            margin-bottom: 24px;
        }
        .header h1 { margin: 0; font-size: 2rem; }
        .card-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 18px;
        }
        .aluno {
            background: white;
            padding: 18px 20px;
            border-radius: 16px;
            border: 1px solid #e1eaf7;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
        }
        .nome {
            font-size: 1.1rem;
            font-weight: bold;
            color: #123d70;
            margin-bottom: 8px;
        }
        .dados {
            color: #58677a;
            line-height: 1.6;
            font-size: 0.92rem;
        }
        .badge {
            display: inline-block;
            margin-top: 10px;
            padding: 6px 10px;
            border-radius: 999px;
            background: #edf5ff;
            color: #0d4a8f;
            font-weight: bold;
            font-size: 0.72rem;
        }
    </style>
</head>
<body>
    <?php include "../../includes/menu_coordenacao.php"; ?>

    <main>
        <section class="header">
            <h1>Alunos<?php echo $id_turma > 0 ? ' — ' . htmlspecialchars($turma_nome) : ''; ?></h1>
        </section>
        
        <div style="margin-bottom: 20px;">
            <form method="GET">
                <label style="font-size: 0.78rem; font-weight: bold; display: block; margin-bottom: 4px;">Filtrar por turma</label>
                <select name="turma" onchange="this.form.submit();" style="border: 1px solid #dfe9f6; border-radius: 8px; padding: 8px 12px; font-size: 0.84rem; width: 250px;">
                    <option value="">Selecione uma turma</option>
                    <?php foreach ($turmas as $turma): ?>
                        <option value="<?php echo $turma['id_turma']; ?>" <?php echo $id_turma == $turma['id_turma'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($turma['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>

        <?php if ($id_turma > 0 && count($alunos) > 0): ?>
            <section class="card-list">
                <?php foreach ($alunos as $aluno): ?>
                    <article class="aluno">
                        <div class="nome"><?php echo htmlspecialchars($aluno['nome']); ?></div>
                        <div class="dados">
                            RM: <?php echo htmlspecialchars($aluno['rm']); ?><br>
                            Turma: <?php echo htmlspecialchars($turma_nome); ?><br>
                            Frequência: <?php echo round($aluno['frequencia_perc'] ?? 0); ?>%<br>
                            Nota média: <?php echo round($aluno['media_notas'] ?? 0, 1); ?>
                        </div>
                        <span class="badge">Ativo</span>
                    </article>
                <?php endforeach; ?>
            </section>
        <?php elseif ($id_turma > 0): ?>
            <p style="color: #666;">Nenhum aluno encontrado nesta turma.</p>
        <?php endif; ?>
    </main>
</body>
</html>
