SELECT 
	B.id_beneficio AS id_beneficio, 
	B.descricao AS descricao_beneficio, 
	B.quantidade AS quantidade_inicial_beneficio, 
	B.data_hora AS data_hora_insercao_beneficio, 
	B.id_tipo_beneficio,
	B.id_fornecedor_doador, 
	FD.nome AS nome_fornecedor_doador, 
	FD.identificacao AS identificacao_fornecedor_doador, 
	FD.tipo_pessoa AS tipo_pessoa_fornecedor_doador,
	FD.cpf AS cpf_fornecedor_doador, 
	FD.cnpj AS cnpj_fornecedor_doador, 
	FD.email AS email_fornecedor_doador,
	TA.id_tipo_aquisicao,
	TA.tipo AS tipo_aquisicao, 
	TB.nome_tipo AS nome_tipo_beneficio, 
	TB.id_tipo_beneficio,
	UMB.sigla AS unidade_medida_beneficio, 
	UMB.id_unidade AS id_unidade_medida,
	C.nome AS nome_categoria, 
	C.id_categoria AS id_categoria_beneficio
FROM beneficio AS B --TBL BENEFICIO 
INNER JOIN fornecimento_doacao_beneficio AS FDB --TBL FORNECIMENTO_DOACAO_BENEFICIO
ON B.id_fornecedor_doador = FDB.id_fornecimento_doacao_beneficio 
INNER JOIN fornecedores_doadores AS FD --TBL FORNECEDORES_DOADORES
ON FDB.id_fornecedores_doadores = FD.id
INNER JOIN tipo_aquisicao AS TA --TBL TIPO_AQUISICAO
ON FDB.id_tipo_aquisicao = TA.id_tipo_aquisicao
INNER JOIN tipo_beneficio AS TB -- TBL TIPO_BENEFICIO
ON B.id_tipo_beneficio = TB.id_tipo_beneficio
INNER JOIN unidades_medidas_beneficios AS UMB -- TBL UNIDADES_MEDIDAS_BENEFICIOS
ON TB.id_unidade_medida = UMB.id_unidade
INNER JOIN categoria_beneficios AS C -- TBL CATEGORIA_BENEFICIOS
ON TB.id_categoria = C.id_categoria;




-- trazer a quantidade atual total de entrada de beneficios no sistema
SELECT 
	--MEB.id_movimentacoes_estoque_beneficio, 
	--MEB.id_tipo_beneficio,
	--MEB.tipo_movimentacao, 
	SUM(MEB.quantidade_mov) AS QTD_TOTAL_ENTRADA
	--MEB.data_hora_mov, MEB.descricao
FROM movimentacoes_estoque_beneficios AS MEB
INNER JOIN tipo_beneficio AS TB
ON MEB.id_tipo_beneficio = TB.id_tipo_beneficio
WHERE MEB.tipo_movimentacao = 1 GROUP BY MEB.tipo_movimentacao;

--trazer a quantidade atual total de saida de beneficios no sistema
SELECT 
	--MEB.id_movimentacoes_estoque_beneficio, 
	--MEB.id_tipo_beneficio,
	--MEB.tipo_movimentacao, 
	SUM(MEB.quantidade_mov) AS QTD_TOTAL_SAIDA
	--MEB.data_hora_mov, MEB.descricao
FROM movimentacoes_estoque_beneficios AS MEB
INNER JOIN tipo_beneficio AS TB
ON MEB.id_tipo_beneficio = TB.id_tipo_beneficio
WHERE MEB.tipo_movimentacao = 0 GROUP BY MEB.tipo_movimentacao;

--trazer o saldo atual de um tipo_beneficio
SELECT 
	--MEB.id_movimentacoes_estoque_beneficio, 
	--MEB.id_tipo_beneficio,
	--MEB.tipo_movimentacao, 
	SUM(MEB.quantidade_mov) AS QTD_ENTRADA
	--MEB.data_hora_mov, MEB.descricao
FROM movimentacoes_estoque_beneficios AS MEB
INNER JOIN tipo_beneficio AS TB
ON MEB.id_tipo_beneficio = TB.id_tipo_beneficio
WHERE TB.id_tipo_beneficio = 1 AND MEB.tipo_movimentacao = 1 
GROUP BY MEB.tipo_movimentacao;

--traz o saldo geral de quantos beneficios ha no estoque
SELECT 
 	(SELECT SUM(MEB.quantidade_mov) AS qtd_total_entrada_estoque 
	 FROM movimentacoes_estoque_beneficios AS MEB
	 WHERE MEB.tipo_movimentacao = 1
	) - 
	(SELECT SUM(MEB.quantidade_mov) AS qtd_total_saida_estoque 
	 FROM movimentacoes_estoque_beneficios AS MEB
	 WHERE MEB.tipo_movimentacao = 0) AS saldo_geral_estoque;

-- TRAZ A QTD_ATUAL DE UM BENEFICIO INFORMANDO SEU ID
SELECT
	DISTINCT MEB_EXTERNO.id_tipo_beneficio,
	TB.nome_tipo,
	UMB.sigla,
	C.nome,
	--SUBSELEC(SUBQUERY)
	(SELECT 
	--MEB.id_movimentacoes_estoque_beneficio, 
	--MEB.id_tipo_beneficio,
	--MEB.tipo_movimentacao, 
	SUM(MEB.quantidade_mov) AS QTD_ENTRADA
	--MEB.data_hora_mov, MEB.descricao
	FROM movimentacoes_estoque_beneficios AS MEB
	INNER JOIN tipo_beneficio AS TB
	ON MEB.id_tipo_beneficio = TB.id_tipo_beneficio
	WHERE TB.id_tipo_beneficio = MEB_EXTERNO.id_tipo_beneficio AND MEB.tipo_movimentacao = 1 
	--GROUP BY MEB.tipo_movimentacao
	) - 
	--SUBSELEC(SUBQUERY)
	(SELECT 
	--MEB.id_movimentacoes_estoque_beneficio, 
	--MEB.id_tipo_beneficio,
	--MEB.tipo_movimentacao, 
	SUM(MEB.quantidade_mov) AS QTD_SAIDA
	--MEB.data_hora_mov, MEB.descricao
	FROM movimentacoes_estoque_beneficios AS MEB
	INNER JOIN tipo_beneficio AS TB
	ON MEB.id_tipo_beneficio = TB.id_tipo_beneficio
	WHERE TB.id_tipo_beneficio = MEB_EXTERNO.id_tipo_beneficio AND MEB.tipo_movimentacao = 0
	--GROUP BY MEB.tipo_movimentacao
	) AS QTD_ATUAL 
	FROM movimentacoes_estoque_beneficios AS MEB_EXTERNO 
	INNER JOIN tipo_beneficio as TB
	ON MEB_EXTERNO.id_tipo_beneficio = TB.id_tipo_beneficio
	INNER JOIN unidades_medidas_beneficios AS UMB
	ON TB.id_unidade_medida = UMB.id_unidade
	INNER JOIN categoria_beneficios AS C
	ON TB.id_categoria = C.id_categoria;



-- qtd de beneficios cadastrados
SELECT  COUNT(DISTINCT id_tipo_beneficio) AS QTD_BENEFICIOS 
FROM beneficio;

-- SELECIONA A QUANTIDAD DE BENEFICIOS POR CATEGORIA
SELECT CB.nome AS nome_categoria, COUNT(DISTINCT TB.nome_tipo) AS qtd_beneficio_categoria 
FROM tipo_beneficio AS TB 
INNER JOIN categoria_beneficios AS CB
ON TB.id_categoria = CB.id_categoria
GROUP BY CB.nome;

--traz todas as movimentações de um beneficio

SELECT MEB.quantidade_mov,  MEB.data_hora_mov, MEB.tipo_movimentacao,
MEB.descricao, TB.nome_tipo, UMB.sigla, CB.nome
FROM movimentacoes_estoque_beneficios MEB
INNER JOIN tipo_beneficio AS TB
ON MEB.id_tipo_beneficio = TB.id_tipo_beneficio
INNER JOIN unidades_medidas_beneficios AS UMB
ON TB.id_unidade_medida = UMB.id_unidade
INNER JOIN categoria_beneficios AS CB
ON TB.id_categoria = CB.id_categoria
WHERE MEB.id_tipo_beneficio = 29 ORDER BY MEB.data_hora_mov ASC;


-- TRAZ A QTD_ATUAL DE UM BENEFICIO INFORMADO pelo nome_tipo
SELECT
	DISTINCT MEB_EXTERNO.id_tipo_beneficio,
	TB.nome_tipo,
	UMB.sigla AS unidade_medida,
	C.nome AS nome_categoria,
	(	SELECT 
			SUM(MEB.quantidade_mov) AS QTD_ENTRADA
		FROM movimentacoes_estoque_beneficios AS MEB
		INNER JOIN tipo_beneficio AS TB_INTERNO
		ON MEB.id_tipo_beneficio = TB_INTERNO.id_tipo_beneficio
		WHERE TB_INTERNO.id_tipo_beneficio = MEB_EXTERNO.id_tipo_beneficio  
	 	AND MEB.tipo_movimentacao = 1 
	) - 
	(	SELECT  
			SUM(MEB.quantidade_mov) AS QTD_SAIDA
		FROM movimentacoes_estoque_beneficios AS MEB
		INNER JOIN tipo_beneficio AS TB
		ON MEB.id_tipo_beneficio = TB.id_tipo_beneficio
		WHERE TB.id_tipo_beneficio = MEB_EXTERNO.id_tipo_beneficio 
	 	AND MEB.tipo_movimentacao = 0
	) AS QTD_ATUAL 
	FROM movimentacoes_estoque_beneficios AS MEB_EXTERNO 
	INNER JOIN tipo_beneficio as TB
	ON MEB_EXTERNO.id_tipo_beneficio = TB.id_tipo_beneficio
	INNER JOIN unidades_medidas_beneficios AS UMB
	ON TB.id_unidade_medida = UMB.id_unidade
	INNER JOIN categoria_beneficios AS C
	ON TB.id_categoria = C.id_categoria 
	WHERE TB.nome_tipo LIKE '%C%';

-- quantidade atual de um beneficio por seu id
SELECT
	(SELECT 
	SUM(MEB.quantidade_mov) AS QTD_ENTRADA
	FROM movimentacoes_estoque_beneficios AS MEB
	INNER JOIN tipo_beneficio AS TB
	ON MEB.id_tipo_beneficio = TB.id_tipo_beneficio
	WHERE TB.id_tipo_beneficio = 1 AND MEB.tipo_movimentacao = 1 
	) - 
	(SELECT  
	SUM(MEB.quantidade_mov) AS QTD_SAIDA
	FROM movimentacoes_estoque_beneficios AS MEB
	INNER JOIN tipo_beneficio AS TB
	ON MEB.id_tipo_beneficio = TB.id_tipo_beneficio
	WHERE TB.id_tipo_beneficio = 1 AND MEB.tipo_movimentacao = 0
	) AS QTD_ATUAL;
	
	
-- mostra as entregas realizadas
SELECT TO_CHAR(EN.data_entrega, 'DD/MM/YYYY HH24:MI:SS') AS data_entrega, 
EN.quantidade_entregue AS quantidade_entregue_beneficio,
B.cpf_beneficiario, B.primeiro_nome_beneficiario || B.ultimo_nome_beneficiario AS nome_completo,
B.nis_beneficiario, B.celular_beneficiario_required, B.celular_beneficiario_opcional,
B.endereco_beneficiario, B.bairro_beneficiario, B.cidade_beneficiario, B.uf_beneficiario,
B.qtd_pessoas_resid_beneficiario, B.renda_per_capita_beneficiario, B.email_benef, B.cep_benef, 
B.complemento_ende_benef, B.abrangencia_cras_benef, U.nome_usuario, U.cpf_usuario, 
U.email_usuario, U.cargo_usuario, U.celular_usuario, U.id_usuario,
TB.nome_tipo AS nome_tipo_beneficio, TB.id_tipo_beneficio, UM.sigla AS unidade_medida_beneficio,
CB.nome AS categoria_beneficio
FROM entregas_beneficios AS EN
INNER JOIN beneficiarios AS B
ON EN.id_beneficiario = B.id_beneficiario
INNER JOIN usuario AS U
ON EN.id_usuario_responsavel_entrega = U.id_usuario
INNER JOIN tipo_beneficio AS TB
ON EN.id_tipo_beneficio = TB.id_tipo_beneficio
INNER JOIN unidades_medidas_beneficios AS UM
ON TB.id_unidade_medida = UM.id_unidade
INNER JOIN categoria_beneficios AS CB
ON TB.id_categoria = CB.id_categoria;












