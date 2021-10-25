
CREATE TABLE fornecedores_doadores(
    id SERIAL PRIMARY KEY NOT NULL,
    nome VARCHAR(70) NOT NULL,
    descricao VARCHAR(300),
    identificacao TEXT NOT NULL CHECK(identificacao = 'DOADOR' OR identificacao = 'FORNECEDOR'), --'DOADOR' OU 'FORNECEDOR'
    tipo_pessoa TEXT NOT NULL CHECK(tipo_pessoa = 'FISICA' OR tipo_pessoa = 'JURIDICA'), --'FISICA' OU 'JURIDICA'
    cep VARCHAR(10),
    endereco VARCHAR(70) NOT NULL,
    complemento VARCHAR(30),
    bairro VARCHAR(50) NOT NULL,
    cidade VARCHAR(150) NOT NULL,
    uf CHAR(2) NOT NULL,
    telefone_celular VARCHAR(15) NOT NULL,
    telefone_fixo VARCHAR(14) NOT NULL,
    data_hora TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    cpf VARCHAR(11) UNIQUE,
    cnpj VARCHAR(14) UNIQUE,
    email VARCHAR(70) NOT NULL UNIQUE,     
);

-------------------------------------------------------------------------------------------------------------------
-- CRIANDO TABELA DE LOG PARA FORNECEDORES_DOADORES

CREATE TABLE log_fornecedores_doadores(
    id_log SERIAL PRIMARY KEY,
    operacao VARCHAR(10),
    valores_novos TEXT,
    valores_velhos TEXT,
    id_fornecedor_doador INT, 
    data_log TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE OR REPLACE FUNCTION gera_logs_fornecedores_doadores() RETURNS TRIGGER
LANGUAGE PLPGSQL
AS
$$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_fornecedores_doadores(operacao, valores_novos, valores_velhos, id_fornecedor_doador, id_usuario) VALUES(TG_OP, NEW::TEXT, '', NEW.id); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_fornecedores_doadores(operacao, valores_novos, valores_velhos, id_fornecedor_doador) VALUES(TG_OP, NEW::TEXT, OLD::TEXT, NEW.id); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_fornecedores_doadores(operacao, valores_novos, valores_velhos, id_fornecedor_doador) VALUES(TG_OP, OLD::TEXT, '', OLD.id);
        RETURN OLD;
    END IF;
END;
$$

CREATE TRIGGER logs_trigger_fornecedor_doador AFTER INSERT OR UPDATE OR DELETE ON fornecedores_doadores   
FOR EACH ROW EXECUTE PROCEDURE gera_logs_fornecedores_doadores();