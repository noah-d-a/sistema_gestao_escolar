<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aluno | Boletim</title>
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
        .panel h2 { margin-top: 0; color: #133b6d; display: flex; justify-content: space-between; align-items: center; }
        select { border: 1px solid #dfe9f6; border-radius: 8px; padding: 6px 12px; font-size: 0.84rem; color: #374151; outline: none; }
        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        thead th { text-align: left; padding: 10px 12px; font-size: 0.75rem; color: #6b7280; border-bottom: 1px solid #edf2f9; text-transform: uppercase; letter-spacing: 0.05em; }
        tbody td { padding: 12px; border-bottom: 1px solid #edf2f9; color: #374151; }
        tbody tr:last-child td { border-bottom: none; }
        .badge { padding: 4px 10px; border-radius: 999px; font-size: 0.75rem; font-weight: bold; }
        .verde { background: #eaf7ef; color: #157c3d; }
        .amarelo { background: #fff7e8; color: #996000; }
        .rodape { font-size: 0.75rem; color: #9ca3af; margin-top: 14px; border-top: 1px solid #edf2f9; padding-top: 10px; }
    </style>
</head>
<body>
    <?php include '../../includes/menu_aluno.php'; ?>
    <main>
        <section class="topo">
            <h1>Boletim</h1>
            <p>Confira suas notas por disciplina — ano letivo 2026</p>
        </section>

        <section class="painel">
            <div class="box"><div class="titulo">Média Geral</div><div class="valor">7.6</div></div>
            <div class="box"><div class="titulo">Aprovado</div><div class="valor">4</div></div>
            <div class="box"><div class="titulo">Recuperação</div><div class="valor">2</div></div>
            <div class="box"><div class="titulo">Reprovado</div><div class="valor">0</div></div>
        </section>

        <div class="panel">
            <h2>Notas por Disciplina
                <select id="bimestre" onchange="trocarBimestre()">
                    <option value="1">1º Bimestre</option>
                    <option value="2" selected>2º Bimestre</option>
                    <option value="3" disabled>3º Bimestre — Em breve</option>
                    <option value="4" disabled>4º Bimestre — Em breve</option>
                </select>
            </h2>
            <table>
                <thead>
                    <tr><th>Disciplina</th><th>Professor</th><th>Prova 1</th><th>Prova 2</th><th>Trabalho</th><th>Média</th><th>Situação</th></tr>
                </thead>
                <tbody>
                    <tr><td>Matemática</td><td>Prof. Carlos Lima</td><td>9.0</td><td>8.5</td><td>8.0</td><td><strong>8.5</strong></td><td><span class="badge verde">Aprovado</span></td></tr>
                    <tr><td>Português</td><td>Profa. Ana Souza</td><td>7.5</td><td>8.0</td><td>7.0</td><td><strong>7.5</strong></td><td><span class="badge verde">Aprovado</span></td></tr>
                    <tr><td>História</td><td>Prof. Roberto Dias</td><td>5.0</td><td>4.5</td><td>6.0</td><td><strong>5.2</strong></td><td><span class="badge amarelo">Recuperação</span></td></tr>
                    <tr><td>Física</td><td>Profa. Maria Pereira</td><td>8.8</td><td>9.0</td><td>8.5</td><td><strong>8.8</strong></td><td><span class="badge verde">Aprovado</span></td></tr>
                    <tr><td>Química</td><td>Prof. João Ferreira</td><td>6.0</td><td>5.5</td><td>6.5</td><td><strong>6.0</strong></td><td><span class="badge amarelo">Recuperação</span></td></tr>
                    <tr><td>Biologia</td><td>Profa. Sandra Costa</td><td>7.0</td><td>7.5</td><td>8.0</td><td><strong>7.5</strong></td><td><span class="badge verde">Aprovado</span></td></tr>
                </tbody>
            </table>
            <p class="rodape">* Nota mínima para aprovação: 6.0 | Mínimo para recuperação: 4.0</p>
        </div>
    </main>
    <script>
        function trocarBimestre() {
            const b = document.getElementById('bimestre').value;
            document.querySelector('.panel h2').childNodes[0].textContent = 'Notas por Disciplina — ' + b + 'º Bimestre ';
        }
    </script>
</body>
</html>