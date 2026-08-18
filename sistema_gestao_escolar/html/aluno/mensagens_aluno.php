<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aluno | Mensagens</title>
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
        .vermelho { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <?php include '../../includes/menu_aluno.php'; ?>
    <main>
        <section class="topo">
            <h1>Mensagens</h1>
            <p>Caixa de entrada — comunicados e mensagens recebidas</p>
        </section>
        <div class="panel">
            <h2>Caixa de Entrada</h2>
            <table>
                <thead><tr><th>Remetente</th><th>Assunto</th><th>Data</th><th>Situação</th></tr></thead>
                <tbody>
                    <tr><td><strong>Profa. Maria Pereira</strong></td><td>Prova de Matemática — semana que vem</td><td>03/08/2026</td><td><span class="badge vermelho">Não lida</span></td></tr>
                    <tr><td><strong>Secretaria</strong></td><td>Reunião de pais e mestres — 10/08</td><td>01/08/2026</td><td><span class="badge vermelho">Não lida</span></td></tr>
                    <tr><td>Profa. Maria Pereira</td><td>Trabalho em grupo — instruções</td><td>28/07/2026</td><td><span class="badge verde">Lida</span></td></tr>
                    <tr><td>Coordenação</td><td>Aviso sobre o calendário escolar</td><td>25/07/2026</td><td><span class="badge verde">Lida</span></td></tr>
                    <tr><td>Secretaria</td><td>Documentos pendentes</td><td>20/07/2026</td><td><span class="badge verde">Lida</span></td></tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>