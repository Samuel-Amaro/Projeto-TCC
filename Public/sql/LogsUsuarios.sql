
-- CRIANDO A TABELA DE LOGS 

CREATE TABLE log_usuarios(
    id_log SERIAL PRIMARY KEY,
    operacao VARCHAR(10),
    valores_novos TEXT,
    valores_velhos TEXT,
    usuario INT NOT NULL,
    data_log TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- ESSA FUNÇÃO VAI REGISTRAR LOGS DE USUARIOS QUE VÃO SER ACIONADADOS QUANDO HAVER UM INSERT, DELETE, UPDATE DE USUARIOS

-- TG_OP Texto do tipo de dados ; uma string de INSERT , UPDATE , DELETE ou TRUNCATE informando para qual operação o gatilho foi disparado.

-- NEW: Tipo de dados RECORD ; variável que contém a nova linha do banco de dados para operações INSERT / UPDATE em acionadores de nível de linha. Esta variável é NULL em acionadores de nível de instrução e para operações DELETE.

--VELHO(OLD): Tipo de dados RECORD ; variável que mantém a linha do banco de dados antigo para operações UPDATE / DELETE em acionadores de nível de linha. Esta variável é NULL em acionadores de nível de instrução e para operações INSERT.

CREATE OR REPLACE FUNCTION gera_logs_usuarios() RETURNS TRIGGER
LANGUAGE PLPGSQL
AS
$$
BEGIN
    IF TG_OP = 'INSERT' THEN 
        INSERT INTO log_usuarios(operacao, valores_novos, valores_Velhos, usuario) VALUES (TG_OP, NEW::TEXT, '', NEW.id_usuario);
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_usuarios(operacao, valores_novos, valores_velhos, usuario) VALUES (TG_OP, NEW::TEXT, OLD::TEXT, NEW.id_usuario);
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_usuarios(operacao, valores_novos, valores_velhos, usuario) VALUES (TG_OP, OLD::TEXT, '', OLD.id_usuario);
        RETURN OLD;
    END IF;
END;
$$

CREATE TRIGGER logs_trigger_user AFTER INSERT OR UPDATE OR DELETE ON usuario FOR EACH ROW EXECUTE 
PROCEDURE gera_logs_usuarios();