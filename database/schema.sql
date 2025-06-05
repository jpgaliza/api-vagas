-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS api_vagas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE api_vagas;

-- Tabela de vagas
CREATE TABLE IF NOT EXISTS vagas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    empresa VARCHAR(255) NOT NULL,
    localizacao VARCHAR(255),
    salario DECIMAL(10,2),
    tipo_contrato ENUM('CLT', 'PJ', 'Estágio', 'Temporário', 'Freelance') DEFAULT 'CLT',
    requisitos TEXT,
    beneficios TEXT,
    data_publicacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('ativa', 'inativa', 'pausada') DEFAULT 'ativa',
    INDEX idx_status (status),
    INDEX idx_data_publicacao (data_publicacao)
);

-- Tabela de candidaturas
CREATE TABLE IF NOT EXISTS candidaturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vaga_id INT NOT NULL,
    nome_candidato VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    curriculo TEXT,
    data_candidatura DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pendente', 'em_analise', 'aprovado', 'rejeitado') DEFAULT 'pendente',
    FOREIGN KEY (vaga_id) REFERENCES vagas(id) ON DELETE CASCADE,
    INDEX idx_vaga_id (vaga_id),
    INDEX idx_email (email),
    INDEX idx_status (status),
    UNIQUE KEY unique_candidatura (vaga_id, email)
);

-- Inserir algumas vagas de exemplo
INSERT INTO vagas (titulo, descricao, empresa, localizacao, salario, tipo_contrato, requisitos, beneficios) VALUES
('Desenvolvedor Full Stack', 'Desenvolvimento de aplicações web utilizando tecnologias modernas como React, Node.js e banco de dados.', 'TechCorp Solutions', 'São Paulo - SP', 8000.00, 'CLT', 'Experiência com JavaScript, React, Node.js, SQL. Conhecimento em Git e metodologias ágeis.', 'Vale alimentação, Vale transporte, Plano de saúde, Flexibilidade de horário'),

('Analista de Marketing Digital', 'Criação e execução de campanhas de marketing digital, análise de métricas e otimização de performance.', 'Marketing Pro', 'Rio de Janeiro - RJ', 5500.00, 'CLT', 'Experiência com Google Ads, Facebook Ads, Analytics. Conhecimento em SEO e redes sociais.', 'Vale alimentação, Plano de saúde, Curso de idiomas, Home office'),

('Designer UX/UI', 'Design de interfaces de usuário e experiência do usuário para aplicações web e mobile.', 'Design Studio', 'Remoto', 6000.00, 'PJ', 'Experiência com Figma, Adobe XD, Photoshop. Portfolio com projetos de UX/UI. Conhecimento em Design Thinking.', 'Flexibilidade total de horário, Equipamentos fornecidos'),

('Estágio em Desenvolvimento', 'Oportunidade para estudantes de Ciência da Computação ou áreas afins aprenderem desenvolvimento web.', 'StartupTech', 'Belo Horizonte - MG', 1500.00, 'Estágio', 'Cursando Ciência da Computação, Engenharia ou similar. Conhecimento básico em programação.', 'Vale transporte, Auxílio alimentação, Mentoria técnica');
