<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria | Alunos</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #1f2937;
        }
        nav { background: #0b1f3a; }
        main {
            max-width: 1100px;
            margin: 32px auto;
            padding: 0 20px 40px;
        }
        .header {
            background: linear-gradient(135deg, #103b6e, #1f8ad9);
            color: white;
            border-radius: 18px;
            padding: 28px 30px;
            margin-bottom: 24px;
        }
        .header h1 { margin: 0; font-size: 2rem; }
        .lista {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 18px;
        }
        .aluno {
            background: white;
            border: 1px solid #e3ebf7;
            border-radius: 16px;
            padding: 18px 20px;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
        }
        .nome {
            font-size: 1.1rem;
            font-weight: bold;
            color: #113d70;
            margin-bottom: 8px;
        }
        .dados {
            color: #5c6878;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <?php include "../../includes/menu_secretaria.php"; ?>

    <main>
        <section class="header">
            <h1>Alunos por turma</h1>
        </section>

        <section class="lista">
            <article class="aluno">
                <div class="nome">João Miguel Cavalcante</div>
                <div class="dados">Turma: 1°A<br>RM: 24218<br>Frequência: 97%</div>
            </article>
            <article class="aluno">
                <div class="nome">Maria Eduarda Silva</div>
                <div class="dados">Turma: 1°A<br>RM: 24227<br>Frequência: 95%</div>
            </article>
            <article class="aluno">
                <div class="nome">Pedro Henrique Oliveira</div>
                <div class="dados">Turma: 2°A<br>RM: 24233<br>Frequência: 93%</div>
            </article>
            <article class="aluno">
                <div class="nome">Ana Clara Santos</div>
                <div class="dados">Turma: 3°B<br>RM: 24249<br>Frequência: 96%</div>
            </article>
            <article class="aluno">
                <div class="nome">Sofia Helena Martins</div>
                <div class="dados">Turma: 2°B<br>RM: 24251<br>Frequência: 94%</div>
            </article>
            <article class="aluno">
                <div class="nome">Camila Oliveira Azevedo</div>
                <div class="dados">Turma: 3°A<br>RM: 24273<br>Frequência: 96%</div>
            </article>
        </section>
    </main>
</body>
</html>

                    <li>
                        <a href='consulta_secretaria.php?id=117&vitima=$vitima'>
                            Gabriel Arthur Mendes
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=118&vitima=$vitima'>
                            Laura Fonseca Almeida
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=119&vitima=$vitima'>
                            Luiz Gabriel Mendes Costa Fernandez
                        </a>
                    </li>
                ";
            } elseif ($id == 2) {
                echo "
                    <li>
                        <a href='consulta_secretaria.php?id=200&vitima=$vitima'>
                            Sofia Helena Martins
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=201&vitima=$vitima'>
                            Rafael Costa Nunes
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=202&vitima=$vitima'>
                            Camila Oliveira Azevedo
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=203&vitima=$vitima'>
                            Thiago Pereira Rocha
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=204&vitima=$vitima'>
                            Júlia Fernandes Andrade
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=205&vitima=$vitima'>
                            Emerson Silva Santos
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=206&vitima=$vitima'>
                            Marina Souza Almeida
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=207&vitima=$vitima'>
                            Bruno Cardoso Reis
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=208&vitima=$vitima'>
                            Larissa Mendes Barbosa
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=209&vitima=$vitima'>
                            Victor Teixeira Lima
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=210&vitima=$vitima'>
                            Isadora Santos Pereira
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=211&vitima=$vitima'>
                            Leonardo Moraes Castro
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=212&vitima=$vitima'>
                            Natália Gonçalves Vieira
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=213&vitima=$vitima'>
                            Matheus Ribeiro Ferreira
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=214&vitima=$vitima'>
                            Gabriela Santos Rocha
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=215&vitima=$vitima'>
                            Eduardo Almeida Costa
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=216&vitima=$vitima'>
                            Beatriz Ferreira Soares
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=217&vitima=$vitima'>
                            Pedro Nascimento Alves
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=218&vitima=$vitima'>
                            Clara Martins Ribeiro
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=219&vitima=$vitima'>
                            Felipe Jesus Oliveira
                        </a>
                    </li>
                ";
            } elseif ($id == 3) {
                echo "
                    <li>
                        <a href='consulta_secretaria.php?id=300&vitima=$vitima'>
                            Ana Luiza Moreira
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=301&vitima=$vitima'>
                            Caio Henrique Barros
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=302&vitima=$vitima'>
                            Valentina Rocha Souza
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=303&vitima=$vitima'>
                            Lucas Eduardo Farias
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=304&vitima=$vitima'>
                            Giovanna Costa Lima
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=305&vitima=$vitima'>
                            Enzo Gabriel Souza
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=306&vitima=$vitima'>
                            Helena Maria Pires
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=307&vitima=$vitima'>
                            Igor da Silva
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=308&vitima=$vitima'>
                            Priscila Batista Santos
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=309&vitima=$vitima'>
                            Davi Lucas Martins
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=310&vitima=$vitima'>
                            Renata Almeida Vieira
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=311&vitima=$vitima'>
                            Samuel Nascimento Rocha
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=312&vitima=$vitima'>
                            Yasmin Ferreira Nogueira
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=313&vitima=$vitima'>
                            Pedro Lucas Cunha
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=314&vitima=$vitima'>
                            Manuela Souza Brito
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=315&vitima=$vitima'>
                            João Pedro Santos
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=316&vitima=$vitima'>
                            Letícia Ramos Monteiro
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=317&vitima=$vitima'>
                            Otávio Azevedo Rocha
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=318&vitima=$vitima'>
                            Bianca Ramos Castro
                        </a>
                    </li>

                    <li>
                        <a href='consulta_secretaria.php?id=319&vitima=$vitima'>
                            Nicolas da Costa
                        </a>
                    </li>
                ";
            }
            ?>
        </ul>
    </main>
</body>
</html>