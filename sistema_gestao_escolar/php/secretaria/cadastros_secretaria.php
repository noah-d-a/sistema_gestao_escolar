<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria | Cadastros</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f2f6fc;
            color: #1e293b;
        }
        nav { background: #0b1f3a; }
        main {
            max-width: 1120px;
            margin: 32px auto;
            padding: 0 20px 36px;
        }
        .cabecalho {
            background: linear-gradient(135deg, #0c3d72, #1eadba);
            color: white;
            border-radius: 18px;
            padding: 26px 28px;
            margin-bottom: 24px;
        }
        .cabecalho h1 { margin: 0; font-size: 2rem; }
        .lista {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
        }
        .item {
            display: block;
            text-decoration: none;
            border-radius: 16px;
            border: 1px solid #dfe8f7;
            background: white;
            padding: 22px 18px;
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.04);
            color: #1f2937;
        }
        .item .topo {
            font-size: 0.78rem;
            letter-spacing: 0.08em;
            color: #0f5cad;
            text-transform: uppercase;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .item h3 {
            margin: 0 0 8px;
            font-size: 1.4rem;
            color: #123d70;
        }
        .item p {
            margin: 0;
            color: #5a6576;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <?php include "../../includes/menu_secretaria.php"; ?>

    <main>
        <section class="cabecalho">
            <h1>Cadastros do sistema</h1>
        </section>

        <section class="lista">
            <a class="item" href="acoes_secretaria.php?vitima=Aluno">
                <div class="topo">Categoria</div>
                <h3>Alunos</h3>
                <p>Consultar matrícula, turma, frequência e dados pessoais.</p>
            </a>

            <a class="item" href="acoes_secretaria.php?vitima=Professor">
                <div class="topo">Categoria</div>
                <h3>Professores</h3>
                <p>Dados de docentes, disciplinas, horários e carga horária.</p>
            </a>

            <a class="item" href="acoes_secretaria.php?vitima=Coordenacao">
                <div class="topo">Categoria</div>
                <h3>Coordenação</h3>
                <p>Gestores, supervisores e responsáveis pela instituição.</p>
            </a>

            <a class="item" href="acoes_secretaria.php?vitima=Secretaria">
                <div class="topo">Categoria</div>
                <h3>Secretaria</h3>
                <p>Funcionários administrativos e processos internos.</p>
            </a>

            <a class="item" href="acoes_secretaria.php?vitima=Turma">
                <div class="topo">Estrutura escolar</div>
                <h3>Turmas</h3>
                <p>Manter turma, turno, série e organização letiva.</p>
            </a>

            <a class="item" href="acoes_secretaria.php?vitima=Disciplina">
                <div class="topo">Estrutura escolar</div>
                <h3>Disciplinas</h3>
                <p>Controle de matérias e carga horária por turma.</p>
            </a>
        </section>
    </main>
</body>
</html>