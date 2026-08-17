<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria | Excluir</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f2f6fb;
            color: #1d2b3a;
        }
        nav { background: #0b1f3a; }
        main {
            max-width: 1100px;
            margin: 32px auto;
            padding: 0 20px 40px;
        }
        .header {
            background: linear-gradient(135deg, #0d3d70, #1d8ec6);
            color: white;
            border-radius: 18px;
            padding: 26px 28px;
            margin-bottom: 24px;
        }
        .header h1 { margin: 0; font-size: 2rem; }
        .table {
            background: white;
            border: 1px solid #e4ebf6;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.04);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 16px 18px;
            text-align: left;
            border-bottom: 1px solid #edf2f9;
        }
        th {
            background: #eff5ff;
            color: #133b6d;
            font-size: 0.82rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        .tag {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: bold;
            background: #eaf7ef;
            color: #157c3d;
        }
        .danger {
            border: none;
            background: #fbe9ea;
            color: #b3262f;
            border-radius: 10px;
            padding: 10px 14px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include "../../includes/menu_secretaria.php"; ?>

    <main>
        <section class="header">
            <h1>Excluir registros</h1>
        </section>

        <section class="table">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Turma / Disciplina</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>João Miguel Cavalcante</td>
                        <td>Aluno</td>
                        <td>1°A</td>
                        <td><span class="tag">Ativo</span></td>
                        <td><button class="danger">Excluir</button></td>
                    </tr>
                    <tr>
                        <td>Maria Eduarda Silva</td>
                        <td>Aluno</td>
                        <td>2°A</td>
                        <td><span class="tag">Ativo</span></td>
                        <td><button class="danger">Excluir</button></td>
                    </tr>
                    <tr>
                        <td>Flávia Maria Alberta</td>
                        <td>Professor</td>
                        <td>Português</td>
                        <td><span class="tag">Ativo</span></td>
                        <td><button class="danger">Excluir</button></td>
                    </tr>
                    <tr>
                        <td>3°C</td>
                        <td>Turma</td>
                        <td>Ensino Médio</td>
                        <td><span class="tag">Aberta</span></td>
                        <td><button class="danger">Excluir</button></td>
                    </tr>
                    <tr>
                        <td>Física</td>
                        <td>Disciplina</td>
                        <td>3°A / 3°B</td>
                        <td><span class="tag">Autorizada</span></td>
                        <td><button class="danger">Excluir</button></td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
