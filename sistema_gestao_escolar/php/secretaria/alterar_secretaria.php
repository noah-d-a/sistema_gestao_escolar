<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria | Alterar Dados</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f7fb;
            color: #20304a;
        }
        nav { background: #0b1f3a; }
        main {
            max-width: 1000px;
            margin: 32px auto;
            padding: 0 20px 40px;
        }
        .container {
            background: white;
            border-radius: 18px;
            border: 1px solid #e2eaf5;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #0d406f, #1d8ec7);
            color: white;
            padding: 24px 28px;
        }
        .header h1 { margin: 0; font-size: 2rem; }
        .content { padding: 28px; }
        .card {
            border: 1px solid #e6edf7;
            border-radius: 14px;
            padding: 18px;
            background: #fbfdff;
            margin-bottom: 18px;
        }
        .card h2 {
            margin: 0 0 14px;
            color: #103f71;
            font-size: 1.2rem;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(220px, 1fr));
            gap: 14px 18px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
            color: #2e4665;
        }
        input, select {
            width: 100%;
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid #dfe8f4;
            background: #f9fbff;
        }
        .actions {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }
        button {
            border: none;
            border-radius: 10px;
            padding: 12px 18px;
            font-weight: bold;
            cursor: pointer;
        }
        .primary { background: #0d4a8f; color: white; }
        .secondary { background: #eaf3ff; color: #0b447d; }
    </style>
</head>
<body>
    <?php include "../../includes/menu_secretaria.php"; ?>

    <main>
        <section class="container">
            <div class="header">
                <h1>Alterar cadastro</h1>
            </div>

            <div class="content">
                <div class="card">
                    <h2>Dados pessoais</h2>
                    <div class="grid">
                        <div>
                            <label>Nome completo</label>
                            <input type="text" value="Sabrina Lopes Martins" />
                        </div>
                        <div>
                            <label>CPF</label>
                            <input type="text" value="765.432.110-88" />
                        </div>
                        <div>
                            <label>RG</label>
                            <input type="text" value="22.456.781-K" />
                        </div>
                        <div>
                            <label>Data de nascimento</label>
                            <input type="date" value="2007-12-20" />
                        </div>
                        <div>
                            <label>Telefone</label>
                            <input type="text" value="(11) 98888-1122" />
                        </div>
                        <div>
                            <label>E-mail</label>
                            <input type="email" value="sabrina.martins@escolafutura.edu.br" />
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h2>Endereço e status</h2>
                    <div class="grid">
                        <div style="grid-column: 1 / -1;">
                            <label>Endereço</label>
                            <input type="text" value="Avenida das Flores, 410 - Jardim Paulista, São Paulo/SP" />
                        </div>
                        <div>
                            <label>Status</label>
                            <select>
                                <option selected>Ativo</option>
                                <option>Inativo</option>
                                <option>Em análise</option>
                            </select>
                        </div>
                        <div>
                            <label>Perfil</label>
                            <select>
                                <option selected>Aluno</option>
                                <option>Professor</option>
                                <option>Coordenação</option>
                                <option>Secretaria</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="actions">
                    <button class="primary" type="button">Salvar alterações</button>
                    <button class="secondary" type="button">Cancelar</button>
                </div>
            </div>
        </section>
    </main>
</body>
</html>