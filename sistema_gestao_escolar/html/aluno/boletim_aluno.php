<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SGE - Boletim</title>

    <link rel="stylesheet" href="../../css/padronizacao.css"/>
</head>
<body>

    <?php include '../../includes/menu_aluno.php'; ?>

    <main>
        <h1>Boletim</h1>
        <p>Confira suas notas por disciplina.</p>

        <div class="tabela">
            <table>
                <thead>
                    <tr>
                        <th>Disciplina</th>
                        <th>Prova 1</th>
                        <th>Prova 2</th>
                        <th>Trabalho</th>
                        <th>Média</th>
                        <th>Situação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Matemática</td><td>9.0</td><td>8.5</td><td>8.0</td><td>8.5</td><td>Aprovado</td></tr>
                    <tr><td>Português</td><td>7.5</td><td>8.0</td><td>7.0</td><td>7.5</td><td>Aprovado</td></tr>
                    <tr><td>História</td><td>5.0</td><td>4.5</td><td>6.0</td><td>5.2</td><td>Recuperação</td></tr>
                    <tr><td>Física</td><td>8.8</td><td>9.0</td><td>8.5</td><td>8.8</td><td>Aprovado</td></tr>
                    <tr><td>Química</td><td>6.0</td><td>5.5</td><td>6.5</td><td>6.0</td><td>Recuperação</td></tr>
                    <tr><td>Biologia</td><td>7.0</td><td>7.5</td><td>8.0</td><td>7.5</td><td>Aprovado</td></tr>
                </tbody>
            </table>
        </div>

    </main>

</body>
</html>
