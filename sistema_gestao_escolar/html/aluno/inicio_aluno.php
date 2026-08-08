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
                <h1>Início</h1>
                <p>Bem-vindo ao Sistema de Gestão Escolar — Instituto Atlas</p>
            </div>
            <div class="data">
                <p>Hoje</p>
                <p class="data-num">06/08/2026</p>
            </div>
        </div>

        <div class="duas-colunas">

            <div class="tabela">
                <h2>Informações do Aluno</h2>
                <div class="perfil-aluno">
                    <img src="../../imgs/fotoaluno.jpg" alt="Foto do Aluno" class="foto-aluno"/>
                    <div class="perfil-dados">
                        <p><strong>Nome:</strong> João Alves</p>
                        <p><strong>RM:</strong> 2023001</p>
                        <p><strong>Turma:</strong> 3º Ano A</p>
                        <p><strong>Período:</strong> Manhã</p>
                        <p><strong>Ano Letivo:</strong> 2026</p>
                        <p><strong>Situação:</strong> <span class="badge badge-verde">Cursando</span></p>
                    </div>
                </div>
            </div>

            <div class="tabela">
                <h2 class="pendencias-titulo">⚠ Pendências</h2>
                <p class="pendencias-sub">Clique para atender</p>
                <ul class="pendencias-lista">
                    <li><a href="#">Questionário socioeconômico</a></li>
                    <li><a href="#">Entrega de documentos</a></li>
                    <li><a href="#">Rematrícula 2027</a></li>
                </ul>
            </div>

        </div>

        <div class="cards">
            <div class="card">
                <h3>Média Geral</h3>
                <span>8.4</span>
                <p class="card-sub">Ano letivo 2026</p>
            </div>
            <div class="card">
                <h3>Frequência</h3>
                <span>92%</span>
                <p class="card-sub">Regular</p>
            </div>
            <div class="card">
                <h3>Faltas</h3>
                <span>4</span>
                <p class="card-sub">No ano letivo</p>
            </div>
            <div class="card">
                <h3>Questionários</h3>
                <span>2</span>
                <p class="card-sub">Pendentes</p>
            </div>
        </div>

        <div class="aviso">
            <p class="aviso-titulo">⚠ Atenção</p>
            <p>Sua frequência em <strong>Química</strong> está em <strong>67%</strong>, abaixo do mínimo exigido de 75%.</p>
        </div>

    </main>

</body>
</html>