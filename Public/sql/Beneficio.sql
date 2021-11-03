
CREATE TABLE beneficio(
    id_beneficio SERIAL PRIMARY KEY NOT NULL,
    descricao VARCHAR(300),
    nome VARCHAR(70),
    categoria TEXT NOT NULL,
    forma_aquisicao TEXT NOT NULL,
    fk_fornecedor_doador INT, 
    CONSTRAINT fk_fornecedor_doador FOREIGN KEY(fk_fornecedor_doador) REFERENCES fornecedores_doadores(id) ON DELETE SET NULL
    data_hora TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    quantidade_minima INT NOT NULL,
    quantidade_maxima INT NOT NULL,
    unidade_medida VARCHAR(3),
    quantidade_total INT NOT NULL,
    quantidade_por_medida INT
);

CREATE TABLE log_beneficios(
    id_log SERIAL PRIMARY KEY NOT NULL,
    operacao VARCHAR(10),
    valores_novos TEXT,
    valores_velhos TEXT,
    id_beneficio INT,
    id_fornecedor_doador INT, 
    data_log TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);