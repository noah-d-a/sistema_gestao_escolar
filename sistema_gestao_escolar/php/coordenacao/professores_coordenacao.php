<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Coordenação');

// Buscar professores e suas disciplinas
$sql = "SELECT DISTINCT u.id_usuario, u.nome, d.nome as disciplina, t.nome as turma, h.hora_inicio, h.hora_fim
        FROM usuario u
        LEFT JOIN turma_disciplina td ON u.id_usuario = td.id_professor
        LEFT JOIN disciplina d ON td.id_disciplina = d.id_disciplina
        LEFT JOIN turma t ON td.id_turma = t.id_turma
        LEFT JOIN horario h ON h.id_turma_disciplina = td.id_turma_disciplina
        WHERE u.perfil = 'Professor' AND u.ativo = 1
        ORDER BY u.nome, d.nome";

$stmt = $conexao->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$professores = [];
while ($row = $result->fetch_assoc()) {
    $prof_id = $row['id_usuario'];
    if (!isset($professores[$prof_id])) {
        $professores[$prof_id] = [
            'id' => $prof_id,
            'nome' => $row['nome'],
            'disciplinas' => [],
            'turmas' => [],
            'horarios' => []
        ];
    }
    
    if ($row['disciplina']) {
        if (!in_array($row['disciplina'], $professores[$prof_id]['disciplinas'])) {
            $professores[$prof_id]['disciplinas'][] = $row['disciplina'];
        }
    }
    
    if ($row['turma']) {
        if (!in_array($row['turma'], $professores[$prof_id]['turmas'])) {
            $professores[$prof_id]['turmas'][] = $row['turma'];
        }
    }
    
    if ($row['hora_inicio'] && $row['hora_fim']) {
        $horario = substr($row['hora_inicio'], 0, 5) . ' às ' . substr($row['hora_fim'], 0, 5);
        if (!in_array($horario, $professores[$prof_id]['horarios'])) {
            $professores[$prof_id]['horarios'][] = $horario;
        }
    }
}
$stmt->close();

$professores_list = array_values($professores);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordenação | Professores</title>
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
            background: linear-gradient(135deg, #1f3b65, #4e6aa8);
            color: white;
            border-radius: 18px;
            padding: 26px 28px;
            margin-bottom: 24px;
        }
        .header h1 { margin: 0; font-size: 2rem; }
        .lista {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 18px;
        }
        .professor {
            background: white;
            border-radius: 16px;
            border: 1px solid #e1eaf7;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
            padding: 18px 20px;
        }
        .nome {
            font-size: 1.1rem;
            color: #123d70;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .dados {
            color: #58677a;
            line-height: 1.6;
            font-size: 0.92rem;
        }
    </style>
</head>
<body>
    <?php include "../../includes/menu_coordenacao.php"; ?>

    <main>
        <section class="header">
            <h1>Professores</h1>
        </section>

        <?php if (count($professores_list) > 0): ?>
            <section class="lista">
                <?php foreach ($professores_list as $prof): ?>
                    <article class="professor">
                        <div class="nome"><a href="professor_coordenacao.php?id=<?php echo (int) $prof['id']; ?>" style="color: inherit; text-decoration: none;"><?php echo htmlspecialchars($prof['nome']); ?></a></div>
                        <div class="dados">
                            <?php if (count($prof['disciplinas']) > 0): ?>
                                Disciplina: <?php echo htmlspecialchars(implode(', ', array_slice($prof['disciplinas'], 0, 2))); ?><br>
                            <?php endif; ?>
                            <?php if (count($prof['turmas']) > 0): ?>
                                Turma: <?php echo htmlspecialchars(implode(', ', array_slice($prof['turmas'], 0, 3))); ?><br>
                            <?php endif; ?>
                            <?php if (count($prof['horarios']) > 0): ?>
                                Horário: <?php echo htmlspecialchars($prof['horarios'][0]); ?>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        <?php else: ?>
            <p style="color: #666;">Nenhum professor encontrado.</p>
        <?php endif; ?>
    </main>
</body>
</html>
