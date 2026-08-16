<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria | Ações</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f6fb;
            color: #1f2937;
        }
        nav { background: #0b1f3a; }
        main {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px 40px;
        }
        .hero {
            background: linear-gradient(135deg, #0d4a8f, #1f8ad9);
            color: #fff;
            padding: 30px 28px;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(13,74,143,0.18);
            margin-bottom: 28px;
        }
        .hero h1 { margin: 10px 0 8px; font-size: 2rem; }
        .badge {
            display: inline-block;
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.35);
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }
        .card {
            display: block;
            text-decoration: none;
            background: #fff;
            border-radius: 16px;
            padding: 24px 20px;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
            border: 1px solid #e5e7eb;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12);
        }
        .icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 16px;
            background: #eaf4ff;
            color: #0d4a8f;
        }
        .card h2 {
            margin: 0 0 8px;
            color: #133b6d;
            font-size: 1.3rem;
        }
        .card p {
            margin: 0;
            color: #5b6472;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <?php include "../../includes/menu_secretaria.php"; ?>

    <main>
        <section class="hero">
            <span class="badge">Secretaria</span>
            <h1>Gestão administrativa da escola</h1>
            <p>Cadastros, consultas, alterações e controle de turmas, matérias e usuários.</p>
        </section>

        <div class="grid">
            <a class="card" href="cadastrar_secretaria.php?vitima=Aluno">
                <div class="icon">👤</div>
                <h2>Cadastrar</h2>
                <p>Adicionar alunos, professores, coordenação e membros da secretaria.</p>
            </a>

            <a class="card" href="consultar_secretaria.php?vitima=Aluno">
                <div class="icon">🔎</div>
                <h2>Consultar</h2>
                <p>Visualizar dados cadastrais e informações de usuários do sistema.</p>
            </a>

            <a class="card" href="alterar_secretaria.php?vitima=Aluno">
                <div class="icon">✏️</div>
                <h2>Alterar</h2>
                <p>Atualizar dados pessoais, endereço, contato e situação cadastral.</p>
            </a>

            <a class="card" href="deletar_secretaria.php?vitima=Aluno">
                <div class="icon">🗑️</div>
                <h2>Deletar</h2>
                <p>Remover cadastros e manter o sistema organizado e atualizado.</p>
            </a>
        </div>
    </main>
</body>
</html>