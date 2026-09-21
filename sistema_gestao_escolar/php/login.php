<?php
session_start();
require 'includes/conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($email) || empty($senha)) {
        $erro = 'Email e senha são obrigatórios.';
    } else {
        // Consultar usuário no banco
        $stmt = $conexao->prepare("SELECT id_usuario, perfil, nome FROM usuario WHERE email = ? AND senha = ? AND ativo = 1");
        $stmt->bind_param("ss", $email, $senha);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();
            
            // Iniciar sessão com dados do usuário
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['perfil'] = $usuario['perfil'];
            $_SESSION['nome'] = $usuario['nome'];

            // Redirecionar conforme perfil
            switch ($usuario['perfil']) {
                case 'Aluno':
                    header('Location: php/aluno/inicio_aluno.php');
                    break;
                case 'Professor':
                    header('Location: php/professor/inicio_professor.php');
                    break;
                case 'Coordenação':
                    header('Location: php/coordenacao/inicio_coordenacao.php');
                    break;
                case 'Secretaria':
                    header('Location: php/secretaria/inicio_secretaria.php');
                    break;
            }
            exit();
        } else {
            $erro = 'Email ou senha incorretos.';
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sistema de Gestão Escolar</title>

  <link rel="stylesheet" href="css/login.css"/>
</head>
<body>
  <form method="POST">
    <img src="imgs/logo.png" alt="Instituto Atlas"/>
    <h1>Instituto Atlas</h1>

    <?php if ($erro): ?>
      <div style="background: #fee; color: #c33; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.9rem;">
        <?php echo htmlspecialchars($erro); ?>
      </div>
    <?php endif; ?>

    <label>E-mail</label>
    <input type="email" name="email" placeholder="E-mail" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"/>

    <label>Senha</label>
    <input type="password" name="senha" placeholder="Senha" required/>
    <a class="esqueci" href="#">Esqueci minha senha</a>

    <button type="submit">Entrar</button>
  </form>
</body>
</html>