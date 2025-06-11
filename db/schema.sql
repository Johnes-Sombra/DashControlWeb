-- Banco de dados de autenticação
CREATE DATABASE IF NOT EXISTS auth_db;
USE auth_db;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT true
);

-- Banco de dados principal
CREATE DATABASE IF NOT EXISTS coopsul_db;
USE coopsul_db;

-- Tabela de Cooperados
CREATE TABLE cooperados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) UNIQUE NOT NULL,
    data_nascimento DATE NOT NULL,
    endereco TEXT NOT NULL,
    bairro VARCHAR(50),
    cidade VARCHAR(50) NOT NULL,
    estado CHAR(2) NOT NULL,
    cep VARCHAR(9),
    telefone VARCHAR(15),
    email VARCHAR(100),
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ativo BOOLEAN DEFAULT true
);

-- Tabela de Empresas
CREATE TABLE empresas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    razao_social VARCHAR(150) NOT NULL,
    nome_fantasia VARCHAR(150),
    cnpj VARCHAR(18) UNIQUE NOT NULL,
    endereco TEXT NOT NULL,
    bairro VARCHAR(50),
    cidade VARCHAR(50) NOT NULL,
    estado CHAR(2) NOT NULL,
    cep VARCHAR(9),
    telefone VARCHAR(15),
    email VARCHAR(100),
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ativo BOOLEAN DEFAULT true
);

-- Tabela de Veículos
CREATE TABLE veiculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    placa VARCHAR(8) UNIQUE NOT NULL,
    proprietario_id INT,
    tipo_proprietario ENUM('cooperado', 'empresa', 'terceiro'),
    empresa_id INT,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ativo BOOLEAN DEFAULT true,
    FOREIGN KEY (proprietario_id) REFERENCES cooperados(id),
    FOREIGN KEY (empresa_id) REFERENCES empresas(id)
);

-- Tabela de Tipos de Materiais
CREATE TABLE tipos_materiais (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    unidade_medida VARCHAR(10) NOT NULL,
    descricao TEXT
);

-- Inserir tipos de materiais padrão
INSERT INTO tipos_materiais (nome, unidade_medida) VALUES
    ('Papel', 'kg'),
    ('Papelão', 'kg'),
    ('Plástico', 'kg'),
    ('Vidro', 'kg'),
    ('Metal', 'kg'),
    ('Alumínio', 'kg'),
    ('Ferro', 'kg'),
    ('Eletrônico', 'kg'),
    ('Madeira', 'm²');

-- Tabela de Coletas
-- Banco de dados para coletas
CREATE TABLE coletas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    data DATETIME DEFAULT CURRENT_TIMESTAMP,
    local_id INTEGER,
    veiculo_id INTEGER,
    papel_papelao FLOAT DEFAULT 0,
    plastico FLOAT DEFAULT 0,
    vidro FLOAT DEFAULT 0,
    metal FLOAT DEFAULT 0,
    aluminio FLOAT DEFAULT 0,
    ferro FLOAT DEFAULT 0,
    eletronico FLOAT DEFAULT 0,
    madeira FLOAT DEFAULT 0,
    FOREIGN KEY (local_id) REFERENCES locais(id),
    FOREIGN KEY (veiculo_id) REFERENCES veiculos(id)
);

-- Banco de dados para locais
CREATE TABLE locais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome_local TEXT NOT NULL,
    representante TEXT,
    contato TEXT,
    email TEXT
);

-- Banco de dados para veículos
CREATE TABLE veiculos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome_veiculo TEXT NOT NULL,
    proprietario TEXT,
    placa TEXT,
    contato TEXT,
    email TEXT
);

-- Tabela de Materiais Coletados
CREATE TABLE materiais_coletados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    coleta_id INT NOT NULL,
    tipo_material_id INT NOT NULL,
    quantidade DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (coleta_id) REFERENCES coletas(id),
    FOREIGN KEY (tipo_material_id) REFERENCES tipos_materiais(id)
);