<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SGE - Presença</title>
    <link rel="stylesheet" href="../../css/padronizacao.css"/>
    <link rel="stylesheet" href="../../css/aluno/aluno.css"/>
</head>
<body>

    <?php include '../../includes/menu_aluno.php'; ?>

    <main>
        <div class="cabecalho">
            <div>
                <h1>Presença</h1>
                <p>Acompanhe sua frequência por disciplina — ano letivo 2026</p>
            </div>
            <div class="data">
                <p>Mínimo exigido</p>
                <p class="data-num">75%</p>
            </div>
        </div>

        <!-- CARDS -->
        <div class="cards">
            <div class="card">
                <h3>Frequência Geral</h3>
                <span>86%</span>
                <p class="card-sub">Média de todas as disciplinas</p>
            </div>
            <div class="card">
                <h3>Total de Faltas</h3>
                <span>25</span>
                <p class="card-sub">No ano letivo</p>
            </div>
            <div class="card">
                <h3>Disciplinas em Risco</h3>
                <span>1</span>
                <p class="card-sub">Abaixo de 75%</p>
            </div>
            <div class="card">
                <h3>Disciplinas Regulares</h3>
                <span>5</span>
                <p class="card-sub">Frequência adequada</p>
            </div>
        </div>

        <!-- AVISO -->
        <div class="aviso" style="margin-bottom: 20px;">
            <p class="aviso-titulo">⚠ Atenção</p>
            <p>Sua frequência em <strong>Química</strong> está em <strong>67%</strong>, abaixo do mínimo exigido de 75%. Você pode ser reprovado por falta.</p>
        </div>

        <!-- TABELA -->
        <div class="tabela">
            <h2>Frequência por Disciplina</h2>
            <table>
                <thead>
                    <tr>
                        <th>Disciplina</th>
                        <th>Presenças</th>
                        <th>Faltas</th>
                        <th>Total de Aulas</th>
                        <th>Frequência</th>
                        <th>Situação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Matemática</td>
                        <td>28</td><td>2</td><td>30</td><td>93%</td>
                        <td><span class="badge badge-verde">Regular</span></td>
                    </tr>
                    <tr>
                        <td>Português</td>
                        <td>30</td><td>0</td><td>30</td><td>100%</td>
                        <td><span class="badge badge-verde">Regular</span></td>
                    </tr>
                    <tr>
                        <td>História</td>
                        <td>24</td><td>6</td><td>30</td><td>80%</td>
                        <td><span class="badge badge-amarelo">Atenção</span></td>
                    </tr>
                    <tr>
                        <td>Física</td>
                        <td>27</td><td>3</td><td>30</td><td>90%</td>
                        <td><span class="badge badge-verde">Regular</span></td>
                    </tr>
                    <tr>
                        <td>Química</td>
                        <td>20</td><td>10</td><td>30</td><td>67%</td>
                        <td><span class="badge badge-vermelho">Risco</span></td>
                    </tr>
                    <tr>
                        <td>Biologia</td>
                        <td>26</td><td>4</td><td>30</td><td>87%</td>
                        <td><span class="badge badge-verde">Regular</span></td>
                    </tr>
                </tbody>
            </table>
            <p class="nota-rodape">* Frequência mínima exigida: 75% &nbsp;|&nbsp; Abaixo disso o aluno fica em risco de reprovação por falta.</p>
        </div>

    </main>

</body>
</html>