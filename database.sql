-- Script para criação do banco de dados e tabelas da API de Vagas

CREATE DATABASE IF NOT EXISTS api_vagas;
USE api_vagas;

-- Tabela de vagas
CREATE TABLE IF NOT EXISTS vagas (
    id VARCHAR(36) PRIMARY KEY,
    empresa VARCHAR(255) NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    localizacao CHAR(1) NOT NULL,
    nivel INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_localizacao_vaga CHECK (localizacao IN ('A', 'B', 'C', 'D', 'E', 'F')),
    CONSTRAINT chk_nivel_vaga CHECK (nivel BETWEEN 1 AND 5)
);

-- Tabela de pessoas
CREATE TABLE IF NOT EXISTS pessoas (
    id VARCHAR(36) PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    profissao VARCHAR(255) NOT NULL,
    localizacao CHAR(1) NOT NULL,
    nivel INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_localizacao_pessoa CHECK (localizacao IN ('A', 'B', 'C', 'D', 'E', 'F')),
    CONSTRAINT chk_nivel_pessoa CHECK (nivel BETWEEN 1 AND 5)
);

-- Tabela de candidaturas
CREATE TABLE IF NOT EXISTS candidaturas (
    id VARCHAR(36) PRIMARY KEY,
    id_vaga VARCHAR(36) NOT NULL,
    id_pessoa VARCHAR(36) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_vaga) REFERENCES vagas(id) ON DELETE CASCADE,
    FOREIGN KEY (id_pessoa) REFERENCES pessoas(id) ON DELETE CASCADE,
    UNIQUE KEY unique_candidatura (id_vaga, id_pessoa)
);
