<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria | Cadastro</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f6fb;
            color: #1f2937;
        }

        main {
            max-width: 980px;
            margin: 32px auto;
            padding: 0 20px 40px;
        }

        .topo {
            background: linear-gradient(135deg, #0d3d70, #1f8fd8);
            color: white;
            border-radius: 18px;
            padding: 28px 30px;
            margin-bottom: 26px;
            box-shadow: 0 10px 25px rgba(13, 61, 112, 0.18);
        }

        .topo h1 {
            margin: 0;
            font-size: 2rem;
        }

        .box {
            background: #fff;
            border: 1px solid #e2eaf5;
            border-radius: 18px;
            padding: 28px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.04);
        }

        form {
            display: grid;
            grid-template-columns: repeat(2, minmax(220px, 1fr));
            gap: 18px 22px;
        }

        .campo {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .campo.full {
            grid-column: 1 / -1;
        }

        label {
            font-weight: bold;
            color: #26405d;
        }

        input, select {
            width: 100%;
            padding: 11px 12px;
            border-radius: 10px;
            border: 1px solid #dfe8f4;
            background: #f9fbff;
            font-size: 0.95rem;
        }

        .botoes {
            grid-column: 1 / -1;
            display: flex;
            gap: 12px;
            margin-top: 8px;
        }

        button {
            border: none;
            border-radius: 10px;
            padding: 12px 18px;
            font-weight: bold;
            cursor: pointer;
        }

        .principal {
            background: #0d4a8f;
            color: white;
        }

        .secundario {
            background: #edf3ff;
            color: #154c82;
        }
    </style>
</head>
<body>
    <?php include "../../includes/menu_secretaria.php"; ?>

    <main>
        <section class="topo">
            <h1>Cadastro do usuário</h1>
        </section>

        <section class="box">
            <form>
                <div class="campo">
                    <label for="perfil">Perfil</label>
                    <select id="perfil">
                        <option>Aluno</option>
                        <option>Professor</option>
                        <option>Coordenação</option>
                        <option>Secretaria</option>
                    </select>
                </div>

                <div class="campo">
                    <label for="nome">Nome completo</label>
                    <input id="nome" type="text" value="Sabrina Lopes Martins" />
                </div>

                <div class="campo">
                    <label for="cpf">CPF</label>
                    <input id="cpf" type="text" value="765.432.110-88" />
                </div>

                <div class="campo">
                    <label for="rg">RG</label>
                    <input id="rg" type="text" value="22.456.781-K" />
                </div>

                <div class="campo">
                    <label for="nascimento">Data de nascimento</label>
                    <input id="nascimento" type="date" value="2007-12-20" />
                </div>

                <div class="campo">
                    <label for="telefone">Telefone</label>
                    <input id="telefone" type="text" value="(11) 98888-1122" />
                </div>

                <div class="campo full">
                    <label for="email">E-mail</label>
                    <input id="email" type="email" value="sabrina.martins@escolafutura.edu.br" />
                </div>

                <div class="campo full">
                    <label for="endereco">Endereço</label>
                    <input id="endereco" type="text" value="Avenida das Flores, 410 - Jardim Paulista, São Paulo/SP" />
                </div>

                <div class="campo">
                    <label for="turma">Turma / setor</label>
                    <input id="turma" type="text" value="1°A / Secretaria" />
                </div>

                <div class="campo">
                    <label for="status">Status</label>
                    <select id="status">
                        <option selected>Ativo</option>
                        <option>Inativo</option>
                        <option>Em análise</option>
                    </select>
                </div>

                <div class="botoes">
                    <button class="principal" type="button">Salvar cadastro</button>
                    <button class="secundario" type="reset">Limpar</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>