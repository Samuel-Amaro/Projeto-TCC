
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
    email VARCHAR(70) NOT NULL UNIQUE     
);