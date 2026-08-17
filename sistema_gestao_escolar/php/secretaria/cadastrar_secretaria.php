<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    include "../../includes/menu_secretaria.php";
    include "../conexao.php";

    $vitima = $_GET['vitima'];

    switch ($vitima) {
        case 'Aluno':
            $sucesso = false;

            echo "
            <main>
                <h1>Cadastrar aluno</h1>
                <form action='.' method='POST' enctype='multipart/form-data'>
                    <label for='nome'>Nome: </label>
                    <input type='text' name='nome' required>

                    <br><br>

                    <label for='cpf'>CPF: </label>
                    <input type='text' name='cpf' required>

                    <br><br>

                    <label for='rg'>RG: </label>
                    <input type='text' name='rg' required>

                    <br><br>

                    <label for='dataNascimento'>Data de nascimento: </label>
                    <input type='date' name='dataNascimento' required>

                    <br><br>

                    <label for='email'>E-mail: </label>
                    <input type='email' name='email' required>

                    <br><br>

                    <label for='senha'>Senha: </label>
                    <input type='password' name='senha' required>

                    <br><br>

                    <label for='telefone'>Telefone: </label>
                    <input type='text' name='telefone' required>

                    <br><br>

                    <label for='endereco'>Endereço: </label>
                    <input type='text' name='endereco' required>

                    <br><br>

                    <div id='botoes'>
                        <input type='submit' value='Enviar'>
                        <input type='reset' value='Limpar'>
                    </div>
                </form>

                <p id='sucesso'>'. ($sucesso ? 'Sucesso!' : '') .'</p>
            </main>
            ";

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nome = $_POST['nome'];
                $cpf = $_POST['cpf'];
                $rg = $_POST['rg'];
                $dataNascimento = $_POST['dataNascimento'];
                $email = $_POST['email'];
                $senha = $_POST['senha'];
                $telefone = $_POST['telefone'];
                $endereco = $_POST['endereco'];

                $comando = "
                INSERT INTO turma (id_usuario, perfil, nome, cpf, rg, data_nascimento, email, senha, telefone, endereco, ativo)
                VALUES (NULL, 'Aluno', '$nome', '$cpf', '$rg', '$dataNascimento', '$email', '$senha', '$telefone', '$endereco', false)
                ";
                $insert = $conexao->query($comando);

                $sucesso = true;
            }
            break;
        
        case 'Professor':
            $sucesso = false;

            echo "
            <main>
                <h1>Cadastrar professor</h1>
                <form action='.' method='POST' enctype='multipart/form-data'>
                    <label for='nome'>Nome: </label>
                    <input type='text' name='nome' required>

                    <br><br>

                    <label for='cpf'>CPF: </label>
                    <input type='text' name='cpf' required>

                    <br><br>

                    <label for='rg'>RG: </label>
                    <input type='text' name='rg' required>

                    <br><br>

                    <label for='dataNascimento'>Data de nascimento: </label>
                    <input type='date' name='dataNascimento' required>

                    <br><br>

                    <label for='email'>E-mail: </label>
                    <input type='email' name='email' required>

                    <br><br>

                    <label for='senha'>Senha: </label>
                    <input type='password' name='senha' required>

                    <br><br>

                    <label for='telefone'>Telefone: </label>
                    <input type='text' name='telefone' required>

                    <br><br>

                    <label for='endereco'>Endereço: </label>
                    <input type='text' name='endereco' required>

                    <br><br>

                    <div id='botoes'>
                        <input type='submit' value='Enviar'>
                        <input type='reset' value='Limpar'>
                    </div>
                </form>

                <p>'. ($sucesso ? 'Sucesso' : '') .'</p>
            </main>
            ";

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nome = $_POST['nome'];
                $cpf = $_POST['cpf'];
                $rg = $_POST['rg'];
                $dataNascimento = $_POST['dataNascimento'];
                $email = $_POST['email'];
                $senha = $_POST['senha'];
                $telefone = $_POST['telefone'];
                $endereco = $_POST['endereco'];

                $comando = "
                INSERT INTO turma (id_usuario, perfil, nome, cpf, rg, data_nascimento, email, senha, telefone, endereco, ativo)
                VALUES (NULL, 'Professor', '$nome', '$cpf', '$rg', '$dataNascimento', '$email', '$senha', '$telefone', '$endereco', false)
                ";
                $insert = $conexao->query($comando);

                $sucesso = true;
            }
            break;

        case 'Coordenacao':
            $sucesso = false;

            echo "
            <main>
                <h1>Cadastrar membro da coordenação</h1>
                <form action='.' method='POST' enctype='multipart/form-data'>
                    <label for='nome'>Nome: </label>
                    <input type='text' name='nome' required>

                    <br><br>

                    <label for='cpf'>CPF: </label>
                    <input type='text' name='cpf' required>

                    <br><br>

                    <label for='rg'>RG: </label>
                    <input type='text' name='rg' required>

                    <br><br>

                    <label for='dataNascimento'>Data de nascimento: </label>
                    <input type='date' name='dataNascimento' required>

                    <br><br>

                    <label for='email'>E-mail: </label>
                    <input type='email' name='email' required>

                    <br><br>

                    <label for='senha'>Senha: </label>
                    <input type='password' name='senha' required>

                    <br><br>

                    <label for='telefone'>Telefone: </label>
                    <input type='text' name='telefone' required>

                    <br><br>

                    <label for='endereco'>Endereço: </label>
                    <input type='text' name='endereco' required>

                    <br><br>

                    <div id='botoes'>
                        <input type='submit' value='Enviar'>
                        <input type='reset' value='Limpar'>
                    </div>
                </form>

                <p>'. ($sucesso ? 'Sucesso' : '') .'</p>
            </main>
            ";

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nome = $_POST['nome'];
                $cpf = $_POST['cpf'];
                $rg = $_POST['rg'];
                $dataNascimento = $_POST['dataNascimento'];
                $email = $_POST['email'];
                $senha = $_POST['senha'];
                $telefone = $_POST['telefone'];
                $endereco = $_POST['endereco'];

                $comando = "
                INSERT INTO turma (id_usuario, perfil, nome, cpf, rg, data_nascimento, email, senha, telefone, endereco, ativo)
                VALUES (NULL, 'Coordenação', '$nome', '$cpf', '$rg', '$dataNascimento', '$email', '$senha', '$telefone', '$endereco', false)
                ";
                $insert = $conexao->query($comando);

                $sucesso = true;
            }
            break;
        
        case 'Secretaria':
            $sucesso = false;

            echo "
            <main>
                <h1>Cadastrar membro da secretaria</h1>
                <form action='.' method='POST' enctype='multipart/form-data'>
                    <label for='nome'>Nome: </label>
                    <input type='text' name='nome' required>

                    <br><br>

                    <label for='cpf'>CPF: </label>
                    <input type='text' name='cpf' required>

                    <br><br>

                    <label for='rg'>RG: </label>
                    <input type='text' name='rg' required>

                    <br><br>

                    <label for='dataNascimento'>Data de nascimento: </label>
                    <input type='date' name='dataNascimento' required>

                    <br><br>

                    <label for='email'>E-mail: </label>
                    <input type='email' name='email' required>

                    <br><br>

                    <label for='senha'>Senha: </label>
                    <input type='password' name='senha' required>

                    <br><br>

                    <label for='telefone'>Telefone: </label>
                    <input type='text' name='telefone' required>

                    <br><br>

                    <label for='endereco'>Endereço: </label>
                    <input type='text' name='endereco' required>

                    <br><br>

                    <div id='botoes'>
                        <input type='submit' value='Enviar'>
                        <input type='reset' value='Limpar'>
                    </div>
                </form>

                <p>'. ($sucesso ? 'Sucesso' : '') .'</p>
            </main>
            ";

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nome = $_POST['nome'];
                $cpf = $_POST['cpf'];
                $rg = $_POST['rg'];
                $dataNascimento = $_POST['dataNascimento'];
                $email = $_POST['email'];
                $senha = $_POST['senha'];
                $telefone = $_POST['telefone'];
                $endereco = $_POST['endereco'];

                $comando = "
                INSERT INTO turma (id_usuario, perfil, nome, cpf, rg, data_nascimento, email, senha, telefone, endereco, ativo)
                VALUES (NULL, 'Secretaria', '$nome', '$cpf', '$rg', '$dataNascimento', '$email', '$senha', '$telefone', '$endereco', false)
                ";
                $insert = $conexao->query($comando);

                $sucesso = true;
            }
            break;
        
        case 'Turma':
            $sucesso = false;

            echo "
            <main>
                <h1>Cadastrar turma</h1>
                <form action='.' method='POST' enctype='multipart/form-data'>
                    <label for='nome'>Nome: </label>
                    <input type='text' name='nome' required>

                    <br><br>

                    <label for='anoLetivo'>Ano letivo: </label>
                    <input type='number' name='anoLetivo' required>

                    <br><br>

                    <label for='periodo'>Período: </label>
                    <select name='periodo'>
                        <option value='manha'>Manhã</option>
                        <option value='tarde'>Tarde</option>
                        <option value='noite'>Noite</option>
                    </select>

                    <br><br>

                    <div id='botoes'>
                        <input type='reset' value='Limpar'>
                        <input type='submit' value='Enviar'>
                    </div>
                </form>

                <p>'. ($sucesso ? 'Sucesso' : '') .'</p>
            </main>
            ";

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nome = $_POST['nome'];
                $anoLetivo = $_POST['anoLetivo'];
                $periodo = $_POST['periodo'];

                $comando = "INSERT INTO turma (id_turma, nome, ano_letivo, periodo) VALUES (NULL, '$nome', '$anoLetivo', '$periodo')";
                $insert = $conexao->query($comando);

                $sucesso = true;
            }
            break;
        
        case 'Disciplina':
            $sucesso = false;

            echo "
            <main>
                <h1>Cadastrar disciplina</h1>
                <form action='.' method='POST' enctype='multipart/form-data'>
                    <label for='nome'>Nome: </label>
                    <input type='text' name='nome' required>

                    <br><br>

                    <label for='cargaHoraria'>Carga horária: </label>
                    <input type='number' name='cargaHoraria' required>

                    <br><br>

                    <div id='botoes'>
                        <input type='submit' value='Enviar'>
                        <input type='reset' value='Limpar'>
                    </div>
                </form>

                <p>'. ($sucesso ? 'Sucesso' : '') .'</p>
            </main>
            ";

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nome = $_POST['nome'];
                $cargaHoraria = $_POST['cargaHoraria'];

                $comando = "INSERT INTO disciplina (id_disciplina, nome, carga_horaria) VALUES (NULL, '$nome', '$cargaHoraria')";
                $insert = $conexao->query($comando);

                $sucesso = true;
            }
            break;
    }
    ?>
</body>
</html>