<style>
    body {
        margin: 0;
        padding-left: 230px;
        background: #f3f6fb;
        font-family: Arial, sans-serif;
    }

    #menu {
        position: fixed;
        top: 0;
        left: 0;
        width: 230px;
        height: 100vh;
        background: linear-gradient(180deg, #0b1f3a 0%, #123660 100%);
        color: #fff;
        box-shadow: 3px 0 18px rgba(11, 31, 58, 0.25);
        padding: 18px 14px;
        box-sizing: border-box;
    }

    #menu .brand {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
        padding: 10px 8px 16px;
        border-bottom: 1px solid rgba(255,255,255,0.12);
    }

    #menu .brand img {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: rgba(255,255,255,0.1);
        padding: 4px;
    }

    #menu .brand span {
        font-size: 0.92rem;
        font-weight: bold;
        letter-spacing: 0.04em;
    }

    #menu ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    #menu li {
        margin: 6px 0;
    }

    #menu a {
        display: block;
        padding: 12px 14px;
        border-radius: 10px;
        color: #dfeafc;
        text-decoration: none;
        font-weight: 600;
        transition: 0.2s ease;
    }

    #menu a:hover {
        background: rgba(255,255,255,0.09);
        color: #fff;
    }

    @media (max-width: 768px) {
        body {
            padding-left: 0;
        }

        #menu {
            position: relative;
            width: 100%;
            height: auto;
        }
    }
</style>
<nav id="menu">
    <div class="brand">
        <img src="../../imgs/logo.png" alt="Instituto Atlas" />
        <span>Instituto Atlas</span>
    </div>
    <ul>
        <li><a href="inicio_secretaria.php">Início</a></li>
        <li><a href="cadastro_secretaria.php">Cadastro</a></li>
        <li><a href="cadastros_secretaria.php">Cadastros</a></li>
        <li><a href="relacoes_secretaria.php">Relações</a></li>
        <li><a href="editar_horario_secretaria.php">Horários</a></li>
        <li><a href="questionarios_secretaria.php">Questionários</a></li>
        <li><a href="mensagens_secretaria.php">Mensagens</a></li>
    </ul>
</nav>
