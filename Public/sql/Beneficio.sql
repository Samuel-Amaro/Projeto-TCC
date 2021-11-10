-- esta tabela armazena os beneficios a serem cadastrados
CREATE TABLE beneficio(
	id_beneficio SERIAL PRIMARY KEY NOT NULL,
	descricao VARCHAR(70) NOT NULL,
	nome VARCHAR(70) NOT NULL,
	id_categoria INT NOT NULL,
	CONSTRAINT id_categoria FOREIGN KEY(id_categoria) REFERENCES categoria_beneficios(id_categoria),
	id_fornecedor_doador INT NOT NULL,
	-- se a linha de uma fornecedor ou doador for apagada essa linha aqui não podera
	-- ser apagada
    CONSTRAINT id_fornecedor_doador FOREIGN KEY(id_fornecedor_doador) 
	REFERENCES fornecedores_doadores(id),--ON DELETE SET NULL
	forma_aquisicao VARCHAR(100) NOT NULL,
	data_hora TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	quantidade_minima INT NOT NULL,
	quantidade_maxima INT NOT NULL
);

-- esta tabela armazena as movimentações de estoque de entrada e saida de beneficios
CREATE TABLE movimentacoes_estoque_beneficios(
	id_estoque SERIAL PRIMARY KEY NOT NULL,
	id_beneficio INT NOT NULL,
	-- se apaga a linha de registro de beneficio referenciada aqui,
	-- não vai poder , porque esta referenciada, so se não estiver
	CONSTRAINT id_beneficio FOREIGN KEY(fk_beneficio)
	REFERENCES beneficio(id_beneficio),
	quantidade_mov INT NOT NULL
	data_hora_ultima_mov TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	-- 1 == entrada or 0 == saida
	tipo_mov INT CHECK(tipo_mov = 1 OR tipo_mov = 0), 
	id_unidade_medida INT NOT NULL,
	CONSTRAINT id_unidade_medida FOREIGN KEY(fk_unidade_medida) 
	REFERENCES unidades_medidas_beneficios(id_unidade),
	quantidade_por_medida INT NOT NULL
);

-- tabela que gera logs de movimentações de estoque
CREATE TABLE log_movimentacoes_beneficios(
	id_log_estoque SERIAL PRIMARY KEY NOT NULL,
	id_estoque INT NOT NULL,
	operacao VARCHAR(10) NOT NULL,
	valores_velhos TEXT NOT NULL,
	valores_novos TEXT NOT NULL,
	data_log TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	id_beneficio INT NOT NULL
);

-- tabela que gera logs de beneficios
CREATE TABLE log_beneficios(
	id_log SERIAL PRIMARY KEY NOT NULL,
	operacao VARCHAR(10) NOT NULL,
	valores_novos TEXT NOT NULL,
	valores_velhos TEXT NOT NULL,
	id_beneficio INT NOT NULL,
	id_fornecedor_doador INT NOT NULL,
	id_categoria INT NOT NULL,
	data_log TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

------------------------------------------------------------------------------------------------------------------
------ TRIGGER QUE REGISTRA CADA INSERT, UPDATE, OU DELETE EM BENEFICIOS NA TABELA DE LOG_BENEFICIOS -------------

CREATE OR REPLACE FUNCTION gera_logs_beneficios() RETURNS TRIGGER
LANGUAGE PLPGSQL
AS
$$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_beneficios(operacao, valores_novos, valores_velhos, id_beneficio, id_fornecedor_doador, id_categoria) VALUES(TG_OP, NEW::TEXT, '', NEW.id_beneficio, NEW.id_fornecedor_doador, NEW.id_categoria); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_beneficios(operacao, valores_novos, valores_velhos, id_beneficio, id_fornecedor_doador, id_categoria) VALUES(TG_OP, NEW::TEXT, OLD::TEXT, NEW.id_beneficio, NEW.id_fornecedor_doador, NEW.id_categoria); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_beneficios(operacao, valores_novos, valores_velhos, id_beneficio, id_fornecedor_doador, id_categoria) VALUES(TG_OP, OLD::TEXT, '', OLD.id_beneficio, NEW.id_fornecedor_doador, NEW.id_categoria);
        RETURN OLD;
    END IF;
END;
$$

CREATE TRIGGER logs_trigger_beneficios AFTER INSERT OR UPDATE OR DELETE ON beneficio   
FOR EACH ROW EXECUTE PROCEDURE gera_logs_beneficios();


---------------------- TRIGGER QUE REGISTRA CADA INSERT, DELETE, UPDATE EM ESTOQUE

CREATE OR REPLACE FUNCTION gera_logs_estoque() RETURNS TRIGGER
LANGUAGE PLPGSQL
AS
$$
BEGIN
    IF TG_OP = 'INSERT' THEN INSERT INTO log_movimentacoes_beneficios(id_estoque, operacao, valores_velhos, valores_novos, id_beneficio) VALUES(NEW.id_estoque, TG_OP, NEW::TEXT, '', NEW.id_beneficio); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN INSERT INTO log_movimentacoes_beneficios(id_estoque, operacao, valores_velhos, valores_novos, id_beneficio) VALUES(NEW.id_estoque, TG_OP, NEW::TEXT, OLD::TEXT, NEW.id_beneficio); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_movimentacoes_beneficios(id_estoque, operacao, valores_velhos, valores_novos, id_beneficio) VALUES(OLD.id_estoque, TG_OP, OLD::TEXT, '', NEW.id_beneficio);
        RETURN OLD;
    END IF;
END;
$$

CREATE TRIGGER logs_trigger_mov_estoque AFTER INSERT OR UPDATE OR DELETE ON movimentacoes_estoque_beneficios   
FOR EACH ROW EXECUTE PROCEDURE gera_logs_estoque();

--------------------------------------------------------------------------------------------------------------------

-- SQL TESTANDO AS TABELAS CRIADAS

INSERT INTO public.beneficio( 
	descricao, 
	nome, 
	id_categoria, 
	id_fornecedor_doador, 
	forma_aquisicao, 
	quantidade_minima, 
	quantidade_maxima)
VALUES ('Beneficio para alimentação da população formosense', 
		'Cesta básica', 1, 22, 'Licitação', 5, 500), 
		('verduras para nutritição da população', 
		'Cesta verde', 3, 20, 'Doação', 2, 20);
		
INSERT INTO public.beneficio( 
	descricao, 
	nome, 
	id_categoria, 
	id_fornecedor_doador, 
	forma_aquisicao, 
	quantidade_minima, 
	quantidade_maxima)
VALUES ('Beneficio para alimentação da população formosense', 
		'Cesta bAsica', 1, 22, 'Licitação', 5, 500);
		
SELECT * FROM beneficio;


-- ENTRADAS
INSERT INTO public.movimentacoes_estoque_beneficios( 
	id_beneficio, 
	quantidade_mov, 
	tipo_mov, 
	id_unidade_medida, 
	quantidade_por_medida)
	VALUES (1, 50, 1, 1, 3), (2, 90, 1, 1, 3), (3, 15, 1, 1, 3);

INSERT INTO public.movimentacoes_estoque_beneficios( 
	id_beneficio, 
	quantidade_mov, 
	tipo_mov, 
	id_unidade_medida, 
	quantidade_por_medida)
	VALUES (1, 12, 1, 1, 3);
	
-- SAIDAS
INSERT INTO public.movimentacoes_estoque_beneficios( 
	id_beneficio, 
	quantidade_mov, 
	tipo_mov, 
	id_unidade_medida, 
	quantidade_por_medida)
	VALUES (1, 35, 0, 1, 3), (2, 45, 0, 1, 3), (3, 12, 0, 1, 3);

SELECT * FROM movimentacoes_estoque_beneficios;

-- somente entradas de beneficios
SELECT MV.quantidade_mov, MV.tipo_mov AS TIPO_MOVIM_ENTRADA, 
MV.id_unidade_medida, MV.quantidade_por_medida, B.nome,
B.quantidade_minima, B.quantidade_maxima
FROM movimentacoes_estoque_beneficios AS MV
INNER JOIN beneficio AS B
ON MV.id_beneficio = B.id_beneficio WHERE MV.tipo_mov = 1;

-- somente saida de beneficios
SELECT MV.quantidade_mov, MV.tipo_mov AS TIPO_MOV_SAIDA,
MV.id_unidade_medida, MV.quantidade_por_medida, B.nome,
B.quantidade_minima, B.quantidade_maxima
FROM movimentacoes_estoque_beneficios AS MV
INNER JOIN beneficio AS B
ON MV.id_beneficio = B.id_beneficio WHERE MV.tipo_mov = 0;

-- quantidade total de entradas de todos os beneficios
SELECT sum(MV.quantidade_mov) AS QTD_TOTAL_ENTRADA
FROM movimentacoes_estoque_beneficios AS MV
INNER JOIN beneficio AS B
ON MV.id_beneficio = B.id_beneficio WHERE MV.tipo_mov = 1;

-- quantidade total de saida de todos os beneficios
SELECT sum(MV.quantidade_mov) AS QTD_TOTAL_SAIDA
FROM movimentacoes_estoque_beneficios AS MV
INNER JOIN beneficio AS B
ON MV.id_beneficio = B.id_beneficio WHERE MV.tipo_mov = 0;

-- SALDO DE CADA BENEFICIO
SELECT id_beneficio, quantidade_mov AS QTD_ENTRADA FROM movimentacoes_estoque_beneficios
WHERE tipo_mov = 0 
UNION ALL
SELECT id_beneficio, quantidade_mov AS QTD_SAIDA FROM movimentacoes_estoque_beneficios
WHERE tipo_mov = 1;

-- SALDO DO BENEFICIO COM ID 1, todas as entradas - todas as saidas 
SELECT 
	(SELECT SUM(quantidade_mov) AS QTD_ENTRADA FROM movimentacoes_estoque_beneficios 
	WHERE tipo_mov = 1 AND id_beneficio = 1 GROUP BY id_beneficio) 
	- 
	(SELECT SUM(quantidade_mov) AS QTD_SAIDA FROM movimentacoes_estoque_beneficios
	WHERE tipo_mov = 0 AND id_beneficio = 1 GROUP BY id_beneficio) 
AS SALDO_ATUAL; 






