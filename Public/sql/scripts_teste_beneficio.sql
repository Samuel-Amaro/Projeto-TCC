SELECT 
	B.id_beneficio,
	B.nome AS nome_beneficio,
	B.forma_aquisicao AS forma_aquisicao_beneficio,
	B.data_hora AS data_hora_beneficio,
	B.quantidade_minima AS quantidade_minima_beneficio,
	B.quantidade_maxima AS quantidade_maxima_beneficio,
	B.descricao AS descricao_beneficio,
	CB.id_categoria,
	CB.nome AS nome_categoria_beneficio,
	FD.id AS id_fornecedor_doador,
	FD.nome AS nome_fornecedor_doador,
	FD.cpf AS cpf_fornecedor_doador,
	FD.cnpj AS cnpj_fornecedor_doador,
	FD.identificacao AS identificacao_fornecedor_doador
FROM beneficio AS B
INNER JOIN categoria_beneficios AS CB 
ON B.id_categoria = CB.id_categoria 
INNER JOIN fornecedores_doadores AS FD
ON B.id_fornecedor_doador = FD.id;



SELECT 
	(SELECT SUM(quantidade_mov) AS QTD_ENTRADA FROM movimentacoes_estoque_beneficios WHERE tipo_mov = 1
	GROUP BY tipo_mov) --AND id_beneficio = 1 GROUP BY id_beneficio
	- 
	(SELECT SUM(quantidade_mov) AS QTD_SAIDA FROM movimentacoes_estoque_beneficios 
	WHERE tipo_mov = 0 GROUP BY tipo_mov
	) -- AND id_beneficio = 1 GROUP BY id_beneficio
AS SALDO_ATUAL; 


B.forma_aquisicao AS forma_aquisicao_beneficio,
	B.data_hora AS data_hora_beneficio,
	B.quantidade_minima AS quantidade_minima_beneficio,
	B.quantidade_maxima AS quantidade_maxima_beneficio,
	B.descricao AS descricao_beneficio,
	MV.id_estoque AS id_estoque_beneficio,
	MV.tipo_mov AS tipo_movimentacao_estoque_beneficio,
	MV.data_hora_ultima_mov

-- quantidade total movimentada de cada beneficio
SELECT 
	B.nome AS nome_beneficio,
	SUM(MV.quantidade_mov) AS TOTAL_MOV
FROM beneficio AS B
INNER JOIN movimentacoes_estoque_beneficios AS MV
ON B.id_beneficio = MV.id_beneficio 
GROUP BY B.nome;

-- TOTAL DE ENTRADA DE CADA BENEFICIO
SELECT 
	B.id_beneficio,
	SUM(MV.quantidade_mov) AS TOTAL_ENTRADA
FROM beneficio AS B
INNER JOIN movimentacoes_estoque_beneficios as MV
ON B.id_beneficio = MV.id_beneficio
WHERE tipo_mov = 1
GROUP BY B.id_beneficio;

-- TOTAL DE SAIDA DE CADA BENEFICIO
SELECT 
	B.id_beneficio,
	SUM(MV.quantidade_mov) AS TOTAL_SAIDA
FROM beneficio AS B
INNER JOIN movimentacoes_estoque_beneficios as MV
ON B.id_beneficio = MV.id_beneficio
WHERE tipo_mov = 0
GROUP BY B.id_beneficio;


-- informar id para salber saldo de cada beneficio
SELECT (SELECT 
		SUM(MV.quantidade_mov) quantidade_entrada
		FROM movimentacoes_estoque_beneficios as MV
		WHERE tipo_mov = 1 AND id_beneficio = 1
		) - (
		SELECT
		SUM(MV.quantidade_mov) quantidade_saida
		FROM movimentacoes_estoque_beneficios as MV
		WHERE tipo_mov = 0 AND id_beneficio = 1) as saldo
		
-- quantidade de beneficios
		
SELECT COUNT(nome) FROM beneficio;


-- seleciona a quantidade de fornecedores e doadores
SELECT identificacao, COUNT(nome) as qtd FROM fornecedores_doadores GROUP BY identificacao;

-- seleciona a quantidade de beneficiarios cadastrados
SELECT COUNT(nis_beneficiario) as qtd FROM beneficiarios;

-- add coluna de data hora em beneficiarios
ALTER TABLE beneficiarios ADD COLUMN data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

UPDATE beneficiarios SET data_hora = NOW();

ALTER TABLE beneficiarios ALTER COLUMN data_hora SET NOT NULL;

SELECT * FROM beneficiarios;

--consulta que traga todas as movimenta????es de um beneficio ordenada por data

SELECT MV.quantidade_mov, MV.data_hora_ultima_mov, MV.tipo_mov,
UM.sigla, MV.quantidade_por_medida
FROM movimentacoes_estoque_beneficios AS MV
INNER JOIN beneficio AS B 
ON MV.id_beneficio = B.id_beneficio
INNER JOIN unidades_medidas_beneficios AS UM
ON MV.id_unidade_medida = UM.id_unidade
WHERE MV.id_beneficio = 29 ORDER BY MV.data_hora_ultima_mov ASC;




