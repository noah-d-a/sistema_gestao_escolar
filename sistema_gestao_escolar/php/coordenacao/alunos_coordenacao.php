<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordenação | Alunos</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #1f2937;
        }
        nav { background: #1b2d4d; }
        main {
            max-width: 1100px;
            margin: 32px auto;
            padding: 0 20px 40px;
        }
        .header {
            background: linear-gradient(135deg, #1a3f75, #4270b6);
            color: white;
            border-radius: 18px;
            padding: 26px 28px;
            margin-bottom: 24px;
        }
        .header h1 { margin: 0; font-size: 2rem; }
        .card-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 18px;
        }
        .aluno {
            background: white;
            padding: 18px 20px;
            border-radius: 16px;
            border: 1px solid #e1eaf7;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
        }
        .nome {
            font-size: 1.1rem;
            font-weight: bold;
            color: #123d70;
            margin-bottom: 8px;
        }
        .dados {
            color: #58677a;
            line-height: 1.6;
            font-size: 0.92rem;
        }
        .badge {
            display: inline-block;
            margin-top: 10px;
            padding: 6px 10px;
            border-radius: 999px;
            background: #edf5ff;
            color: #0d4a8f;
            font-weight: bold;
            font-size: 0.72rem;
        }
    </style>
</head>
<body>
    <?php include "../../includes/menu_coordenacao.php"; ?>

    <main>
        <section class="header">
            <h1>Alunos</h1>
        </section>

        <section class="card-list">
            <article class="aluno">
                <div class="nome">João Miguel Cavalcante</div>
                <div class="dados">RM: 24218<br>Turma: 1°A<br>Frequência: 97%<br>Nota média: 8,6</div>
                <span class="badge">Ativo</span>
            </article>

            <article class="aluno">
                <div class="nome">Maria Eduarda Silva</div>
                <div class="dados">RM: 24227<br>Turma: 1°A<br>Frequência: 95%<br>Nota média: 8,9</div>
                <span class="badge">Ativo</span>
            </article>

            <article class="aluno">
                <div class="nome">Pedro Henrique Oliveira</div>
                <div class="dados">RM: 24233<br>Turma: 2°A<br>Frequência: 93%<br>Nota média: 7,8</div>
                <span class="badge">Ativo</span>
            </article>

            <article class="aluno">
                <div class="nome">Ana Clara Santos</div>
                <div class="dados">RM: 24249<br>Turma: 3°B<br>Frequência: 96%<br>Nota média: 9,1</div>
                <span class="badge">Ativo</span>
            </article>
        </section>
    </main>
</body>
</html>
