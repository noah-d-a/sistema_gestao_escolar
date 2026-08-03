<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SGE - Professor</title>

    <link rel="stylesheet" href="../../css/padronizacao.css"/>
</head>
<body>

    <?php include '../../includes/menu_professor.php'; ?>

    <main>
        <h1>Bem-vindo, Professor!</h1>
        <p>Acompanhe suas turmas - ano letivo 2026.</p>

        <div class="cards">
            <div class="card">
                <h3>Turmas</h3>
                <span>3</span>
            </div>
            <div class="card">
                <h3>Total de Alunos</h3>
                <span>87</span>
            </div>
            <div class="card">
                <h3>Aulas Hoje</h3>
                <span>2</span>
            </div>
            <div class="card">
                <h3>Notas Pendentes</h3>
                <span>12</span>
            </div>
        </div>

        
        <div class="tabela">
            <h2>Minhas Turmas</h2>
            <table>
                <thead>
                    <tr>
                        <th>Turma</th>
                        <th>Disciplina</th>
                        <th>Período</th>
                        <th>Alunos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>3º Ano A</td><td>Matemática</td><td>Manhã</td><td>32</td></tr>
                    <tr><td>2º Ano B</td><td>Física</td><td>Manhã</td><td>28</td></tr>
                    <tr><td>1º Ano C</td><td>Matemática</td><td>Tarde</td><td>27</td></tr>
                </tbody>
            </table>
        </div>

    </main>

</body>
</html>
