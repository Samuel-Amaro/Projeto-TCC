-- categoria de beneficios ja executadas
CREATE TABLE categoria_beneficios(
    id_categoria SERIAL PRIMARY KEY NOT NULL,
    nome VARCHAR(100) NOT NULL,
    descricao VARCHAR(300) NOT NULL,
    data_hora TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);