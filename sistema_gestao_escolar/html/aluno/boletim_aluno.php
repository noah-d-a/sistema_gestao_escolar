<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SGE - Boletim</title>
    <link rel="stylesheet" href="../../css/padronizacao.css"/>
    <link rel="stylesheet" href="../../css/aluno/aluno.css"/>
</head>
<body>

    <?php include '../../includes/menu_aluno.php'; ?>

    <main>
        <div class="cabecalho">
            <div>
                <h1>Boletim</h1>
                <p>Confira suas notas por disciplina — ano letivo 2026</p>
            </div>
            <div>
                <select id="bimestre" onchange="trocarBimestre()" class="select-bimestre">
                    <option value="1">1º Bimestre</option>
                    <option value="2" selected>2º Bimestre</option>
                    <option value="3" disabled>3º Bimestre — Em breve</option>
                    <option value="4" disabled>4º Bimestre — Em breve</option>
                </select>
            </div>
        </div>

    
        <div class="cards">
            <div class="card">
                <h3>Média Geral</h3>
                <span>8.4</span>
                <p class="card-sub">Ano letivo 2026</p>
            </div>
            <div class="card">
                <h3>Aprovado</h3>
                <span>4</span>
                <p class="card-sub">Disciplinas</p>
            </div>
            <div class="card">
                <h3>Recuperação</h3>
                <span>2</span>
                <p class="card-sub">Disciplinas</p>
            </div>
            <div class="card">
                <h3>Reprovado</h3>
                <span>0</span>
                <p class="card-sub">Disciplinas</p>
            </div>
        </div>

        <div class="tabela">
            <h2>Notas por Disciplina</h2>
            <table>
                <thead>
                    <tr>
                        <th>Disciplina</th>
                        <th>Professor</th>
                        <th>Prova 1</th>
                        <th>Prova 2</th>
                        <th>Trabalho</th>
                        <th>Média</th>
                        <th>Situação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Matemática</td>
                        <td>Prof. Carlos Lima</td>
                        <td>9.0</td><td>8.5</td><td>8.0</td>
                        <td><strong>8.5</strong></td>
                        <td><span class="badge badge-verde">Aprovado</span></td>
                    </tr>
                    <tr>
                        <td>Português</td>
                        <td>Profa. Ana Souza</td>
                        <td>7.5</td><td>8.0</td><td>7.0</td>
                        <td><strong>7.5</strong></td>
                        <td><span class="badge badge-verde">Aprovado</span></td>
                    </tr>
                    <tr>
                        <td>História</td>
                        <td>Prof. Roberto Dias</td>
                        <td>5.0</td><td>4.5</td><td>6.0</td>
                        <td><strong>5.2</strong></td>
                        <td><span class="badge badge-amarelo">Recuperação</span></td>
                    </tr>
                    <tr>
                        <td>Física</td>
                        <td>Profa. Maria Pereira</td>
                        <td>8.8</td><td>9.0</td><td>8.5</td>
                        <td><strong>8.8</strong></td>
                        <td><span class="badge badge-verde">Aprovado</span></td>
                    </tr>
                    <tr>
                        <td>Química</td>
                        <td>Prof. João Ferreira</td>
                        <td>6.0</td><td>5.5</td><td>6.5</td>
                        <td><strong>6.0</strong></td>
                        <td><span class="badge badge-amarelo">Recuperação</span></td>
                    </tr>
                    <tr>
                        <td>Biologia</td>
                        <td>Profa. Sandra Costa</td>
                        <td>7.0</td><td>7.5</td><td>8.0</td>
                        <td><strong>7.5</strong></td>
                        <td><span class="badge badge-verde">Aprovado</span></td>
                    </tr>
                </tbody>
            </table>
            <p class="nota-rodape">* Nota mínima para aprovação: 6.0 &nbsp;|&nbsp; Mínimo para recuperação: 4.0</p>
        </div>

    </main>

    <script>
        function trocarBimestre() {
            const bimestre = document.getElementById('bimestre').value;
            const titulo = document.querySelector('.tabela h2');

            if (bimestre === '1') {
                titulo.textContent = 'Notas por Disciplina — 1º Bimestre';
            } else if (bimestre === '2') {
                titulo.textContent = 'Notas por Disciplina — 2º Bimestre';
            }
        }
    </script>

</body>
</html>