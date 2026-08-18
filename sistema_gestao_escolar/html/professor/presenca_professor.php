<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor | Presença</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #1f2937; }
        main { max-width: 1180px; margin: 32px auto; padding: 0 20px 40px; }
        .topo { background: linear-gradient(135deg, #1f3b65, #4568a8); color: white; border-radius: 18px; padding: 30px 28px; margin-bottom: 26px; }
        .topo h1 { margin: 0 0 4px; font-size: 2rem; }
        .topo p { margin: 0; font-size: 0.9rem; opacity: 0.8; }
        .panel { background: #fff; border-radius: 18px; padding: 22px; border: 1px solid #e5ebf6; box-shadow: 0 10px 22px rgba(15,23,42,0.04); margin-bottom: 22px; }
        .panel h2 { margin-top: 0; color: #133b6d; }
        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        thead th { text-align: left; padding: 10px 12px; font-size: 0.75rem; color: #6b7280; border-bottom: 1px solid #edf2f9; text-transform: uppercase; }
        tbody td { padding: 12px; border-bottom: 1px solid #edf2f9; color: #374151; }
        tbody tr:last-child td { border-bottom: none; }
        .badge { padding: 4px 10px; border-radius: 999px; font-size: 0.75rem; font-weight: bold; }
        .verde { background: #eaf7ef; color: #157c3d; }
        .amarelo { background: #fff7e8; color: #996000; }
        .vermelho { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <?php include '../../includes/menu_professor.php'; ?>
    <main>
        <section class="topo">
            <h1>Presença dos Alunos</h1>
            <p>Acompanhe a frequência por turma e disciplina</p>
        </section>
        <div class="panel">
            <h2>Frequência — 3º Ano A · Matemática</h2>
            <table>
                <thead><tr><th>RM</th><th>Aluno</th><th>Presenças</th><th>Faltas</th><th>Total</th><th>Frequência</th><th>Situação</th></tr></thead>
                <tbody>
                    <tr><td>2023001</td><td>Ana Lima</td><td>28</td><td>2</td><td>30</td><td>93%</td><td><span class="badge verde">Regular</span></td></tr>
                    <tr><td>2023002</td><td>Carlos Souza</td><td>20</td><td>10</td><td>30</td><td>67%</td><td><span class="badge vermelho">Risco</span></td></tr>
                    <tr><td>2023003</td><td>Beatriz Costa</td><td>27</td><td>3</td><td>30</td><td>90%</td><td><span class="badge verde">Regular</span></td></tr>
                    <tr><td>2023004</td><td>Rafael Torres</td><td>24</td><td>6</td><td>30</td><td>80%</td><td><span class="badge amarelo">Atenção</span></td></tr>
                    <tr><td>2023005</td><td>Juliana Neves</td><td>30</td><td>0</td><td>30</td><td>100%</td><td><span class="badge verde">Regular</span></td></tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>