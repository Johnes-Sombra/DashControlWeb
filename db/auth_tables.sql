USE auth_db;

-- Tabela para controle de tentativas de login
CREATE TABLE IF NOT EXISTS login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(255) NOT NULL,
    attempts INT DEFAULT 0,
    last_attempt DATETIME,
    locked_until DATETIME,
    UNIQUE KEY unique_usuario (usuario)
);

-- Tabela para logs de acesso
CREATE TABLE IF NOT EXISTS access_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(255) NOT NULL,
    acao VARCHAR(50) NOT NULL,
    status VARCHAR(50) NOT NULL,
    ip_address VARCHAR(45),
    data_hora DATETIME,
    INDEX idx_usuario (usuario),
    INDEX idx_data_hora (data_hora)
);

-- Tabela para recuperação de senha
CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL,
    expires_at DATETIME NOT NULL,
    used BOOLEAN DEFAULT FALSE,
    UNIQUE KEY unique_token (token),
    INDEX idx_usuario (usuario)
);