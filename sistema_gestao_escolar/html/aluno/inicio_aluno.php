<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aluno | Início</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #1f2937;
        }
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
        .topo h1 { margin: 0 0 4px; font-size: 2rem; }
        .topo p  { margin: 0; font-size: 0.9rem; opacity: 0.8; }
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
            box-shadow: 0 8px 20px rgba(15,23,42,0.04);
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
            margin-bottom: 22px;
        }
        .panel {
            background: #fff;
            border-radius: 18px;
            padding: 22px;
            border: 1px solid #e5ebf6;
            box-shadow: 0 10px 22px rgba(15,23,42,0.04);
        }
        .panel h2 { margin-top: 0; color: #133b6d; }
        .perfil-foto {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #dfe9f6;
            margin-bottom: 14px;
        }
        .perfil-dados p {
            font-size: 0.875rem;
            color: #374151;
            margin-bottom: 7px;
        }
        .badge-cursando {
            background: #eaf7ef;
            color: #157c3d;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: bold;
        }
        .lista { list-style: none; margin: 0; padding: 0; }
        .lista li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #edf2f9;
            font-size: 0.875rem;
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
        .alerta { background: #fff7e8; color: #996000; }
        .aviso {
            background: #fff7e8;
            border-left: 4px solid #f59e0b;
            border-radius: 10px;
            padding: 14px 18px;
            font-size: 0.875rem;
            color: #92400e;
            margin-top: 22px;
        }
        .aviso strong { font-weight: bold; }
    </style>
</head>
<body>

    <?php include '../../includes/menu_aluno.php'; ?>

    <main>
        <section class="topo">
            <h1>Bem-vindo, João Alves!</h1>
            <p>Instituto Atlas · 3º Ano A · Manhã · Ano letivo 2026</p>
        </section>

        <section class="painel">
            <div class="box">
                <div class="titulo">Média Geral</div>
                <div class="valor">8.4</div>
            </div>
            <div class="box">
                <div class="titulo">Frequência</div>
                <div class="valor">92%</div>
            </div>
            <div class="box">
                <div class="titulo">Faltas</div>
                <div class="valor">4</div>
            </div>
            <div class="box">
                <div class="titulo">Questionários Pendentes</div>
                <div class="valor">2</div>
            </div>
        </section>

        <section class="grid">
            <div class="panel">
                <h2>Informações do Aluno</h2>
                <img src="../../imgs/fotoaluno.jpg" alt="Foto do Aluno" class="perfil-foto"/>
                <div class="perfil-dados">
                    <p><strong>Unidade:</strong> Instituto Atlas</p>
                    <p><strong>RM:</strong> 2023001</p>
                    <p><strong>Nome:</strong> João Alves</p>
                    <p><strong>Turma:</strong> 3º Ano A</p>
                    <p><strong>Período:</strong> Manhã</p>
                    <p><strong>Ano Letivo:</strong> 2026</p>
                    <p><strong>Sit. Matrícula:</strong> <span class="badge-cursando">Cursando</span></p>
                </div>
            </div>

            <div class="panel">
                <h2>⚠ Pendências</h2>
                <ul class="lista">
                    <li><span>Questionário socioeconômico</span><span class="badge alerta">Pendente</span></li>
                    <li><span>Entrega de documentos</span><span class="badge alerta">Pendente</span></li>
                    <li><span>Rematrícula 2027</span><span class="badge alerta">Pendente</span></li>
                </ul>
            </div>
        </section>

        <div class="aviso">
            ⚠ Sua frequência em <strong>Química</strong> está em <strong>67%</strong>, abaixo do mínimo exigido de 75%. Você pode ser reprovado por falta.
        </div>

    </main>

</body>
</html>