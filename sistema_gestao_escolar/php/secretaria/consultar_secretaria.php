<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria | Consultas</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f7fb;
            color: #1f2937;
        }
        nav { background: #0b1f3a; }
        main {
            max-width: 1080px;
            margin: 32px auto;
            padding: 0 20px 40px;
        }
        .header {
            background: linear-gradient(135deg, #0d3f75, #1a88c8);
            color: white;
            border-radius: 18px;
            padding: 26px 28px;
            margin-bottom: 24px;
        }
        .header h1 { margin: 0; font-size: 2rem; }
        .lista {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 18px;
        }
        .item {
            background: #fff;
            border: 1px solid #e2eaf6;
            border-radius: 16px;
            padding: 18px 20px;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
        }
        .item h3 {
            margin: 0 0 8px;
            color: #123d70;
            font-size: 1.2rem;
        }
        .item p {
            margin: 0;
            color: #5e6979;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <?php include "../../includes/menu_secretaria.php"; ?>

    <main>
        <section class="header">
            <h1>Consulta de registros</h1>
        </section>

        <section class="lista">
            <article class="item">
                <h3>João Miguel Cavalcante</h3>
                <p>RM: 24218 · Turma: 1°A · Frequência: 97% · Nota média: 8,6</p>
            </article>

            <article class="item">
                <h3>Maria Eduarda Silva</h3>
                <p>RM: 24227 · Turma: 1°A · Frequência: 95% · Nota média: 8,9</p>
            </article>

            <article class="item">
                <h3>Pedro Henrique Oliveira</h3>
                <p>RM: 24233 · Turma: 2°A · Frequência: 93% · Nota média: 7,8</p>
            </article>

            <article class="item">
                <h3>Ana Clara Santos</h3>
                <p>RM: 24249 · Turma: 3°B · Frequência: 96% · Nota média: 9,1</p>
            </article>

            <article class="item">
                <h3>Flávia Maria Alberta</h3>
                <p>Professor(a) · Português · Horário: 08:00 às 10:30</p>
            </article>

            <article class="item">
                <h3>Alberto Adriano Antunes</h3>
                <p>Professor(a) · Matemática · Horário: 10:40 às 12:10</p>
            </article>
        </section>
    </main>
</body>
</html>
                break;
            
            case 'Coordenacao':
                while ($coordenacao = $lista->fetch_assoc()) {
                    echo "
                        <li>
                            <a href='consulta_secretaria.php?id={$coordenacao['id']}'>
                                <p>$coordenacao['nome']</p>
                            </a>
                        </li>
                    ";
                }
                break;

            case 'Secretaria':
                while ($secretaria = $lista->fetch_assoc()) {
                    echo "
                        <li>
                            <a href='consulta_secretaria.php?id={$secretaria['id']}'>
                                <p>$secretaria['nome']</p>
                            </a>
                        </li>
                    ";
                }
                break;

            case 'Turma':
                while ($turma = $lista->fetch_assoc()) {
                    echo "
                        <li>
                            <a href='consulta_secretaria.php?id={$turma['id']}'>
                                <p>$turma['nome']</p>
                            </a>
                        </li>
                    ";
                }
                break;

            case 'Disciplina':
                while ($disciplina = $lista->fetch_assoc()) {
                    echo "
                        <li>
                            <a href='consulta_secretaria.php?id={$disciplina['id']}'>
                                <p>$disciplina['nome']</p>
                            </a>
                        </li>
                    ";
                }
                break;
        }
        ?>
    </ul>
</main>