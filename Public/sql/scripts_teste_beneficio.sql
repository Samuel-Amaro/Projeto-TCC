SELECT 
	B.nome AS nome_beneficio,
	B.forma_aquisicao AS forma_aquisicao_beneficio,
	B.data_hora AS data_hora_beneficio,
	B.quantidade_minima AS quantidade_minima_beneficio,
	B.quantidade_maxima AS quantidade_maxima_beneficio,
	B.descricao AS descricao_beneficio,
	CB.nome AS nome_categoria_beneficio,
	FD.nome AS nome_fornecedor_doador,
	FD.cpf AS cpf_fornecedor_doador,
	FD.cnpj AS cnpj_fornecedor_doador,
	FD.identificacao AS identificacao_fornecedor_doador,
	MV.id_estoque AS id_estoque_beneficio,
	MV.tipo_mov AS tipo_movimentacao_estoque_beneficio,
	MV.quantidade_mov AS qtd_movimentada_beneficio,
	MV.data_hora_ultima_mov
FROM beneficio AS B
INNER JOIN categoria_beneficios AS CB 
ON B.id_categoria = CB.id_categoria 
INNER JOIN fornecedores_doadores AS FD
ON B.id_fornecedor_doador = FD.id
INNER JOIN 




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
		


