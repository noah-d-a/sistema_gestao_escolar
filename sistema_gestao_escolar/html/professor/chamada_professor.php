<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor | Chamada</title>
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
        .filtros select, .filtros input { border: 1px solid #dfe9f6; border-radius: 8px; padding: 8px 12px; font-size: 0.84rem; outline: none; }
        .filtros button { background: #183f73; color: #fff; border: none; border-radius: 8px; padding: 8px 16px; font-size: 0.84rem; font-weight: bold; cursor: pointer; }
        .chamada-row { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #edf2f9; }
        .chamada-row:last-of-type { border-bottom: none; }
        .aluno-nome { font-size: 0.875rem; font-weight: bold; color: #1f2937; }
        .aluno-rm { font-size: 0.75rem; color: #9ca3af; }
        .btn-presente { background: #eaf7ef; color: #157c3d; border: 1px solid #bbf7d0; border-radius: 999px; padding: 6px 14px; font-size: 0.78rem; font-weight: bold; cursor: pointer; }
        .btn-falta { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; border-radius: 999px; padding: 6px 14px; font-size: 0.78rem; font-weight: bold; cursor: pointer; }
        .btn-salvar { background: #183f73; color: #fff; border: none; border-radius: 8px; padding: 10px 22px; font-size: 0.875rem; font-weight: bold; cursor: pointer; margin-top: 16px; }
    </style>
</head>
<body>
    <?php include '../../includes/menu_professor.php'; ?>
    <main>
        <section class="topo">
            <h1>Chamada</h1>
            <p>Registre a presença dos alunos por aula</p>
        </section>
        <div class="panel">
            <div class="filtros">
                <div><label>Turma</label><select><option>3º Ano A</option><option>2º Ano B</option><option>1º Ano C</option></select></div>
                <div><label>Data</label><input type="date" value="2026-08-17"/></div>
                <button>Buscar</button>
            </div>
            <h2>3º Ano A · 17/08/2026</h2>
            <div class="chamada-row"><div><div class="aluno-nome">Ana Lima</div><div class="aluno-rm">RM-2023001</div></div><div style="display:flex;gap:8px;"><button class="btn-presente">Presente</button><button class="btn-falta">Falta</button></div></div>
            <div class="chamada-row"><div><div class="aluno-nome">Carlos Souza</div><div class="aluno-rm">RM-2023002</div></div><div style="display:flex;gap:8px;"><button class="btn-presente">Presente</button><button class="btn-falta">Falta</button></div></div>
            <div class="chamada-row"><div><div class="aluno-nome">Beatriz Costa</div><div class="aluno-rm">RM-2023003</div></div><div style="display:flex;gap:8px;"><button class="btn-presente">Presente</button><button class="btn-falta">Falta</button></div></div>
            <div class="chamada-row"><div><div class="aluno-nome">Rafael Torres</div><div class="aluno-rm">RM-2023004</div></div><div style="display:flex;gap:8px;"><button class="btn-presente">Presente</button><button class="btn-falta">Falta</button></div></div>
            <div class="chamada-row"><div><div class="aluno-nome">Juliana Neves</div><div class="aluno-rm">RM-2023005</div></div><div style="display:flex;gap:8px;"><button class="btn-presente">Presente</button><button class="btn-falta">Falta</button></div></div>
            <div style="text-align:right;"><button class="btn-salvar">Salvar chamada</button></div>
        </div>
    </main>
</body>
</html>