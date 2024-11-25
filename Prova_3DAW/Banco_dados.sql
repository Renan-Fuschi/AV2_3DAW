CREATE DATABASE sistema_gerenciamento DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

USE sistema_gerenciamento;

-- Tabela de ônibus
CREATE TABLE onibus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(15) NOT NULL UNIQUE, -- Número do ônibus único
    estado_atual VARCHAR(100) NOT NULL -- Estado atual do ônibus
);

-- Tabela de funcionários
CREATE TABLE funcionarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL, -- Nome do funcionário
    codigo VARCHAR(15) NOT NULL UNIQUE, -- Código único do funcionário
    funcao VARCHAR(50) NOT NULL -- Função ocupada pelo funcionário
);

-- Tabela de usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL -- Armazenar a senha como hash em sistemas reais
);


CREATE TABLE administrador (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL -- Armazenar a senha como hash em sistemas reais
);

-- Inserindo dados na tabela onibus
INSERT INTO onibus (numero, estado_atual)
VALUES
    ('574', 'Novo'),
    ('985', 'Semi-novo'),
    ('023', 'Com alta rotatividade');

-- Inserindo dados na tabela funcionarios
INSERT INTO funcionarios (nome, codigo, funcao)
VALUES
    ('Davi Negão', '171', 'Motorista'),
    ('Jota Pedro', '244', 'Motorista'),
    ('Beatryz Fernandes Dias', '666', 'Atendente');

-- Inserindo dados na tabela usuarios
INSERT INTO usuarios (nome, senha) VALUES
    ('Augusto Macedo', MD5('senha123')), -- Substitua MD5 por hashing mais seguro
    ('Renan Fusca', MD5('123senha')),
    ('Carlos Souza', MD5('car123')),
    ('Ana Costa', MD5('ana456')),
    ('Lucas Pereira', MD5('lucas789'));

INSERT INTO administrador (nome, senha) VALUES
    ('Daniel Marujo', MD5('senha123')), 
    ('Caetano', MD5('123senha')),
    ('Marcelo Souza', MD5('car123')),
    ('Ana Costa', MD5('ana456')),
    ('Lucas Pereira', MD5('lucas789'));


ALTER TABLE funcionarios
ADD COLUMN salario DECIMAL(10, 2),
ADD COLUMN cargo VARCHAR(100)
DROP COLUMN funcao;
