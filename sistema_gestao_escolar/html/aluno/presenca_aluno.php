<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SGE - Presença</title>

    <link rel="stylesheet" href="../../css/padronizacao.css"/>
</head>
<body>

    <?php include '../../includes/menu_aluno.php'; ?>

    <main>
        <h1>Presença</h1>
        <p>Acompanhe sua frequência por disciplina.</p>

        <div class="tabela">
            <table>
                <thead>
                    <tr>
                        <th>Disciplina</th>
                        <th>Presenças</th>
                        <th>Faltas</th>
                        <th>Total de Aulas</th>
                        <th>Frequência</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Matemática</td><td>28</td><td>2</td><td>30</td><td>93%</td></tr>
                    <tr><td>Português</td><td>30</td><td>0</td><td>30</td><td>100%</td></tr>
                    <tr><td>História</td><td>24</td><td>6</td><td>30</td><td>80%</td></tr>
                    <tr><td>Física</td><td>27</td><td>3</td><td>30</td><td>90%</td></tr>
                    <tr><td>Química</td><td>20</td><td>10</td><td>30</td><td>67%</td></tr>
                    <tr><td>Biologia</td><td>26</td><td>4</td><td>30</td><td>87%</td></tr>
                </tbody>
            </table>
        </div>

    </main>

</body>
</html>
