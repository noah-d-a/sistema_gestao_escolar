<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php/*
    include "../../includes/menu_secretaria.php";
    include "../conexao.php";

    $vitima = $_GET['vitima'];
    $id = $_GET['id'];

    if ($vitima == "Aluno" || $vitima == "Professor" || $vitima == "Coordenacao" || $vitima == "Secretaria") {
        $comando = "SELECT nome, cpf, rg, data_nascimento, email, telefone, endereco, ativo, data_cadastro FROM usuario WHERE id_usuario = $id";
    } elseif ($vitima == "Turma") {
        $comando = "SELECT nome, ano_letivo, periodo FROM turma WHERE id_turma = $id"
    } elseif ($vitima == "Disciplina") {
        $comando = "SELECT nome, carga_horaria FROM disciplina WHERE id_disciplina = $id"
    }

    $lista = $conexao->query($comando);
    */
    ?>

    <main>
        <ul>
            <?php
            include "../../includes/menu_secretaria.php";

            $id = (int) $_GET['id'];
            $vitima = $_GET['vitima'];

            switch ($vitima) {
                case 'Aluno':
                    switch ($id) {
                        case 100:
                            echo "
                                <li>Nome: João Miguel Cavalcante</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 101:
                            echo "
                                <li>Nome: Maria Eduarda Silva</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 102:
                            echo "
                                <li>Nome: Pedro Henrique Oliveira</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 103:
                            echo "
                                <li>Nome: Ana Clara Santos</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 104:
                            echo "
                                <li>Nome: Lucas Gabriel Costa</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 105:
                            echo "
                                <li>Nome: Beatriz Sophia Rodrigues</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 106:
                            echo "
                                <li>Nome: Gabriel Arthur Mendes</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 107:
                            echo "
                                <li>Nome: Laura Isabela Almeida</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 108:
                            echo "
                                <li>Nome: Miguel Arthur Souza</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 109:
                            echo "
                                <li>Nome: Isabela Luiza Carvalho</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 110:
                            echo "
                                <li>Nome: Arthur Miguel Dias</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 111:
                            echo "
                                <li>Nome: Maria Clara Fernandes</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 112:
                            echo "
                                <li>Nome: Joana Maria Oliveira</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 113:
                            echo "
                                <li>Nome: Josefina Almeida Prestes</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 114:
                            echo "
                                <li>Nome: Ana Clara Santos</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 115:
                            echo "
                                <li>Nome: Pedro Henrique Lima</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 116:
                            echo "
                                <li>Nome: Sofia Carolina Ribeiro</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 117:
                            echo "
                                <li>Nome: Gabriel Arthur Mendes</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 118:
                            echo "
                                <li>Nome: Laura Fonseca Almeida</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 119:
                            echo "
                                <li>Nome: Luiz Gabriel Mendes Costa Fernandez</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 200:
                            echo "
                                <li>Nome: Sofia Helena Martins</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 201:
                            echo "
                                <li>Nome: Rafael Costa Nunes</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 202:
                            echo "
                                <li>Nome: Camila Oliveira Azevedo</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 203:
                            echo "
                                <li>Nome: Thiago Pereira Rocha</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 204:
                            echo "
                                <li>Nome: Júlia Fernandes Andrade</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 205:
                            echo "
                                <li>Nome: Emerson Silva Santos</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 206:
                            echo "
                                <li>Nome: Marina Souza Almeida</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 207:
                            echo "
                                <li>Nome: Bruno Cardoso Reis</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 208:
                            echo "
                                <li>Nome: Larissa Mendes Barbosa</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 209:
                            echo "
                                <li>Nome: Victor Teixeira Lima</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 210:
                            echo "
                                <li>Nome: Isadora Santos Pereira</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 211:
                            echo "
                                <li>Nome: Leonardo Moraes Castro</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 212:
                            echo "
                                <li>Nome: Natália Gonçalves Vieira</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 213:
                            echo "
                                <li>Nome: Matheus Ribeiro Ferreira</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 214:
                            echo "
                                <li>Nome: Gabriela Santos Rocha</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 215:
                            echo "
                                <li>Nome: Eduardo Almeida Costa</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 216:
                            echo "
                                <li>Nome: Beatriz Ferreira Soares</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 217:
                            echo "
                                <li>Nome: Pedro Nascimento Alves</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 218:
                            echo "
                                <li>Nome: Clara Martins Ribeiro</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 219:
                            echo "
                                <li>Nome: Felipe Jesus Oliveira</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 300:
                            echo "
                                <li>Nome: Ana Luiza Moreira</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 301:
                            echo "
                                <li>Nome: Caio Henrique Barros</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 302:
                            echo "
                                <li>Nome: Valentina Rocha Souza</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 303:
                            echo "
                                <li>Nome: Lucas Eduardo Farias</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 304:
                            echo "
                                <li>Nome: Giovanna Costa Lima</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 305:
                            echo "
                                <li>Nome: Enzo Gabriel Souza</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 306:
                            echo "
                                <li>Nome: Helena Maria Pires</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 307:
                            echo "
                                <li>Nome: Igor da Silva</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 308:
                            echo "
                                <li>Nome: Priscila Batista Santos</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 309:
                            echo "
                                <li>Nome: Davi Lucas Martins</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 310:
                            echo "
                                <li>Nome: Renata Almeida Vieira</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 311:
                            echo "
                                <li>Nome: Samuel Nascimento Rocha</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 312:
                            echo "
                                <li>Nome: Yasmin Ferreira Nogueira</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 313:
                            echo "
                                <li>Nome: Pedro Lucas Cunha</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 314:
                            echo "
                                <li>Nome: Manuela Souza Brito</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 315:
                            echo "
                                <li>Nome: João Pedro Santos</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 316:
                            echo "
                                <li>Nome: Letícia Ramos Monteiro</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 317:
                            echo "
                                <li>Nome: Otávio Azevedo Rocha</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 318:
                            echo "
                                <li>Nome: Bianca Ramos Castro</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 319:
                            echo "
                                <li>Nome: Nicolas da Costa</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/2009</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11 )91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;
                    }
                    break;

                case 'Professor':
                    switch ($id) {
                        case 20:
                            echo "
                                <li>Nome: Maria da Silva Santana</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 02/02/1980</li>
                                <li>Email: professor@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11) 91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 21:
                            echo "
                                <li>Nome: Alberto Adriano Antunes</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 02/02/1980</li>
                                <li>Email: professor@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11) 91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 22:
                            echo "
                                <li>Nome: Fabricio Daniel Gudoy Quati</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 02/02/1980</li>
                                <li>Email: professor@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11) 91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 23:
                            echo "
                                <li>Nome: Simone Carvalho Prestes</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 02/02/1980</li>
                                <li>Email: professor@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11) 91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 24:
                            echo "
                                <li>Nome: Flavia Maria Alberta</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 02/02/1980</li>
                                <li>Email: professor@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11) 91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 25:
                            echo "
                                <li>Nome: Cristina Almeida Neves</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 02/02/1980</li>
                                <li>Email: professor@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11) 91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 26:
                            echo "
                                <li>Nome: Francisco de Assis</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 02/02/1980</li>
                                <li>Email: professor@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11) 91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 27:
                            echo "
                                <li>Nome: Mário Ferreira Campos</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 02/02/1980</li>
                                <li>Email: professor@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11) 91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 28:
                            echo "
                                <li>Nome: Gabriel Santos Silva</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 02/02/1980</li>
                                <li>Email: professor@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11) 91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;
                    }
                    break;

                case 'Coordenacao':
                    switch ($id) {
                        case 30:
                            echo "
                                <li>Nome: Sydney Gonzales de Oliveira</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/1975</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11) 91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 31:
                            echo "
                                <li>Nome: Melissa Alves de Souza</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/1975</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11) 91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 32:
                            echo "
                                <li>Nome: Maria da Conceição de Souza</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/1975</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11) 91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;
                    }
                    break;

                case 'Secretaria':
                    switch ($id) {
                        case 40:
                            echo "
                                <li>Nome: Pedro Almeida Cavalcante</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/1975</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11) 91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 41:
                            echo "
                                <li>Nome: Augusto Santana Souza</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/1975</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11) 91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;

                        case 42:
                            echo "
                                <li>Nome: Adriana Lima</li>
                                <li>CPF: 123.456.278-90</li>
                                <li>RG: 12.345.678-9</li>
                                <li>Data de nascimento: 01/01/1975</li>
                                <li>Email: aluno@sistemagestaoescolar.com.br</li>
                                <li>Telefone: (11) 91234-5678</li>
                                <li>Endereço: Estrada da Baronesa, 1965</li>
                                <li>Conta ativa: Sim</li>
                                <li>Data de cadastro: 07/08/2026</li>
                            ";
                            break;
                    }
                    break;

                case 'Turma':
                    switch ($id) {
                        case 1:
                            echo "
                                <li>Nome: 1°A</li>
                                <li>Ano letivo: 2026</li>
                                <li>Período: manhã</li>
                            ";
                            break;

                        case 2:
                            echo "
                                <li>Nome: 2°A</li>
                                <li>Ano letivo: 2026</li>
                                <li>Período: manhã</li>
                            ";
                            break;

                        case 3:
                            echo "
                                <li>Nome: 3°A</li>
                                <li>Ano letivo: 2026</li>
                                <li>Período: manhã</li>
                            ";
                            break;
                    }
                    break;

                case 'Disciplina':
                    switch ($id) {
                        case 1:
                            echo "
                                <li>Nome: Português</li>
                                <li>Carga horária: 50 minutos</li>
                            ";
                            break;

                        case 2:
                            echo "
                                <li>Nome: Matemática</li>
                                <li>Carga horária: 50 minutos</li>
                            ";
                            break;

                        case 3:
                            echo "
                                <li>Nome: Física</li>
                                <li>Carga horária: 50 minutos</li>
                            ";
                            break;

                        case 4:
                            echo "
                                <li>Nome: Química</li>
                                <li>Carga horária: 50 minutos</li>
                            ";
                            break;

                        case 5:
                            echo "
                                <li>Nome: Biologia</li>
                                <li>Carga horária: 50 minutos</li>
                            ";
                            break;

                        case 6:
                            echo "
                                <li>Nome: História</li>
                                <li>Carga horária: 50 minutos</li>
                            ";
                            break;

                        case 7:
                            echo "
                                <li>Nome: Geografia</li>
                                <li>Carga horária: 50 minutos</li>
                            ";
                            break;

                        case 8:
                            echo "
                                <li>Nome: Filosofia</li>
                                <li>Carga horária: 50 minutos</li>
                            ";
                            break;

                        case 9:
                            echo "
                                <li>Nome: Sociologia</li>
                                <li>Carga horária: 50 minutos</li>
                            ";
                            break;
                    }
                    break;
            }
            ?>
        </ul>
    </main>
</body>
</html>