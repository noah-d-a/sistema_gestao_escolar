<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aluno | Presença</title>
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
        .badge { padding: 4px 10px; border-radius: 999px; font-size: 0.75rem; font-weight: bold; }
        .verde { background: #eaf7ef; color: #157c3d; }
        .amarelo { background: #fff7e8; color: #996000; }
        .vermelho { background: #fee2e2; color: #991b1b; }
        .aviso { background: #fff7e8; border-left: 4px solid #f59e0b; border-radius: 10px; padding: 14px 18px; font-size: 0.875rem; color: #92400e; margin-bottom: 22px; }
        .rodape { font-size: 0.75rem; color: #9ca3af; margin-top: 14px; border-top: 1px solid #edf2f9; padding-top: 10px; }
    </style>
</head>
<body>
    <?php include '../../includes/menu_aluno.php'; ?>
    <main>
        <section class="topo">
            <h1>Presença</h1>
            <p>Acompanhe sua frequência por disciplina — ano letivo 2026</p>
        </section>

        <section class="painel">
            <div class="box"><div class="titulo">Frequência Geral</div><div class="valor">86%</div></div>
            <div class="box"><div class="titulo">Total de Faltas</div><div class="valor">25</div></div>
            <div class="box"><div class="titulo">Em Risco</div><div class="valor">1</div></div>
            <div class="box"><div class="titulo">Regulares</div><div class="valor">5</div></div>
        </section>

        <div class="aviso">⚠ Sua frequência em <strong>Química</strong> está em <strong>67%</strong>, abaixo do mínimo exigido de 75%.</div>

        <div class="panel">
            <h2>Frequência por Disciplina</h2>
            <table>
                <thead><tr><th>Disciplina</th><th>Presenças</th><th>Faltas</th><th>Total</th><th>Frequência</th><th>Situação</th></tr></thead>
                <tbody>
                    <tr><td>Matemática</td><td>28</td><td>2</td><td>30</td><td>93%</td><td><span class="badge verde">Regular</span></td></tr>
                    <tr><td>Português</td><td>30</td><td>0</td><td>30</td><td>100%</td><td><span class="badge verde">Regular</span></td></tr>
                    <tr><td>História</td><td>24</td><td>6</td><td>30</td><td>80%</td><td><span class="badge amarelo">Atenção</span></td></tr>
                    <tr><td>Física</td><td>27</td><td>3</td><td>30</td><td>90%</td><td><span class="badge verde">Regular</span></td></tr>
                    <tr><td>Química</td><td>20</td><td>10</td><td>30</td><td>67%</td><td><span class="badge vermelho">Risco</span></td></tr>
                    <tr><td>Biologia</td><td>26</td><td>4</td><td>30</td><td>87%</td><td><span class="badge verde">Regular</span></td></tr>
                </tbody>
            </table>
            <p class="rodape">* Frequência mínima exigida: 75% | Abaixo disso o aluno fica em risco de reprovação por falta.</p>
        </div>
    </main>
</body>
</html>