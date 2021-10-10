



-- cria a tabela de log

CREATE TABLE log_aux_user_benef(
    id_log SERIAL PRIMARY KEY,
    operacao VARCHAR(10),
    valores_novos TEXT,
    valores_velhos TEXT,
    id_usuario INT,
    id_operacao INT,
    data_log TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE OR REPLACE FUNCTION gera_logs_operacoes_usuarios_em_beneficiarios() RETURNS TRIGGER
LANGUAGE PLPGSQL
AS
$$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_aux_user_benef(operacao, valores_novos, valores_velhos, id_usuario, id_operacao) VALUES(TG_OP, NEW::TEXT, '', NEW.fk_usuario, NEW.id_operacao); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_aux_user_benef(operacao, valores_novos, valores_velhos, id_usuario, id_operacao) VALUES(TG_OP, NEW::TEXT, OLD::TEXT, NEW.fk_usuario,  NEW.id_operacao); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_aux_user_benef(operacao, valores_novos, valores_velhos, id_usuario, id_operacao) VALUES(TG_OP, OLD::TEXT, '', NEW.fk_usuario, NEW.id_operacao);
        RETURN OLD;
    END IF;
END;
$$

CREATE TRIGGER logs_trigger_aux_user_benef AFTER INSERT OR UPDATE OR DELETE ON tbl_operaca_usuario_beneficiario FOR EACH ROW EXECUTE 
PROCEDURE gera_logs_operacoes_usuarios_em_beneficiarios();