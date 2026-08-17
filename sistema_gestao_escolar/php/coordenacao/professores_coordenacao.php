<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordenação | Professores</title>
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
            background: linear-gradient(135deg, #1f3b65, #4e6aa8);
            color: white;
            border-radius: 18px;
            padding: 26px 28px;
            margin-bottom: 24px;
        }
        .header h1 { margin: 0; font-size: 2rem; }
        .lista {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 18px;
        }
        .professor {
            background: white;
            border-radius: 16px;
            border: 1px solid #e1eaf7;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
            padding: 18px 20px;
        }
        .nome {
            font-size: 1.1rem;
            color: #123d70;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .dados {
            color: #58677a;
            line-height: 1.6;
            font-size: 0.92rem;
        }
    </style>
</head>
<body>
    <?php include "../../includes/menu_coordenacao.php"; ?>

    <main>
        <section class="header">
            <h1>Professores</h1>
        </section>

        <section class="lista">
            <article class="professor">
                <div class="nome">Maria da Silva Santana</div>
                <div class="dados">Disciplina: Português<br>Turma: 1°A e 2°A<br>Horário: 08:00 às 10:30</div>
            </article>

            <article class="professor">
                <div class="nome">Alberto Adriano Antunes</div>
                <div class="dados">Disciplina: Matemática<br>Turma: 2°A e 3°B<br>Horário: 10:40 às 12:10</div>
            </article>

            <article class="professor">
                <div class="nome">Flávia Maria Alberta</div>
                <div class="dados">Disciplina: História<br>Turma: 1°B e 3°A<br>Horário: 13:00 às 15:00</div>
            </article>

            <article class="professor">
                <div class="nome">Gabriel Santos Silva</div>
                <div class="dados">Disciplina: Física<br>Turma: 3°B<br>Horário: 15:10 às 16:30</div>
            </article>
        </section>
    </main>
</body>
</html>
