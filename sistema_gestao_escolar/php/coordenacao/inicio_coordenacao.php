<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordenação | Início</title>
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
            max-width: 1180px;
            margin: 32px auto;
            padding: 0 20px 40px;
        }
        .topo {
            background: linear-gradient(135deg, #1f3b65, #4568a8);
            color: white;
            border-radius: 18px;
            padding: 30px 28px;
            margin-bottom: 26px;
        }
        .topo h1 { margin: 0; font-size: 2rem; }
        .painel {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }
        .box {
            background: white;
            padding: 20px;
            border-radius: 16px;
            border: 1px solid #dfe9f6;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
        }
        .box .titulo {
            color: #6b7280;
            font-size: 0.82rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .box .valor {
            font-size: 2rem;
            font-weight: bold;
            color: #183f73;
        }
        .grid {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: 22px;
        }
        .panel {
            background: #fff;
            border-radius: 18px;
            padding: 22px;
            border: 1px solid #e5ebf6;
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.04);
        }
        .panel h2 {
            margin-top: 0;
            color: #133b6d;
        }
        .lista { list-style: none; margin: 0; padding: 0; }
        .lista li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #edf2f9;
        }
        .lista li:last-child { border-bottom: none; }
        .badge {
            background: #eaf7ef;
            color: #157c3d;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: bold;
        }
        .alerta {
            background: #fff7e8;
            color: #996000;
        }
    </style>
</head>
<body>
    <?php include "../../includes/menu_coordenacao.php"; ?>

    <main>
        <section class="topo">
            <h1>Dashboard de Coordenação</h1>
        </section>

        <section class="painel">
            <div class="box">
                <div class="titulo">Alunos matriculados</div>
                <div class="valor">1.248</div>
            </div>
            <div class="box">
                <div class="titulo">Professores</div>
                <div class="valor">86</div>
            </div>
            <div class="box">
                <div class="titulo">Turmas ativas</div>
                <div class="valor">32</div>
            </div>
            <div class="box">
                <div class="titulo">Frequência geral</div>
                <div class="valor">96%</div>
            </div>
        </section>

        <section class="grid">
            <div class="panel">
                <h2>Resumo da semana</h2>
                <ul class="lista">
                    <li><span>Reunião de acompanhamento da 1° série</span><span class="badge">OK</span></li>
                    <li><span>Lançamento de notas do 3° bimestre</span><span class="badge">OK</span></li>
                    <li><span>Planejamento de prova trimestral</span><span class="badge">OK</span></li>
                    <li><span>Solicitação de material escolar</span><span class="badge alerta">Pendente</span></li>
                    <li><span>Consolidação de frequência</span><span class="badge">OK</span></li>
                </ul>
            </div>

            <div class="panel">
                <h2>Observações da coordenação</h2>
                <p>Há necessidade de reforço no acompanhamento dos alunos com presença abaixo de 85%.</p>
                <p>Turma 3°B apresenta maior quantidade de pendências em Matemática e Física.</p>
                <p>Calendário de avaliações será revisado na próxima reunião pedagógica.</p>
            </div>
        </section>
    </main>
</body>
</html>
