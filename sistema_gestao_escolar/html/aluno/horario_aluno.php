<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aluno | Horário</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #1f2937; }
        main { max-width: 1180px; margin: 32px auto; padding: 0 20px 40px; }
        .topo { background: linear-gradient(135deg, #1f3b65, #4568a8); color: white; border-radius: 18px; padding: 30px 28px; margin-bottom: 26px; }
        .topo h1 { margin: 0 0 4px; font-size: 2rem; }
        .topo p { margin: 0; font-size: 0.9rem; opacity: 0.8; }
        .panel { background: #fff; border-radius: 18px; padding: 22px; border: 1px solid #e5ebf6; box-shadow: 0 10px 22px rgba(15,23,42,0.04); }
        .panel h2 { margin-top: 0; color: #133b6d; }
        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        thead th { text-align: left; padding: 10px 12px; font-size: 0.75rem; color: #6b7280; border-bottom: 1px solid #edf2f9; text-transform: uppercase; }
        tbody td { padding: 12px; border-bottom: 1px solid #edf2f9; color: #374151; }
        tbody tr:last-child td { border-bottom: none; }
        .rodape { font-size: 0.75rem; color: #9ca3af; margin-top: 14px; border-top: 1px solid #edf2f9; padding-top: 10px; }
    </style>
</head>
<body>
    <?php include '../../includes/menu_aluno.php'; ?>
    <main>
        <section class="topo">
            <h1>Horário</h1>
            <p>Grade de aulas semanal — 3º Ano A · Manhã · ano letivo 2026</p>
        </section>
        <div class="panel">
            <h2>Grade Semanal</h2>
            <table>
                <thead><tr><th>Horário</th><th>Segunda</th><th>Terça</th><th>Quarta</th><th>Quinta</th><th>Sexta</th></tr></thead>
                <tbody>
                    <tr><td><strong>07:30 - 09:10</strong></td><td>Matemática</td><td>Português</td><td>Física</td><td>História</td><td>Química</td></tr>
                    <tr><td><strong>09:10 - 10:50</strong></td><td>Português</td><td>Matemática</td><td>Biologia</td><td>Física</td><td>História</td></tr>
                    <tr><td><strong>10:50 - 12:30</strong></td><td>História</td><td>Física</td><td>Matemática</td><td>Química</td><td>Biologia</td></tr>
                </tbody>
            </table>
            <p class="rodape">* Horários sujeitos a alterações. Consulte a secretaria em caso de dúvidas.</p>
        </div>
    </main>
</body>
</html>