<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SGE - Presença</title>
    <link rel="stylesheet" href="../../css/padronizacao.css"/>
</head>
<body>
    <?php include '../../includes/menu_professor.php'; ?>
    <main>
        <h1>Presença dos Alunos</h1>
        <p>Acompanhe a frequência por turma e disciplina</p>

        <div class="tabela">
            <h2>Frequência — 3º Ano A · Matemática</h2>
            <table>
                <thead>
                    <tr>
                        <th>RM</th>
                        <th>Aluno</th>
                        <th>Presenças</th>
                        <th>Faltas</th>
                        <th>Total</th>
                        <th>Frequência</th>
                        <th>Situação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>2023001</td><td>Ana Lima</td><td>28</td><td>2</td><td>30</td><td>93%</td><td><span style="background:#dcfce7;color:#166534;padding:2px 8px;border-radius:3px;font-size:0.72rem;font-weight:600;">Regular</span></td></tr>
                    <tr><td>2023002</td><td>Carlos Souza</td><td>20</td><td>10</td><td>30</td><td>67%</td><td><span style="background:#fee2e2;color:#991b1b;padding:2px 8px;border-radius:3px;font-size:0.72rem;font-weight:600;">Risco</span></td></tr>
                    <tr><td>2023003</td><td>Beatriz Costa</td><td>27</td><td>3</td><td>30</td><td>90%</td><td><span style="background:#dcfce7;color:#166534;padding:2px 8px;border-radius:3px;font-size:0.72rem;font-weight:600;">Regular</span></td></tr>
                    <tr><td>2023004</td><td>Rafael Torres</td><td>24</td><td>6</td><td>30</td><td>80%</td><td><span style="background:#fef9c3;color:#854d0e;padding:2px 8px;border-radius:3px;font-size:0.72rem;font-weight:600;">Atenção</span></td></tr>
                    <tr><td>2023005</td><td>Juliana Neves</td><td>30</td><td>0</td><td>30</td><td>100%</td><td><span style="background:#dcfce7;color:#166534;padding:2px 8px;border-radius:3px;font-size:0.72rem;font-weight:600;">Regular</span></td></tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>