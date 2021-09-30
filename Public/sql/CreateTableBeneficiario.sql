
CREATE TABLE beneficiario(
  id_beneficiario SERIAL PRIMARY KEY NOT NULL,
  cpf_beneficiario VARCHAR(11) NOT NULL, --11122233390
  primeiro_nome_beneficiario VARCHAR(35) NOT NULL,
  ultimo_nome_beneficiario VARCHAR(35) NOT NULL,
  nis_beneficiario VARCHAR(11) NOT NULL,
  celular_beneficiario_required VARCHAR(11) NOT NULL, --61990901212
  celular_beneficiario_opcional VARCHAR(11),
  endereco_beneficiario VARCHAR(150) NOT NULL,
  bairro_beneficiario VARCHAR(50) NOT NULL,
  cidade_beneficiario VARCHAR(50) NOT NULL,
  uf_beneficiario CHAR(2) NOT NULL,
  qtd_pessoas_resid_beneficiario INT NOT NULL,
  renda_per_capita_beneficiario NUMERIC NOT NULL, 
  observacao_beneficiario TEXT
);

--add uma constraint UNIQUE na coluna cpf, cada registro ser unico
CREATE UNIQUE INDEX CONCURRENTLY indice_exe_beneficiario ON beneficiario(cpf_beneficiario);

-- add a constraint UNIQUE na coluna cpf
ALTER TABLE beneficiario ADD CONSTRAINT unique_beneficiario UNIQUE USING INDEX indice_exe_beneficiario;

--add uma constraint UNIQUE na coluna cpf, cada registro ser unico
CREATE UNIQUE INDEX CONCURRENTLY indice_unique_nis ON beneficiario(nis_beneficiario);

-- add a constraint UNIQUE na coluna nis
ALTER TABLE beneficiario ADD CONSTRAINT unique_nis UNIQUE USING INDEX indice_unique_nis;

-- add coluna email
ALTER TABLE beneficiario ADD COLUMN email VARCHAR(70);

--add coluna cep
ALTER TABLE beneficiario ADD COLUMN cep VARCHAR(10);

--add coluna complemento
ALTER TABLE beneficiario ADD COLUMN complemento_ende TEXT;

--add coluna abrangencia
ALTER TABLE beneficiario ADD COLUMN abrangencia_cras VARCHAR(30);

-- add indice para constraint UNIQUE
CREATE UNIQUE INDEX CONCURRENTLY indice_unico_email ON beneficiario(email);

-- add constranint UNIQUE email
ALTER TABLE beneficiario ADD CONSTRAINT unique_email UNIQUE USING INDEX indice_unico_email;

-- add indice para constraint UNIQUE cpf
CREATE UNIQUE INDEX CONCURRENTLY indice_unico_cpf ON beneficiario(cpf_beneficiario);

-- add indice unico junto com contraint UNIQUE coluna cpf
ALTER TABLE beneficiario ADD CONSTRAINT unique_cpf UNIQUE USING INDEX indice_unico_cpf;