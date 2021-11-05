
-- beneficios precisa possuir uma categoria e um fornecedor ou doador
CREATE TABLE beneficio(
    id_beneficio SERIAL PRIMARY KEY NOT NULL,
    descricao VARCHAR(300),
    nome VARCHAR(70) NOT NULL,
    fk_categoria INT NOT NULL,
    CONSTRAINT fk_categoria_beneficio FOREIGN KEY (fk_categoria_beneficio) REFERENCES categoria_beneficio(id_categoria),
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

-- armazena operações de INSERT, UPDATE OU DELETE EM beneficios
CREATE TABLE log_beneficios(
    id_log SERIAL PRIMARY KEY NOT NULL,
    operacao VARCHAR(10) NOT NULL,
    valores_novos TEXT,
    valores_velhos TEXT,
    id_beneficio INT NOT NULL,
    id_fornecedor_doador INT NOT NULL, 
    data_log TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- esta tabela armazenara as entradas de beneficio
CREATE TABLE entrada_beneficios(
    id_entrada_bene SERIAL PRIMARY KEY NOT NULL,
    id_beneficio INT NOT NULL,
    quantidade_entrada INT NOT NULL, --chekar se a quantidade de entrada e menor ou igual a quantidade maxima permitida se existir
    data_hora_entrada TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--esta tabela armazena os logs, que são vindos dos eventos de INSERT, UPDATE, DELETE na tabela de entrada_beneficios
CREATE TABLE log_entrada_beneficio(
    id_log SERIAL PRIMARY KEY NOT NULL,
    operacao VARCHAR(10) NOT NULL,
    valores_velhos TEXT NOT NULL,
    valores_novos TEXT NOT NULL,
    data_log TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- esta tabela armazena as saidas de beneficios
CREATE TABLE saida_beneficios(
    id_saida_bene SERIAL PRIMARY KEY NOT NULL,
    id_beneficio INT NOT NULL,
    data_hora_saida TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    quantidade_saida INT NOT NULL --cechar se a quantidade de saida e menor ou igual a quantidade em estoque
);

-- esta tabela armazena os logs, que são vindos dos eventos de INSERT, UPDATE, DELETE na tabela de saida_beneficios
CREATE TABLE logs_saida_beneficios(
    
);

--esta tabela armazena o estoque de cada beneficio
CREATE TABLE estoque_beneficios(
    id_beneficio INT NOT NULL,
    quantidade_total INT NOT NULL,
    data_hora_movimentacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);



------------------------------------------------------------------------------------------------------------------
------ TRIGGER QUE REGISTRA CADA INSERT, UPDATE, OU DELETE EM BENEFICIOS NA TABELA DE LOG_BENEFICIOS -------------

CREATE OR REPLACE FUNCTION gera_logs_beneficios() RETURNS TRIGGER
LANGUAGE PLPGSQL
AS
$$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_beneficios(operacao, valores_novos, valores_velhos, id_beneficio, id_fornecedor_doador) VALUES(TG_OP, NEW::TEXT, '', NEW.id_beneficio, NEW.fk_fornecedor_doador); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_beneficios(operacao, valores_novos, valores_velhos, id_beneficio, id_fornecedor_doador) VALUES(TG_OP, NEW::TEXT, OLD::TEXT, NEW.id_beneficio, NEW.fk_fornecedor_doador); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_beneficios(operacao, valores_novos, valores_velhos, id_beneficio, id_fornecedor_doador) VALUES(TG_OP, OLD::TEXT, '', OLD.id_beneficio, NEW.fk_fornecedor_doador);
        RETURN OLD;
    END IF;
END;
$$

CREATE TRIGGER logs_trigger_beneficios AFTER INSERT OR UPDATE OR DELETE ON beneficio   
FOR EACH ROW EXECUTE PROCEDURE gera_logs_beneficios();

--------------------------------------------------------------------------------------------------------------------
