<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sistema de Gestão Escolar</title>

  <link rel="stylesheet" href="css/login.css"/>
</head>
<body>

  <div class="card">
    <h1>Sistema de Gestão Escolar</h1>
    <p>Acesso restrito a membros da instituição.</p>

    <label>E-mail</label>
    <input type="email" placeholder="seu@email.com"/>

    <label>Senha</label>
    <input type="password" placeholder="••••••••"/>
    <a class="esqueci" href="#">Esqueci minha senha</a>

    <label>Perfil</label>
    <select id="perfil">
      <option value="" disabled selected>Selecione seu perfil</option>
      <option>Aluno</option>
      <option>Professor</option>
      <option>Coordenação</option>
      <option>Secretaria</option>
    </select>

    <button onclick="entrar()">Entrar</button>
  </div>

  <script>
    function entrar() {
      const perfil = document.getElementById('perfil').value;

      if (perfil === 'Aluno')            window.location.href = 'html/aluno/inicio_aluno.php';
      else if (perfil === 'Professor')   window.location.href = 'html/professor/inicio_professor.php';
      else if (perfil === 'Coordenação') window.location.href = 'html/coordenacao/inicio_coordenacao.php';
      else if (perfil === 'Secretaria')  window.location.href = 'html/secretaria/inicio_secretaria.php';
      else alert('Selecione um perfil para continuar.');
    }
  </script>

</body>
</html>
