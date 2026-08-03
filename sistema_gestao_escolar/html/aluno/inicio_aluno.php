<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SGE - Aluno</title>

    <link rel="stylesheet" href="../../css/padronizacao.css"/>
</head>
<body>

    <?php include '../../includes/menu_aluno.php'; ?>

    <main>
        <h1>Bem-vindo, Aluno!</h1>
        <p>Acompanhe seu desempenho - ano letivo 2026.</p>

        
        <div class="cards">
            <div class="card">
                <h3>Média Geral</h3>
                <span>8.4</span>
            </div>
            <div class="card">
                <h3>Frequência</h3>
                <span>92%</span>
            </div>
            <div class="card">
                <h3>Faltas</h3>
                <span>4</span>
            </div>
            <div class="card">
                <h3>Questionários Pendentes</h3>
                <span>2</span>
            </div>
        </div>

    
        <div class="tabela">
            <h2>Notas Recentes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Disciplina</th>
                        <th>Avaliação</th>
                        <th>Nota</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Matemática</td><td>Prova 1</td><td>9.0</td></tr>
                    <tr><td>Português</td><td>Trabalho</td><td>7.5</td></tr>
                    <tr><td>História</td><td>Prova 1</td><td>5.0</td></tr>
                    <tr><td>Física</td><td>Prova 1</td><td>8.8</td></tr>
                    <tr><td>Química</td><td>Lab 1</td><td>6.0</td></tr>
                </tbody>
            </table>
        </div>

    </main>

</body>
</html>
