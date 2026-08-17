<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SGE - Chamada</title>
    <link rel="stylesheet" href="../../css/padronizacao.css"/>
    <style>
        .btn-presente { background:#dcfce7;color:#166534;border:1px solid #bbf7d0;border-radius:4px;padding:5px 12px;font-size:0.78rem;font-weight:600;cursor:pointer; }
        .btn-falta    { background:#fee2e2;color:#991b1b;border:1px solid #fecaca;border-radius:4px;padding:5px 12px;font-size:0.78rem;font-weight:600;cursor:pointer; }
        .btn-salvar   { background:#7B1F2E;color:#fff;border:none;border-radius:6px;padding:9px 20px;font-size:0.84rem;font-weight:600;cursor:pointer;margin-top:14px; }
        .chamada-row  { display:flex;align-items:center;justify-content:space-between;padding:10px 14px;border-bottom:1px solid #e5e7eb; }
        .chamada-row:last-of-type { border-bottom:none; }
        .aluno-info .rm { font-size:0.72rem;color:#9ca3af; }
        .aluno-info .nome { font-size:0.84rem;font-weight:600;color:#2d2d2d; }
    </style>
</head>
<body>
    <?php include '../../includes/menu_professor.php'; ?>
    <main>
        <h1>Chamada</h1>
        <p>Registre a presença dos alunos por aula</p>

        <div class="tabela" style="padding:14px;margin-bottom:14px;">
            <div style="display:flex;gap:12px;align-items:flex-end;">
                <div>
                    <label style="font-size:0.78rem;font-weight:600;color:#555;display:block;margin-bottom:4px;">Turma</label>
                    <select style="border:1px solid #e5e7eb;border-radius:6px;padding:8px 12px;font-size:0.84rem;font-family:Inter,sans-serif;outline:none;">
                        <option>3º Ano A</option>
                        <option>2º Ano B</option>
                        <option>1º Ano C</option>
                    </select>
                </div>
                <div>
                    <label style="font-size:0.78rem;font-weight:600;color:#555;display:block;margin-bottom:4px;">Data</label>
                    <input type="date" value="2026-08-16" style="border:1px solid #e5e7eb;border-radius:6px;padding:8px 12px;font-size:0.84rem;font-family:Inter,sans-serif;outline:none;"/>
                </div>
                <button style="background:#7B1F2E;color:#fff;border:none;border-radius:6px;padding:8px 16px;font-size:0.84rem;font-weight:600;cursor:pointer;">Buscar</button>
            </div>
        </div>

        <div class="tabela">
            <h2>Chamada — 3º Ano A · 16/08/2026</h2>
            <div class="chamada-row">
                <div class="aluno-info"><div class="nome">Ana Lima</div><div class="rm">RM-2023001</div></div>
                <div style="display:flex;gap:8px;"><button class="btn-presente">Presente</button><button class="btn-falta">Falta</button></div>
            </div>
            <div class="chamada-row">
                <div class="aluno-info"><div class="nome">Carlos Souza</div><div class="rm">RM-2023002</div></div>
                <div style="display:flex;gap:8px;"><button class="btn-presente">Presente</button><button class="btn-falta">Falta</button></div>
            </div>
            <div class="chamada-row">
                <div class="aluno-info"><div class="nome">Beatriz Costa</div><div class="rm">RM-2023003</div></div>
                <div style="display:flex;gap:8px;"><button class="btn-presente">Presente</button><button class="btn-falta">Falta</button></div>
            </div>
            <div class="chamada-row">
                <div class="aluno-info"><div class="nome">Rafael Torres</div><div class="rm">RM-2023004</div></div>
                <div style="display:flex;gap:8px;"><button class="btn-presente">Presente</button><button class="btn-falta">Falta</button></div>
            </div>
            <div class="chamada-row">
                <div class="aluno-info"><div class="nome">Juliana Neves</div><div class="rm">RM-2023005</div></div>
                <div style="display:flex;gap:8px;"><button class="btn-presente">Presente</button><button class="btn-falta">Falta</button></div>
            </div>
            <div style="padding:0 14px 14px;text-align:right;">
                <button class="btn-salvar">Salvar chamada</button>
            </div>
        </div>
    </main>
</body>
</html>