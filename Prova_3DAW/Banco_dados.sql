CREATE DATABASE sistema_gerenciamento DEFAULT CHARSET=utf8mb4;

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
