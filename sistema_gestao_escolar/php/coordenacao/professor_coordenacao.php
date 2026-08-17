<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordenação | Professor</title>
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
            max-width: 900px;
            margin: 32px auto;
            padding: 0 20px 40px;
        }
        .card {
            background: white;
            border-radius: 18px;
            border: 1px solid #e1eaf7;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
            padding: 28px;
        }
        .titulo {
            font-size: 2rem;
            color: #123d70;
            margin-bottom: 8px;
        }
        .sub {
            color: #5d6a79;
            margin-bottom: 18px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
        }
        .bloco {
            background: #f7faff;
            border-radius: 12px;
            padding: 16px 18px;
            border: 1px solid #e3ebf7;
        }
        .label {
            font-size: 0.8rem;
            color: #4d5d72;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .valor {
            margin-top: 8px;
            font-size: 1.05rem;
            font-weight: bold;
            color: #163d68;
        }
    </style>
</head>
<body>
    <?php include "../../includes/menu_coordenacao.php"; ?>

    <main>
        <section class="card">
            <div class="titulo">Maria da Silva Santana</div>
            <div class="sub">Professora de Língua Portuguesa</div>

            <div class="grid">
                <div class="bloco">
                    <div class="label">Turmas</div>
                    <div class="valor">1°A e 2°A</div>
                </div>
                <div class="bloco">
                    <div class="label">Horário</div>
                    <div class="valor">08:00 às 10:30</div>
                </div>
                <div class="bloco">
                    <div class="label">Frequência</div>
                    <div class="valor">96%</div>
                </div>
                <div class="bloco">
                    <div class="label">Média de turma</div>
                    <div class="valor">8,7</div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
