<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Secretaria');

$turma_filtro = isset($_GET['turma']) ? intval($_GET['turma']) : 0;
$pesquisa = isset($_GET['q']) ? trim($_GET['q']) : '';

$turmas_lista = [];
$sql = 'SELECT id_turma, nome FROM turma ORDER BY nome';
$stmt = $conexao->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $turmas_lista[] = $row;
}
$stmt->close();

$alunos = [];
$search_param = "%$pesquisa%";
if ($turma_filtro > 0) {
    $sql = "SELECT m.id_matricula, m.rm, u.id_usuario, u.nome, t.nome AS turma_nome,
                   ROUND(COALESCE(SUM(CASE WHEN f.presente = 1 THEN 1 ELSE 0 END), 0) / NULLIF(COUNT(f.id_frequencia), 0) * 100, 0) AS freq_pct,
                   AVG(n.nota) AS media_notas
            FROM matricula m
            JOIN usuario u ON m.id_aluno = u.id_usuario
            JOIN turma t ON m.id_turma = t.id_turma
            LEFT JOIN frequencia f ON m.id_matricula = f.id_matricula
            LEFT JOIN nota n ON m.id_matricula = n.id_matricula
            WHERE m.id_turma = ? AND u.ativo = 1 AND u.nome LIKE ?
            GROUP BY m.id_matricula, m.rm, u.id_usuario, u.nome, t.nome
            ORDER BY u.nome";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('is', $turma_filtro, $search_param);
} else {
    $sql = "SELECT m.id_matricula, m.rm, u.id_usuario, u.nome, t.nome AS turma_nome,
                   ROUND(COALESCE(SUM(CASE WHEN f.presente = 1 THEN 1 ELSE 0 END), 0) / NULLIF(COUNT(f.id_frequencia), 0) * 100, 0) AS freq_pct,
                   AVG(n.nota) AS media_notas
            FROM matricula m
            JOIN usuario u ON m.id_aluno = u.id_usuario
            JOIN turma t ON m.id_turma = t.id_turma
            LEFT JOIN frequencia f ON m.id_matricula = f.id_matricula
            LEFT JOIN nota n ON m.id_matricula = n.id_matricula
            WHERE u.ativo = 1 AND u.nome LIKE ?
            GROUP BY m.id_matricula, m.rm, u.id_usuario, u.nome, t.nome
            ORDER BY u.nome";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('s', $search_param);
}

$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $alunos[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria | Alunos</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #1f2937; }
        nav { background: #0b1f3a; }
        main { max-width: 1100px; margin: 32px auto; padding: 0 20px 40px; }
        .header { background: linear-gradient(135deg, #103b6e, #1f8ad9); color: white; border-radius: 18px; padding: 28px 30px; margin-bottom: 24px; }
        .header h1 { margin: 0; font-size: 2rem; }
        .filtros { background: white; border-radius: 14px; padding: 18px 20px; margin-bottom: 22px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); display: flex; gap: 12px; align-items: flex-end; }
        .filtros label { font-size: 0.78rem; font-weight: bold; color: #26405d; display: block; }
        .filtros select, .filtros input { padding: 8px 11px; border: 1px solid #dce5f0; border-radius: 8px; font-size: 0.85rem; }
        .filtros button { background: #0d4a8f; color: #fff; border: none; border-radius: 8px; padding: 8px 18px; cursor: pointer; font-weight: bold; }
        .lista { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 18px; }
        .aluno { background: white; border: 1px solid #e3ebf7; border-radius: 16px; padding: 18px 20px; box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04); transition: all 0.3s; }
        .aluno:hover { box-shadow: 0 12px 28px rgba(15,23,42,0.12); transform: translateY(-2px); }
        .nome { font-size: 1.05rem; font-weight: bold; color: #113d70; margin-bottom: 10px; }
        .dados { color: #5c6878; line-height: 1.7; font-size: 0.85rem; }
    </style>
</head>
<body>
    <?php include '../../includes/menu_secretaria.php'; ?>

    <main>
        <section class="header">
            <h1>Consultar Alunos</h1>
        </section>

        <div class="filtros">
            <form method="GET" style="display: flex; gap: 12px; width: 100%; align-items: flex-end;">
                <div style="flex: 1; min-width: 200px;">
                    <label>Turma</label>
                    <select name="turma" onchange="this.form.submit();">
                        <option value="">Todas as turmas</option>
                        <?php foreach ($turmas_lista as $t): ?>
                            <option value="<?php echo $t['id_turma']; ?>" <?php echo $turma_filtro == $t['id_turma'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($t['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="flex: 1; min-width: 180px;">
                    <label>Buscar por nome</label>
                    <input type="text" name="q" placeholder="Digite o nome..." value="<?php echo htmlspecialchars($pesquisa); ?>" />
                </div>
                <button type="submit">Buscar</button>
            </form>
        </div>

        <?php if (count($alunos) > 0): ?>
            <section class="lista">
                <?php foreach ($alunos as $aluno): ?>
                    <article class="aluno">
                        <div class="nome"><?php echo htmlspecialchars($aluno['nome']); ?></div>
                        <div class="dados">
                            <strong>RM:</strong> <?php echo htmlspecialchars($aluno['rm']); ?><br>
                            <strong>Turma:</strong> <?php echo htmlspecialchars($aluno['turma_nome']); ?><br>
                            <strong>Frequência:</strong> <?php echo number_format((float)($aluno['freq_pct'] ?? 0), 0); ?>%<br>
                            <strong>Média:</strong> <?php echo number_format((float)($aluno['media_notas'] ?? 0), 1, ',', '.'); ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        <?php else: ?>
            <div style="background: #fff; padding: 40px; text-align: center; border-radius: 14px; color: #666;">
                <p>Nenhum aluno encontrado. Selecione uma turma ou refine sua busca.</p>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>


                    <li>
                        <a href='consulta_secretaria.php?id=213&vitima=$vitima'>
                            Matheus Ribeiro Ferreira
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=214&vitima=$vitima'>
                            Gabriela Santos Rocha
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=215&vitima=$vitima'>
                            Eduardo Almeida Costa
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=216&vitima=$vitima'>
                            Beatriz Ferreira Soares
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=217&vitima=$vitima'>
                            Pedro Nascimento Alves
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=218&vitima=$vitima'>
                            Clara Martins Ribeiro
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=219&vitima=$vitima'>
                            Felipe Jesus Oliveira
                        </a>
                    </li>
                ";
            } elseif ($id == 3) {
                echo "
                    <li>
                        <a href='consulta_secretaria.php?id=300&vitima=$vitima'>
                            Ana Luiza Moreira
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=301&vitima=$vitima'>
                            Caio Henrique Barros
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=302&vitima=$vitima'>
                            Valentina Rocha Souza
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=303&vitima=$vitima'>
                            Lucas Eduardo Farias
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=304&vitima=$vitima'>
                            Giovanna Costa Lima
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=305&vitima=$vitima'>
                            Enzo Gabriel Souza
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=306&vitima=$vitima'>
                            Helena Maria Pires
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=307&vitima=$vitima'>
                            Igor da Silva
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=308&vitima=$vitima'>
                            Priscila Batista Santos
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=309&vitima=$vitima'>
                            Davi Lucas Martins
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=310&vitima=$vitima'>
                            Renata Almeida Vieira
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=311&vitima=$vitima'>
                            Samuel Nascimento Rocha
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=312&vitima=$vitima'>
                            Yasmin Ferreira Nogueira
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=313&vitima=$vitima'>
                            Pedro Lucas Cunha
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=314&vitima=$vitima'>
                            Manuela Souza Brito
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=315&vitima=$vitima'>
                            João Pedro Santos
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=316&vitima=$vitima'>
                            Letícia Ramos Monteiro
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=317&vitima=$vitima'>
                            Otávio Azevedo Rocha
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=318&vitima=$vitima'>
                            Bianca Ramos Castro
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=319&vitima=$vitima'>
                            Nicolas da Costa
                        </a>
                    </li>
                ";
            }
            ?>
        </ul>
    </main>
</body>
</html>