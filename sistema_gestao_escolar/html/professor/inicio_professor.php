<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor | Início</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #1f2937; }
        main { max-width: 1180px; margin: 32px auto; padding: 0 20px 40px; }
        .topo { background: linear-gradient(135deg, #1f3b65, #4568a8); color: white; border-radius: 18px; padding: 30px 28px; margin-bottom: 26px; }
        .topo h1 { margin: 0 0 4px; font-size: 2rem; }
        .topo p { margin: 0; font-size: 0.9rem; opacity: 0.8; }
        .painel { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; margin-bottom: 28px; }
        .box { background: white; padding: 20px; border-radius: 16px; border: 1px solid #dfe9f6; box-shadow: 0 8px 20px rgba(15,23,42,0.04); }
        .box .titulo { color: #6b7280; font-size: 0.82rem; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 10px; }
        .box .valor { font-size: 2rem; font-weight: bold; color: #183f73; }
        .panel { background: #fff; border-radius: 18px; padding: 22px; border: 1px solid #e5ebf6; box-shadow: 0 10px 22px rgba(15,23,42,0.04); margin-bottom: 22px; }
        .panel h2 { margin-top: 0; color: #133b6d; }
        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        thead th { text-align: left; padding: 10px 12px; font-size: 0.75rem; color: #6b7280; border-bottom: 1px solid #edf2f9; text-transform: uppercase; }
        tbody td { padding: 12px; border-bottom: 1px solid #edf2f9; color: #374151; }
        tbody tr:last-child td { border-bottom: none; }
    </style>
</head>
<body>
    <?php include '../../includes/menu_professor.php'; ?>
    <main>
        <section class="topo">
            <h1>Painel do Professor</h1>
            <p>Gerencie suas turmas e atividades — ano letivo 2026</p>
        </section>
        <section class="painel">
            <div class="box"><div class="titulo">Total de Alunos</div><div class="valor">87</div></div>
            <div class="box"><div class="titulo">Turmas Ativas</div><div class="valor">3</div></div>
            <div class="box"><div class="titulo">Aulas Hoje</div><div class="valor">2</div></div>
            <div class="box"><div class="titulo">Notas Pendentes</div><div class="valor">12</div></div>
        </section>
        <div class="panel">
            <h2>Minhas Turmas</h2>
            <table>
                <thead><tr><th>Turma</th><th>Disciplina</th><th>Período</th><th>Alunos</th><th>Média</th></tr></thead>
                <tbody>
                    <tr><td>3º Ano A</td><td>Matemática</td><td>Manhã</td><td>32</td><td>7.8</td></tr>
                    <tr><td>2º Ano B</td><td>Física</td><td>Manhã</td><td>28</td><td>6.5</td></tr>
                    <tr><td>1º Ano C</td><td>Matemática</td><td>Tarde</td><td>27</td><td>8.1</td></tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>