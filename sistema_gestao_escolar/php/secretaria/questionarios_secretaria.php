<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria | Questionários</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f6fb;
            color: #1f2937;
        }

        main {
            max-width: 1080px;
            margin: 32px auto;
            padding: 0 20px 40px;
        }

        .cabecalho {
            background: linear-gradient(135deg, #0d3d70, #1b8ac0);
            color: white;
            border-radius: 18px;
            padding: 26px 28px;
            margin-bottom: 24px;
        }

        .cabecalho h1 {
            margin: 0;
            font-size: 2rem;
        }

        .grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 22px;
        }

        .panel {
            background: #fff;
            border: 1px solid #e2eaf5;
            border-radius: 18px;
            padding: 22px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.04);
        }

        .panel h2 {
            margin-top: 0;
            color: #123d70;
        }

        .lista {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .lista li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #edf2f9;
        }

        .lista li:last-child {
            border-bottom: none;
        }

        .badge {
            background: #ebf7ef;
            color: #127c3b;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: bold;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 16px;
        }

        label {
            font-weight: bold;
            color: #25445d;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #dfe8f4;
            border-radius: 10px;
            background: #f9fbff;
        }

        button {
            border: none;
            border-radius: 10px;
            padding: 12px 18px;
            background: #0d4a8f;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include "../../includes/menu_secretaria.php"; ?>

    <main>
        <section class="cabecalho">
            <h1>Questionários</h1>
        </section>

        <section class="grid">
            <div class="panel">
                <h2>Questionários cadastrados</h2>
                <ul class="lista">
                    <li>
                        <span>Questionário de acompanhamento do 1° ano</span>
                        <span class="badge">Ativo</span>
                    </li>
                    <li>
                        <span>Pesquisa sobre satisfação do aluno</span>
                        <span class="badge">Ativo</span>
                    </li>
                    <li>
                        <span>Avaliação de aprendizagem de Matemática</span>
                        <span class="badge">Fechado</span>
                    </li>
                    <li>
                        <span>Questionário de relacionamento com a escola</span>
                        <span class="badge">Ativo</span>
                    </li>
                </ul>
            </div>

            <div class="panel">
                <h2>Criar questionário</h2>
                <div class="form-group">
                    <label for="titulo">Título</label>
                    <input id="titulo" type="text" value="Acompanhamento pedagógico trimestral" />
                </div>
                <div class="form-group">
                    <label for="turma">Turma</label>
                    <select id="turma">
                        <option>1°A</option>
                        <option>2°A</option>
                        <option>3°B</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" rows="4">Avaliação de satisfação e acompanhamento das dificuldades de aprendizagem.</textarea>
                </div>
                <button type="button">Salvar questionário</button>
            </div>
        </section>
    </main>
</body>
</html>