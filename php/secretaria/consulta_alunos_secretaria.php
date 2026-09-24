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
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"><style>
*{box-sizing:border-box}body{margin:0;background:#f7f8fc;color:#22243a;font-family:Inter,Arial,sans-serif}main{max-width:1140px;margin:0 auto;padding:44px 36px 75px}h1,h2{letter-spacing:-.035em}a:focus-visible,button:focus-visible,input:focus-visible,select:focus-visible{outline:3px solid #aaa7f8;outline-offset:2px}.header{background:transparent!important;color:#22243a!important;border-radius:0!important;padding:0!important;margin:0 0 26px!important;box-shadow:none!important}.header:before{content:'INSTITUTO ATLAS / SECRETARIA';display:block;color:#6762d8;font-size:11px;font-weight:800;letter-spacing:.13em;margin-bottom:11px}.header h1{font-size:clamp(27px,3vw,35px);margin:0;font-weight:800;line-height:1.2}.container{background:transparent;border:0;box-shadow:none;overflow:visible}.content{padding:0}.card,.filtros,.aluno,.item{background:white;border:1px solid #e7e9f1;border-radius:15px;box-shadow:0 7px 22px rgba(25,30,70,.035)}.card{padding:26px 28px;margin-bottom:18px}.card h2{font-size:15px;color:#24263b;margin:0 0 22px;font-weight:800}.grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px}.grid>div{min-width:0}label,.filtros label{display:block;font-size:12px;font-weight:700;color:#555b72;margin-bottom:8px}input,select,.filtros input,.filtros select{width:100%;min-width:0;background:#fff;border:1px solid #dfe2ed;border-radius:9px;padding:12px 13px;font:inherit;font-size:13px;color:#282b40}input:disabled{background:#f5f6fa;color:#777d8d}input:focus,select:focus{border-color:#7771df;outline:3px solid #efedff}.actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:20px}button,.filtros button,.btn-small{font:inherit;font-size:12px;font-weight:700;border:0;border-radius:9px;padding:12px 17px;cursor:pointer;text-decoration:none;display:inline-flex;justify-content:center;align-items:center}.primary,.filtros button,.btn-edit{background:#6560d8;color:white}.primary:hover,.filtros button:hover,.btn-edit:hover{background:#524dc4}.secondary{background:#eeedff;color:#5550c1}.btn-delete{background:#fff0f1;color:#bb3648}.filtros{padding:22px 24px;margin-bottom:22px}.filtros form{flex-wrap:wrap}.filtros form>div{min-width:180px}.lista{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:15px}.aluno,.item{padding:22px;transition:border-color .15s}.aluno:hover,.item:hover{border-color:#c8c5fa}.nome{font-size:15px;font-weight:800;color:#25283c;margin-bottom:12px;overflow-wrap:anywhere}.dados,.info{font-size:12px;line-height:1.9;color:#676c7e;overflow-wrap:anywhere}.dados strong,.info strong{color:#34394d}.btn-small{flex:1;padding:10px}.actions a{min-width:85px}@media(max-width:800px){main{padding:82px 20px 45px}}@media(max-width:560px){.grid{grid-template-columns:1fr}.card{padding:20px}.filtros{padding:18px}.lista{grid-template-columns:1fr}}
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