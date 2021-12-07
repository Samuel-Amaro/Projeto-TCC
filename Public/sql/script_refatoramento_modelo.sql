-- ja executado
-- cria uma tabela de log, para armazenar informações antigas e novas ou modificações exclusões, uma tabela 
-- de log geral
CREATE TABLE log_system(
	id_log SERIAL PRIMARY KEY NOT NULL,
	operacao VARCHAR(10) NOT NULL CHECK(operacao = 'INSERT' OR operacao = 'DELETE' OR operacao = 'UPDATE'),
	valores_velhos TEXT NOT NULL,
	valores_novos TEXT NOT NULL,
	nome_tabela_log TEXT NOT NULL,
	data_hora_log TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	id_usuario_logado INT
);

-----------------------------------------------------------------

-- executado
-- cria tabela tipo_aquisicao
CREATE TABLE tipo_aquisicao(
	id_tipo_aquisicao SERIAL PRIMARY KEY NOT NULL,
	tipo VARCHAR(100) NOT NULL UNIQUE
);

-- executado
-- função que registra os logs de tipo_aquisicao
CREATE OR REPLACE FUNCTION registra_logs_tipo_aquisicao() RETURNS TRIGGER
LANGUAGE PLPGSQL
AS
$$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', NEW::TEXT, TG_TABLE_NAME, NULL); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, OLD::TEXT, NEW::TEXT, TG_TABLE_NAME, NULL); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', OLD::TEXT, TG_TABLE_NAME, NULL);
        RETURN OLD;
    END IF;
END;
$$
--executado
-- trigger de log de tipo_Aquisicai
CREATE TRIGGER trigger_tipo_aquisicao AFTER INSERT OR UPDATE OR DELETE ON tipo_aquisicao  
FOR EACH ROW EXECUTE PROCEDURE registra_logs_tipo_aquisicao();

---------------------------------------------------------------------

-- executado
-- cria tabela que armazena doações e fornecimentos
CREATE TABLE fornecimento_doacao_beneficio(
	id_fornecimento_doacao_beneficio SERIAL PRIMARY KEY NOT NULL,
	id_fornecedores_doadores INT NOT NULL,
	CONSTRAINT id_fornecedores_doadores FOREIGN KEY(id_fornecedores_doadores) REFERENCES 
	fornecedores_doadores(id),
	id_tipo_aquisicao INT NOT NULL,
	CONSTRAINT id_tipo_aquisicao FOREIGN KEY(id_tipo_aquisicao) REFERENCES
	tipo_aquisicao(id_tipo_aquisicao),
	data_hora TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- executado
-- função que registra os logs de fornecimento e doações de beneficios
CREATE OR REPLACE FUNCTION registra_logs_fornecimento_doacao_beneficios() RETURNS TRIGGER
LANGUAGE PLPGSQL
AS
$$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', NEW::TEXT, TG_TABLE_NAME, NULL); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, OLD::TEXT, NEW::TEXT, TG_TABLE_NAME, NULL); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', OLD::TEXT, TG_TABLE_NAME, NULL);
        RETURN OLD;
    END IF;
END;
$$
-- executado
-- trigger de log de fornecimento e doação
CREATE TRIGGER trigger_fornecimento_doacao_beneficio AFTER INSERT OR UPDATE OR DELETE ON fornecimento_doacao_beneficio  
FOR EACH ROW EXECUTE PROCEDURE registra_logs_fornecimento_doacao_beneficios();

-------------------------------------------------------------------------------

-- executado
-- cria tabela tipo de beneficio
CREATE TABLE tipo_beneficio(
	id_tipo_beneficio SERIAL PRIMARY KEY NOT NULL,
	nome_tipo VARCHAR(150) NOT NULL UNIQUE,
	id_unidade_medida INT NOT NULL,
	CONSTRAINT id_unidade_medida FOREIGN KEY(id_unidade_medida) REFERENCES
	unidades_medidas_beneficios(id_unidade),
	id_categoria INT NOT NULL,
	CONSTRAINT id_categoria FOREIGN KEY(id_categoria) REFERENCES 
	categoria_beneficios(id_categoria),
	data_hora TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
-- executado
CREATE OR REPLACE FUNCTION registra_logs_tipo_beneficio() RETURNS TRIGGER
LANGUAGE PLPGSQL
AS
$$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', NEW::TEXT, TG_TABLE_NAME, NULL); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, OLD::TEXT, NEW::TEXT, TG_TABLE_NAME, NULL); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', OLD::TEXT, TG_TABLE_NAME, NULL);
        RETURN OLD;
    END IF;
END;
$$
-- executado
CREATE TRIGGER trigger_tipo_beneficio AFTER INSERT OR UPDATE OR DELETE ON  tipo_beneficio  
FOR EACH ROW EXECUTE PROCEDURE registra_logs_tipo_beneficio();

-------------------------------------------------------------------------------------
-- deletar tabela beneficio, porque vamos criar uma nova com novas colunas
--executado
DROP TABLE IF EXISTS beneficio CASCADE;

-- executado
-- cria nova tabela beneficio
CREATE TABLE beneficio(
	id_beneficio SERIAL PRIMARY KEY NOT NULL,
	descricao VARCHAR(300),
	id_tipo_beneficio INT NOT NULL,
	CONSTRAINT id_tipo_beneficio FOREIGN KEY(id_tipo_beneficio) REFERENCES
	tipo_beneficio(id_tipo_beneficio),
	id_fornecedor_doador INT NOT NULL,
	CONSTRAINT id_fornecedor_doador FOREIGN KEY(id_fornecedor_doador) REFERENCES
	fornecimento_doacao_beneficio(id_fornecimento_doacao_beneficio),
	quantidade INT NOT NULL,
	data_hora TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
--executado
CREATE OR REPLACE FUNCTION registra_logs_beneficio() RETURNS TRIGGER
LANGUAGE PLPGSQL
AS
$$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', NEW::TEXT, TG_TABLE_NAME, NULL); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, OLD::TEXT, NEW::TEXT, TG_TABLE_NAME, NULL); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', OLD::TEXT, TG_TABLE_NAME, NULL);
        RETURN OLD;
    END IF;
END;
$$
-- EXECUTADO
CREATE TRIGGER trigger_beneficio AFTER INSERT OR UPDATE OR DELETE ON  beneficio  
FOR EACH ROW EXECUTE PROCEDURE registra_logs_beneficio();

---------------------------------------------------------------------------------

--executado
-- deleta a tabela movimentacoes_estoque_benefiios porque ha mudanças no model
DROP TABLE IF EXISTS movimentacoes_estoque_beneficios CASCADE;

-- executado
-- cria a nova tabela movimentacoes_estoque_beneficios
CREATE TABLE movimentacoes_estoque_beneficios(
	id_movimentacoes_estoque_beneficio SERIAL PRIMARY KEY NOT NULL,
	id_tipo_beneficio INT NOT NULL,
	CONSTRAINT id_tipo_beneficio FOREIGN KEY(id_tipo_beneficio) REFERENCES
	tipo_beneficio(id_tipo_beneficio),
	tipo_movimentacao INT NOT NULL CHECK(tipo_movimentacao = 1 OR tipo_movimentacao = 0),
	quantidade_mov INT NOT NULL,
	data_hora_mov TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	descricao VARCHAR(300)
);
-- EXECUTADO
CREATE OR REPLACE FUNCTION registra_logs_movimentacoes_estoque_beneficios() RETURNS TRIGGER
LANGUAGE PLPGSQL
AS
$$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', NEW::TEXT, TG_TABLE_NAME, NULL); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, OLD::TEXT, NEW::TEXT, TG_TABLE_NAME, NULL); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', OLD::TEXT, TG_TABLE_NAME, NULL);
        RETURN OLD;
    END IF;
END;
$$
-- EXECUTADO
CREATE TRIGGER trigger_movimentacao_estoque_beneficios 
AFTER INSERT OR UPDATE OR DELETE ON movimentacoes_estoque_beneficios  
FOR EACH ROW EXECUTE PROCEDURE registra_logs_movimentacoes_estoque_beneficios();

---------------------------------------------------------------

-- executado
-- cria tabela que armazenara as entregas de beneficios
CREATE TABLE entregas_beneficios(
	id_entrega_beneficio SERIAL PRIMARY KEY NOT NULL,
	data_entrega TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	id_beneficiario INT NOT NULL,
	CONSTRAINT id_beneficiario FOREIGN KEY(id_beneficiario) REFERENCES
	beneficiarios(id_beneficiario),
	id_tipo_beneficio INT NOT NULL,
	CONSTRAINT id_tipo_beneficio FOREIGN KEY(id_tipo_beneficio) REFERENCES
	tipo_beneficio(id_tipo_beneficio),
	quantidade_entregue INT NOT NULL,
	id_usuario_responsavel_entrega INT NOT NULL,
	CONSTRAINT id_usuario_responsavel_entrega FOREIGN KEY(id_usuario_responsavel_entrega) REFERENCES
	usuario(id_usuario)
);
-- executado
CREATE OR REPLACE FUNCTION registra_logs_entregas_beneficios() RETURNS TRIGGER
LANGUAGE PLPGSQL
AS
$$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', NEW::TEXT, TG_TABLE_NAME, NEW.id_usuario_responsavel_entrega); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, OLD::TEXT, NEW::TEXT, TG_TABLE_NAME, OLD.id_usuario_responsavel_entrega); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', OLD::TEXT, TG_TABLE_NAME, OLD.id_usuario_responsavel_entrega);
        RETURN OLD;
    END IF;
END;
$$
-- executado
CREATE TRIGGER trigger_entrega_beneficios 
AFTER INSERT OR UPDATE OR DELETE ON entregas_beneficios  
FOR EACH ROW EXECUTE PROCEDURE registra_logs_entregas_beneficios();


