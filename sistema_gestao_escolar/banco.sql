CREATE DATABASE IF NOT EXISTS `sistema_gestao_escolar`;

USE `sistema_gestao_escolar`;

CREATE TABLE `usuario` (
    `id_usuario` INT AUTO_INCREMENT PRIMARY KEY,
    `perfil` ENUM('Aluno', 'Professor', 'Coordenação', 'Secretaria') NOT NULL,
    `nome` VARCHAR(100) NOT NULL,
    `cpf` CHAR(11) UNIQUE,
    `rg` VARCHAR(20),
    `data_nascimento` DATE,
    `email` VARCHAR(100) UNIQUE,
    `senha` VARCHAR(255) NOT NULL,
    `telefone` VARCHAR(20),
    `endereco` VARCHAR(200),
    `ativo` BOOLEAN DEFAULT TRUE,
    `data_cadastro` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `turma` (
    `id_turma` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(50) NOT NULL,
    `ano_letivo` YEAR NOT NULL,
    `periodo` ENUM('Manhã','Tarde','Noite') NOT NULL
);

CREATE TABLE `disciplina` (
    `id_disciplina` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(100) NOT NULL,
    `carga_horaria` INT NOT NULL
);

CREATE TABLE `professor_disciplina` (
    `id_professor_disciplina` INT AUTO_INCREMENT PRIMARY KEY,
    `id_professor` INT NOT NULL,
    `id_disciplina` INT NOT NULL,
    FOREIGN KEY (`id_professor`) REFERENCES `usuario`(`id_usuario`),
    FOREIGN KEY (`id_disciplina`) REFERENCES `disciplina`(`id_disciplina`)
);

CREATE TABLE `turma_disciplina` (
    `id_turma_disciplina` INT AUTO_INCREMENT PRIMARY KEY,
    `id_turma` INT NOT NULL,
    `id_disciplina` INT NOT NULL,
    `id_professor` INT NOT NULL,
    FOREIGN KEY (`id_turma`) REFERENCES `turma`(`id_turma`),
    FOREIGN KEY (`id_disciplina`) REFERENCES `disciplina`(`id_disciplina`),
    FOREIGN KEY (`id_professor`) REFERENCES `usuario`(`id_usuario`)
);

CREATE TABLE `matricula` (
    `id_matricula` INT AUTO_INCREMENT PRIMARY KEY,
    `rm` VARCHAR(20) UNIQUE NOT NULL,
    `id_aluno` INT NOT NULL,
    `id_turma` INT NOT NULL,
    `data_matricula` DATE NOT NULL,
    FOREIGN KEY (`id_aluno`) REFERENCES `usuario`(`id_usuario`),
    FOREIGN KEY (`id_turma`) REFERENCES `turma`(`id_turma`)
);

CREATE TABLE `horario` (
    `id_horario` INT AUTO_INCREMENT PRIMARY KEY,
    `id_turma_disciplina` INT NOT NULL,
    `dia_semana` ENUM('Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta') NOT NULL,
    `hora_inicio` TIME NOT NULL,
    `hora_fim` TIME NOT NULL,
    FOREIGN KEY (`id_turma_disciplina`) REFERENCES `turma_disciplina`(`id_turma_disciplina`)
);

CREATE TABLE `frequencia` (
    `id_frequencia` INT AUTO_INCREMENT PRIMARY KEY,
    `id_matricula` INT NOT NULL,
    `id_turma_disciplina` INT NOT NULL,
    `data_aula` DATE NOT NULL,
    `presente` BOOLEAN NOT NULL,
    FOREIGN KEY (`id_matricula`) REFERENCES `matricula`(`id_matricula`),
    FOREIGN KEY (`id_turma_disciplina`) REFERENCES `turma_disciplina`(`id_turma_disciplina`)
);

CREATE TABLE `nota` (
    `id_nota` INT AUTO_INCREMENT PRIMARY KEY,
    `id_matricula` INT NOT NULL,
    `id_turma_disciplina` INT NOT NULL,
    `avaliacao` VARCHAR(100),
    `nota` DECIMAL(4,2) NOT NULL,
    `data_lancamento` DATE,
    FOREIGN KEY (`id_matricula`) REFERENCES `matricula`(`id_matricula`),
    FOREIGN KEY (`id_turma_disciplina`) REFERENCES `turma_disciplina`(`id_turma_disciplina`)
);

CREATE TABLE `mensagem` (
    `id_mensagem` INT AUTO_INCREMENT PRIMARY KEY,
    `remetente` INT NOT NULL,
    `destinatario` INT NOT NULL,
    `assunto` VARCHAR(100),
    `conteudo` TEXT NOT NULL,
    `data_envio` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `lida` BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (`remetente`) REFERENCES `usuario`(`id_usuario`),
    FOREIGN KEY (`destinatario`) REFERENCES `usuario`(`id_usuario`)
);

CREATE TABLE `questionario` (
    `id_questionario` INT AUTO_INCREMENT PRIMARY KEY,
    `titulo` VARCHAR(100) NOT NULL,
    `descricao` TEXT,
    `criado_por` INT NOT NULL,
    `data_criacao` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`criado_por`) REFERENCES `usuario`(`id_usuario`)
);

CREATE TABLE `pergunta` (
    `id_pergunta` INT AUTO_INCREMENT PRIMARY KEY,
    `id_questionario` INT NOT NULL,
    `enunciado` TEXT NOT NULL,
    FOREIGN KEY (`id_questionario`) REFERENCES `questionario`(`id_questionario`)
);

CREATE TABLE `resposta` (
    `id_resposta` INT AUTO_INCREMENT PRIMARY KEY,
    `id_pergunta` INT NOT NULL,
    `id_usuario` INT NOT NULL,
    `resposta` TEXT NOT NULL,
    FOREIGN KEY (`id_pergunta`) REFERENCES `pergunta`(`id_pergunta`),
    FOREIGN KEY (`id_usuario`) REFERENCES `usuario`(`id_usuario`)
);