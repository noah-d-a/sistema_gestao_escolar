<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SGE - Aluno</title>
    <link rel="stylesheet" href="../../css/padronizacao.css"/>
    <link rel="stylesheet" href="../../css/aluno/aluno.css"/>
</head>
<body>

    <?php include '../../includes/menu_aluno.php'; ?>

    <main>
        <div class="cabecalho">
            <div>
                <h1>Bem-vindo, João!</h1>
                <p>Acompanhe seu desempenho — ano letivo 2026 · 3º Ano A</p>
            </div>
            <div class="data">
                <p>Segunda-feira</p>
                <p class="data-num">03/08/2026</p>
            </div>
        </div>

        <!-- CARDS -->
        <div class="cards">
            <div class="card card-azul">
                <h3>Média Geral</h3>
                <span>8.4</span>
                <p class="card-sub">Bom desempenho</p>
            </div>
            <div class="card card-verde">
                <h3>Frequência</h3>
                <span>92%</span>
                <p class="card-sub">Regular</p>
            </div>
            <div class="card card-vermelho">
                <h3>Faltas</h3>
                <span>4</span>
                <p class="card-sub">No ano letivo</p>
            </div>
            <div class="card card-amarelo">
                <h3>Questionários</h3>
                <span>2</span>
                <p class="card-sub">Pendentes</p>
            </div>
        </div>

        <!-- DUAS COLUNAS -->
        <div class="duas-colunas">

            <!-- NOTAS RECENTES -->
            <div class="tabela">
                <h2>Notas Recentes</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Disciplina</th>
                            <th>Avaliação</th>
                            <th>Nota</th>
                            <th>Situação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Matemática</td>
                            <td>Prova 1</td>
                            <td>9.0</td>
                            <td><span class="badge badge-verde">Aprovado</span></td>
                        </tr>
                        <tr>
                            <td>Português</td>
                            <td>Trabalho</td>
                            <td>7.5</td>
                            <td><span class="badge badge-verde">Aprovado</span></td>
                        </tr>
                        <tr>
                            <td>História</td>
                            <td>Prova 1</td>
                            <td>5.0</td>
                            <td><span class="badge badge-amarelo">Recuperação</span></td>
                        </tr>
                        <tr>
                            <td>Física</td>
                            <td>Prova 1</td>
                            <td>8.8</td>
                            <td><span class="badge badge-verde">Aprovado</span></td>
                        </tr>
                        <tr>
                            <td>Química</td>
                            <td>Lab 1</td>
                            <td>6.0</td>
                            <td><span class="badge badge-amarelo">Recuperação</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- LADO DIREITO -->
            <div class="coluna-direita">

                <!-- HORÁRIO DE HOJE -->
                <div class="tabela">
                    <h2>Horário de Hoje</h2>
                    <div class="horario-item">
                        <span class="horario-hora">07:30</span>
                        <div>
                            <p class="horario-disc">Matemática</p>
                            <p class="horario-sala">Sala 12</p>
                        </div>
                    </div>
                    <div class="horario-item">
                        <span class="horario-hora">09:10</span>
                        <div>
                            <p class="horario-disc">Português</p>
                            <p class="horario-sala">Sala 12</p>
                        </div>
                    </div>
                    <div class="horario-item">
                        <span class="horario-hora">10:50</span>
                        <div>
                            <p class="horario-disc">Física</p>
                            <p class="horario-sala">Lab de Ciências</p>
                        </div>
                    </div>
                    <div class="horario-item">
                        <span class="horario-hora">13:00</span>
                        <div>
                            <p class="horario-disc">História</p>
                            <p class="horario-sala">Sala 08</p>
                        </div>
                    </div>
                    <div class="horario-item">
                        <span class="horario-hora">14:40</span>
                        <div>
                            <p class="horario-disc">Química</p>
                            <p class="horario-sala">Lab de Ciências</p>
                        </div>
                    </div>
                </div>

                <!-- AVISO -->
                <div class="aviso">
                    <p class="aviso-titulo">⚠ Atenção</p>
                    <p>Sua frequência em Química está em <strong>67%</strong>. O mínimo exigido é 75%.</p>
                </div>

            </div>
        </div>
    </main>

</body>
</html>