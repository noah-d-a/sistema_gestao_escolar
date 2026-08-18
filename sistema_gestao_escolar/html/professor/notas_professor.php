<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor | Notas</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #1f2937; }
        main { max-width: 1180px; margin: 32px auto; padding: 0 20px 40px; }
        .topo { background: linear-gradient(135deg, #1f3b65, #4568a8); color: white; border-radius: 18px; padding: 30px 28px; margin-bottom: 26px; }
        .topo h1 { margin: 0 0 4px; font-size: 2rem; }
        .topo p { margin: 0; font-size: 0.9rem; opacity: 0.8; }
        .panel { background: #fff; border-radius: 18px; padding: 22px; border: 1px solid #e5ebf6; box-shadow: 0 10px 22px rgba(15,23,42,0.04); margin-bottom: 22px; }
        .panel h2 { margin-top: 0; color: #133b6d; }
        .filtros { display: flex; gap: 12px; align-items: flex-end; margin-bottom: 20px; }
        .filtros label { font-size: 0.78rem; font-weight: bold; color: #555; display: block; margin-bottom: 4px; }
        .filtros select { border: 1px solid #dfe9f6; border-radius: 8px; padding: 8px 12px; font-size: 0.84rem; outline: none; }
        .filtros button { background: #183f73; color: #fff; border: none; border-radius: 8px; padding: 8px 16px; font-size: 0.84rem; font-weight: bold; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        thead th { text-align: left; padding: 10px 12px; font-size: 0.75rem; color: #6b7280; border-bottom: 1px solid #edf2f9; text-transform: uppercase; }
        tbody td { padding: 12px; border-bottom: 1px solid #edf2f9; color: #374151; }
        tbody tr:last-child td { border-bottom: none; }
        input[type=number] { width: 70px; border: 1px solid #dfe9f6; border-radius: 6px; padding: 4px 8px; font-size: 0.83rem; }
        .btn-salvar { background: #183f73; color: #fff; border: none; border-radius: 6px; padding: 5px 12px; font-size: 0.78rem; cursor: pointer; }
    </style>
</head>
<body>
    <?php include '../../includes/menu_professor.php'; ?>
    <main>
        <section class="topo">
            <h1>Lançamento de Notas</h1>
            <p>Selecione a turma e avaliação para lançar as notas</p>
        </section>
        <div class="panel">
            <div class="filtros">
                <div><label>Turma</label><select><option>3º Ano A</option><option>2º Ano B</option><option>1º Ano C</option></select></div>
                <div><label>Avaliação</label><select><option>Prova 1</option><option>Prova 2</option><option>Trabalho</option></select></div>
                <button>Buscar</button>
            </div>
            <h2>3º Ano A · Matemática · Prova 1</h2>
            <table>
                <thead><tr><th>RM</th><th>Aluno</th><th>Nota</th><th>Ação</th></tr></thead>
                <tbody>
                    <tr><td>2023001</td><td>Ana Lima</td><td><input type="number" min="0" max="10" step="0.1" value="9.5"/></td><td><button class="btn-salvar">Salvar</button></td></tr>
                    <tr><td>2023002</td><td>Carlos Souza</td><td><input type="number" min="0" max="10" step="0.1" value="6.0"/></td><td><button class="btn-salvar">Salvar</button></td></tr>
                    <tr><td>2023003</td><td>Beatriz Costa</td><td><input type="number" min="0" max="10" step="0.1" value="8.0"/></td><td><button class="btn-salvar">Salvar</button></td></tr>
                    <tr><td>2023004</td><td>Rafael Torres</td><td><input type="number" min="0" max="10" step="0.1" value="7.5"/></td><td><button class="btn-salvar">Salvar</button></td></tr>
                    <tr><td>2023005</td><td>Juliana Neves</td><td><input type="number" min="0" max="10" step="0.1" value="4.0"/></td><td><button class="btn-salvar">Salvar</button></td></tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>