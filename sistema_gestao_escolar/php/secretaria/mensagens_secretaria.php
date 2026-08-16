<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria | Mensagens</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f6fb;
            color: #1f2937;
        }

        main {
            max-width: 1040px;
            margin: 32px auto;
            padding: 0 20px 40px;
        }

        .cabecalho {
            background: linear-gradient(135deg, #0d3d70, #1d8ec6);
            color: white;
            border-radius: 18px;
            padding: 26px 28px;
            margin-bottom: 24px;
        }

        .cabecalho h1 {
            margin: 0;
            font-size: 2rem;
        }

        .lista {
            display: grid;
            gap: 18px;
        }

        .mensagem {
            background: white;
            border: 1px solid #e3ebf7;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
            padding: 18px 20px;
        }

        .topo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .remetente {
            font-weight: bold;
            color: #143d6e;
        }

        .status {
            background: #eaf7ef;
            color: #137d3b;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: bold;
        }

        .conteudo {
            color: #5b697b;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <?php include "../../includes/menu_secretaria.php"; ?>

    <main>
        <section class="cabecalho">
            <h1>Mensagens</h1>
        </section>

        <section class="lista">
            <article class="mensagem">
                <div class="topo">
                    <div class="remetente">Coordenação</div>
                    <span class="status">Nova</span>
                </div>
                <div class="conteudo">Solicitação para confirmar o quadro de horários do ensino médio e os professores responsáveis por cada turma.</div>
            </article>

            <article class="mensagem">
                <div class="topo">
                    <div class="remetente">Professora Maria da Silva Santana</div>
                    <span class="status">Lida</span>
                </div>
                <div class="conteudo">A turma 1°A apresentou dificuldades em interpretação de texto e precisa de material de apoio adicional.</div>
            </article>

            <article class="mensagem">
                <div class="topo">
                    <div class="remetente">Responsável do aluno</div>
                    <span class="status">Nova</span>
                </div>
                <div class="conteudo">Pedido de segunda via do boletim e informações sobre o calendário de recuperação de notas.</div>
            </article>
        </section>
    </main>
</body>
</html>