<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Secretaria');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria | Cadastros</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box}body{margin:0;background:#f7f8fc;color:#202338;font-family:Inter,Arial,sans-serif}main{max-width:1240px;margin:0 auto;padding:48px 40px 80px}h1,h2,h3{letter-spacing:-.04em}.cabecalho{margin:0 0 34px}.cabecalho:before{content:'INSTITUTO ATLAS / SECRETARIA';display:block;color:#6664df;font-size:11px;font-weight:800;letter-spacing:.14em;margin-bottom:11px}.cabecalho h1{font-size:clamp(29px,3vw,38px);line-height:1.12;margin:0}.cabecalho p{max-width:650px;margin:12px 0 0;color:#777d93;font-size:14px;line-height:1.65}.lista{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:20px}.item{min-height:210px;display:flex;flex-direction:column;text-decoration:none;padding:28px;background:#fff;border:1px solid #e5e7f0;border-radius:18px;color:#252741;box-shadow:0 8px 26px #1b224006;transition:.18s ease}.item:hover{border-color:#aaa8ff;transform:translateY(-3px);box-shadow:0 16px 34px #35307b0d}.icon{width:48px;height:48px;border-radius:13px;background:#efeeff;color:#625fe0;display:grid;place-items:center;margin-bottom:25px}.icon svg{width:23px;height:23px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}.tipo{font-size:10px;letter-spacing:.14em;color:#6664df;font-weight:800;text-transform:uppercase;margin-bottom:8px}.item h3{font-size:20px;margin:0 0 9px}.item p{font-size:13px;line-height:1.65;color:#777d93;margin:0}.item .go{margin-top:auto;padding-top:20px;color:#5d59d8;font-size:12px;font-weight:750}.item .go:after{content:'  →'}.item:focus-visible{outline:3px solid #b6b4ff;outline-offset:2px}@media(max-width:980px){.lista{grid-template-columns:repeat(2,1fr)}}@media(max-width:800px){main{padding:78px 20px 50px}}@media(max-width:580px){.lista{grid-template-columns:1fr}.item{min-height:185px}}
</style>
</head>
<body>
    <?php include "../../includes/menu_secretaria.php"; ?>

    <main>
        <section class="cabecalho"><h1>Cadastros</h1><p>Gerencie usuários, turmas e disciplinas da instituição em um só lugar.</p></section>

        <section class="lista">
            <a class="item" href="acoes_secretaria.php?tipo=aluno">
                <div class="tipo">Usuário</div>
                <div class="icon"><svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg></div><h3>Alunos</h3>
                <p>Matrícula, turma, frequência e dados pessoais.</p><span class="go">Gerenciar</span>
            </a>

            <a class="item" href="acoes_secretaria.php?tipo=professor">
                <div class="tipo">Usuário</div>
                <div class="icon"><svg viewBox="0 0 24 24"><path d="M22 10 12 5 2 10l10 5 10-5Z"/><path d="M6 12v5c3 2 9 2 12 0v-5"/></svg></div><h3>Professores</h3>
                <p>Dados de docentes, disciplinas, horários e carga horária.</p><span class="go">Gerenciar</span>
            </a>

            <a class="item" href="acoes_secretaria.php?tipo=coordenacao">
                <div class="tipo">Usuário</div>
                <div class="icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21v-2a6 6 0 0 1 12 0v2M18 8h4M20 6v4"/></svg></div><h3>Coordenação</h3>
                <p>Gestores, supervisores e responsáveis pela instituição.</p><span class="go">Gerenciar</span>
            </a>

            <a class="item" href="acoes_secretaria.php?tipo=secretaria">
                <div class="tipo">Usuário</div>
                <div class="icon"><svg viewBox="0 0 24 24"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 7h8M8 11h8M8 15h5"/></svg></div><h3>Secretaria</h3>
                <p>Funcionários administrativos e processos internos.</p><span class="go">Gerenciar</span>
            </a>

            <a class="item" href="acoes_secretaria.php?tipo=turma">
                <div class="tipo">Componente</div>
                <div class="icon"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 8h10M7 12h6M7 16h8"/></svg></div><h3>Turmas</h3>
                <p>Manter turma, turno, série e organização letiva.</p><span class="go">Gerenciar</span>
            </a>

            <a class="item" href="acoes_secretaria.php?tipo=disciplina">
                <div class="tipo">Componente</div>
                <div class="icon"><svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V4H6.5A2.5 2.5 0 0 0 4 6.5v13Z"/><path d="M8 8h8M8 12h6"/></svg></div><h3>Disciplinas</h3>
                <p>Controle de matérias e carga horária por turma.</p><span class="go">Gerenciar</span>
            </a>
        </section>
    </main>
</body>
</html>