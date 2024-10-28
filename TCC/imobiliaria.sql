CREATE DATABASE IF NOT EXISTS imobiliaria_lls
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;

-- Seleciona o banco de dados
USE imobiliaria_lls;

-- Criação das tabelas
CREATE TABLE IF NOT EXISTS TB_endereco (
    cod_endereco INT AUTO_INCREMENT PRIMARY KEY,
    end_cep VARCHAR(10) NOT NULL,
    end_estado VARCHAR(255) NOT NULL,
    end_cidade VARCHAR(255) NOT NULL,
    end_bairro VARCHAR(255) NOT NULL,
    end_logradouro VARCHAR(255) NOT NULL,
    end_numero VARCHAR(10) NOT NULL
);

CREATE TABLE IF NOT EXISTS TB_cargo (
    cod_cargo INT AUTO_INCREMENT PRIMARY KEY,
    car_cargo VARCHAR(255) NOT NULL,
    car_descricao TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS TB_adm (
    cod_adm INT AUTO_INCREMENT PRIMARY KEY,
    adm_nome VARCHAR(255) NOT NULL,
    adm_cpf VARCHAR(14) UNIQUE NOT NULL,
    adm_telefone VARCHAR(20) NOT NULL,
    adm_email VARCHAR(255) UNIQUE NOT NULL,
    adm_senha VARCHAR(255) NOT NULL,
    adm_end_codigo INT,
    adm_car_codigo INT,
    FOREIGN KEY (adm_end_codigo) REFERENCES TB_endereco(cod_endereco),
    FOREIGN KEY (adm_car_codigo) REFERENCES TB_cargo(cod_cargo)
);

CREATE TABLE IF NOT EXISTS TB_imagens (
    cod_imagens INT AUTO_INCREMENT PRIMARY KEY,
    img_nome VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS TB_usuario (
    cod_usuario INT AUTO_INCREMENT PRIMARY KEY,
    usu_nome VARCHAR(255) NOT NULL,
    usu_cpf VARCHAR(14) UNIQUE NOT NULL,
    usu_telefone VARCHAR(20) NOT NULL,
    usu_email VARCHAR(255) UNIQUE NOT NULL,
    usu_senha VARCHAR(255) NOT NULL,
    usu_end_codigo INT,
    usu_img_codigo INT,
    FOREIGN KEY (usu_end_codigo) REFERENCES TB_endereco(cod_endereco),
    FOREIGN KEY (usu_img_codigo) REFERENCES TB_imagens(cod_imagens)
);

CREATE TABLE IF NOT EXISTS TB_imovel (
    cod_imovel INT AUTO_INCREMENT PRIMARY KEY,
    imo_desc_basica VARCHAR(255),
    imo_valor DECIMAL(10, 2),
    imo_numero_comodos TEXT,
    imo_tamanho_imovel TEXT,
    imo_desc_completa TEXT,
    imo_end_codigo INT,
    imo_usu_codigo INT,
    FOREIGN KEY (imo_end_codigo) REFERENCES TB_endereco(cod_endereco),
    FOREIGN KEY (imo_usu_codigo) REFERENCES TB_usuario(cod_usuario)
);

CREATE TABLE IF NOT EXISTS TB_imagem_imovel (
    cod_junt_img INT AUTO_INCREMENT PRIMARY KEY,
    junt_img_imovel INT,
    junt_img_imagem INT,
    FOREIGN KEY (junt_img_imovel) REFERENCES TB_imovel(cod_imovel),
    FOREIGN KEY (junt_img_imagem) REFERENCES TB_imagens(cod_imagens)
);

CREATE TABLE IF NOT EXISTS TB_aluguel (
    cod_aluguel INT AUTO_INCREMENT PRIMARY KEY,
    alu_data_inicio DATE,
    alu_data_fim DATE,
    alu_imo_codigo INT,
    alu_usu_codigo INT,
    FOREIGN KEY (alu_imo_codigo) REFERENCES TB_imovel(cod_imovel),
    FOREIGN KEY (alu_usu_codigo) REFERENCES TB_usuario(cod_usuario)
);

CREATE TABLE IF NOT EXISTS TB_suporte (
    cod_suporte INT AUTO_INCREMENT PRIMARY KEY,
    sup_descricao TEXT,
    sup_servico TEXT NOT NULL,
    sup_adm_codigo INT,
    FOREIGN KEY (sup_adm_codigo) REFERENCES TB_adm(cod_adm)
);

-- (Opcional) Insira dados de exemplo na tabela 'imovel'
-- INSERT INTO imovel (imagem, desc_basica, endereco_imo, valor, desc_completa)
-- VALUES ('exemplo.jpg', 'Descrição Básica Exemplo', 'Endereço Exemplo', 1234.56, 'Descrição Completa Exemplo');

-- CREATE TABLE imovel (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     imagem VARCHAR(255),
--     desc_basica TEXT,
--     endereco_imo TEXT,
--     valor DECIMAL(10, 2),
--     desc_completa TEXT
-- );