<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SGE - Mensagens</title>
    <link rel="stylesheet" href="../../css/padronizacao.css"/>
    <style>
        .msg-form { padding:16px; }
        .msg-form label { font-size:0.78rem;font-weight:600;color:#555;display:block;margin-bottom:4px;margin-top:10px; }
        .msg-form input, .msg-form select, .msg-form textarea { width:100%;border:1px solid #e5e7eb;border-radius:6px;padding:8px 12px;font-size:0.84rem;font-family:Inter,sans-serif;outline:none; }
        .msg-form textarea { height:80px;resize:vertical; }
        .msg-form button { background:#7B1F2E;color:#fff;border:none;border-radius:6px;padding:9px 20px;font-size:0.84rem;font-weight:600;cursor:pointer;margin-top:12px; }
    </style>
</head>
<body>
    <?php include '../../includes/menu_professor.php'; ?>
    <main>
        <h1>Mensagens</h1>
        <p>Envie e receba mensagens</p>

        <div class="tabela" style="margin-bottom:14px;">
            <h2>Nova Mensagem</h2>
            <div class="msg-form">
                <label>Destinatário</label>
                <select>
                    <option>Selecione...</option>
                    <option>Coordenação</option>
                    <option>Secretaria</option>
                    <option>Ana Lima — Aluno</option>
                    <option>Carlos Souza — Aluno</option>
                </select>
                <label>Assunto</label>
                <input type="text" placeholder="Digite o assunto"/>
                <label>Mensagem</label>
                <textarea placeholder="Digite sua mensagem..."></textarea>
                <button>Enviar mensagem</button>
            </div>
        </div>

        <div class="tabela">
            <h2>Caixa de Entrada</h2>
            <table>
                <thead>
                    <tr>
                        <th>Remetente</th>
                        <th>Assunto</th>
                        <th>Data</th>
                        <th>Situação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>Coordenação</strong></td><td>Reunião pedagógica — 20/08</td><td>15/08/2026</td><td><span style="background:#fee2e2;color:#991b1b;padding:2px 8px;border-radius:3px;font-size:0.72rem;font-weight:600;">Não lida</span></td></tr>
                    <tr><td><strong>Secretaria</strong></td><td>Atualização de diário de classe</td><td>14/08/2026</td><td><span style="background:#fee2e2;color:#991b1b;padding:2px 8px;border-radius:3px;font-size:0.72rem;font-weight:600;">Não lida</span></td></tr>
                    <tr><td>Coordenação</td><td>Calendário de provas 2026</td><td>10/08/2026</td><td><span style="background:#dcfce7;color:#166534;padding:2px 8px;border-radius:3px;font-size:0.72rem;font-weight:600;">Lida</span></td></tr>
                    <tr><td>Secretaria</td><td>Entrega de planejamento anual</td><td>05/08/2026</td><td><span style="background:#dcfce7;color:#166534;padding:2px 8px;border-radius:3px;font-size:0.72rem;font-weight:600;">Lida</span></td></tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>