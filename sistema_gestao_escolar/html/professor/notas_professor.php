<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SGE - Notas</title>
    <link rel="stylesheet" href="../../css/padronizacao.css"/>
</head>
<body>
    <?php include '../../includes/menu_professor.php'; ?>
    <main>
        <h1>Lançamento de Notas</h1>
        <p>Selecione a turma e disciplina para lançar as notas</p>

        <div class="tabela" style="padding:16px; margin-bottom:14px;">
            <div style="display:flex; gap:12px; align-items:flex-end;">
                <div>
                    <label style="font-size:0.78rem;font-weight:600;color:#555;display:block;margin-bottom:4px;">Turma</label>
                    <select style="border:1px solid #e5e7eb;border-radius:6px;padding:8px 12px;font-size:0.84rem;font-family:Inter,sans-serif;outline:none;">
                        <option>3º Ano A</option>
                        <option>2º Ano B</option>
                        <option>1º Ano C</option>
                    </select>
                </div>
                <div>
                    <label style="font-size:0.78rem;font-weight:600;color:#555;display:block;margin-bottom:4px;">Avaliação</label>
                    <select style="border:1px solid #e5e7eb;border-radius:6px;padding:8px 12px;font-size:0.84rem;font-family:Inter,sans-serif;outline:none;">
                        <option>Prova 1</option>
                        <option>Prova 2</option>
                        <option>Trabalho</option>
                    </select>
                </div>
                <button style="background:#7B1F2E;color:#fff;border:none;border-radius:6px;padding:8px 16px;font-size:0.84rem;font-weight:600;cursor:pointer;">Buscar</button>
            </div>
        </div>

        <div class="tabela">
            <h2>Notas — 3º Ano A · Matemática · Prova 1</h2>
            <table>
                <thead>
                    <tr>
                        <th>RM</th>
                        <th>Aluno</th>
                        <th>Nota</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>2023001</td><td>Ana Lima</td><td><input type="number" min="0" max="10" step="0.1" value="9.5" style="width:70px;border:1px solid #e5e7eb;border-radius:4px;padding:4px 8px;font-size:0.83rem;"/></td><td><button style="background:#7B1F2E;color:#fff;border:none;border-radius:4px;padding:4px 10px;font-size:0.78rem;cursor:pointer;">Salvar</button></td></tr>
                    <tr><td>2023002</td><td>Carlos Souza</td><td><input type="number" min="0" max="10" step="0.1" value="6.0" style="width:70px;border:1px solid #e5e7eb;border-radius:4px;padding:4px 8px;font-size:0.83rem;"/></td><td><button style="background:#7B1F2E;color:#fff;border:none;border-radius:4px;padding:4px 10px;font-size:0.78rem;cursor:pointer;">Salvar</button></td></tr>
                    <tr><td>2023003</td><td>Beatriz Costa</td><td><input type="number" min="0" max="10" step="0.1" value="8.0" style="width:70px;border:1px solid #e5e7eb;border-radius:4px;padding:4px 8px;font-size:0.83rem;"/></td><td><button style="background:#7B1F2E;color:#fff;border:none;border-radius:4px;padding:4px 10px;font-size:0.78rem;cursor:pointer;">Salvar</button></td></tr>
                    <tr><td>2023004</td><td>Rafael Torres</td><td><input type="number" min="0" max="10" step="0.1" value="7.5" style="width:70px;border:1px solid #e5e7eb;border-radius:4px;padding:4px 8px;font-size:0.83rem;"/></td><td><button style="background:#7B1F2E;color:#fff;border:none;border-radius:4px;padding:4px 10px;font-size:0.78rem;cursor:pointer;">Salvar</button></td></tr>
                    <tr><td>2023005</td><td>Juliana Neves</td><td><input type="number" min="0" max="10" step="0.1" value="4.0" style="width:70px;border:1px solid #e5e7eb;border-radius:4px;padding:4px 8px;font-size:0.83rem;"/></td><td><button style="background:#7B1F2E;color:#fff;border:none;border-radius:4px;padding:4px 10px;font-size:0.78rem;cursor:pointer;">Salvar</button></td></tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>