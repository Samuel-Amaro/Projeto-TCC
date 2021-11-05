
-- unidades de medidas de beneficios ja executadas
CREATE TABLE unidades_medidas_beneficios(
    id_unidade SERIAL PRIMARY KEY NOT NULL,
    sigla CHAR(2) NOT NULL,
    descricao VARCHAR(50) NOT NULL
);
