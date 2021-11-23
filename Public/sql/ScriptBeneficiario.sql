
-- CRIA TABELA DE BENEFICIARIO
CREATE TABLE beneficiarios(
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
  observacao_beneficiario TEXT,
  fk_usuario INT,
  CONSTRAINT fk_usuario FOREIGN KEY(fk_usuario) REFERENCES usuario(id_usuario) ON DELETE SET NULL,
  email_benef VARCHAR(70),
  cep_benef VARCHAR(10),
  complemento_ende_benef TEXT,
  abrangencia_cras_benef VARCHAR(30),
  data_hora TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--alterando tipo de dado da coluna para o tipo money
ALTER TABLE beneficiarios ALTER COLUMN renda_per_capita_beneficiario TYPE MONEY USING renda_per_capita_beneficiario::MONEY;

--add uma constraint UNIQUE na coluna cpf, cada registro ser unico
CREATE UNIQUE INDEX CONCURRENTLY indice_exe_beneficiarios ON beneficiarios(cpf_beneficiario);

-- add a constraint UNIQUE na coluna cpf
ALTER TABLE beneficiarios ADD CONSTRAINT unique_beneficiarios UNIQUE USING INDEX indice_exe_beneficiarios;

--add uma constraint UNIQUE na coluna cpf, cada registro ser unico
CREATE UNIQUE INDEX CONCURRENTLY indice_unique_nis_beneficiarios ON beneficiarios(nis_beneficiario);

-- add a constraint UNIQUE na coluna nis
ALTER TABLE beneficiarios ADD CONSTRAINT unique_nis_beneficiarios UNIQUE USING INDEX indice_unique_nis_beneficiarios;

-- add coluna email
--ALTER TABLE beneficiarios ADD COLUMN email_benef VARCHAR(70);

--add coluna cep
--ALTER TABLE beneficiarios ADD COLUMN cep_benef VARCHAR(10);

--add coluna complemento
--ALTER TABLE beneficiarios ADD COLUMN complemento_ende_benef TEXT;

--add coluna abrangencia
--ALTER TABLE beneficiarios ADD COLUMN abrangencia_cras_benef VARCHAR(30);

-- add indice para constraint UNIQUE
CREATE UNIQUE INDEX CONCURRENTLY indice_unico_email_benef ON beneficiarios(email_benef);

-- add constranint UNIQUE email
ALTER TABLE beneficiarios ADD CONSTRAINT unique_email_benef UNIQUE USING INDEX indice_unico_email_benef;

-- add indice para constraint UNIQUE cpf
CREATE UNIQUE INDEX CONCURRENTLY indice_unico_cpf_benef ON beneficiarios(cpf_beneficiario);

-- add indice unico junto com contraint UNIQUE coluna cpf
ALTER TABLE beneficiarios ADD CONSTRAINT unique_cpf_benef UNIQUE USING INDEX indice_unico_cpf_benef;

-- add uma restrição a coluna celular_required
ALTER TABLE beneficiarios ALTER COLUMN celular_beneficiario_required SET NOT NULL;


-------------------------------------------------------------------------------------------------------------------
-- CRIADO TBL_DE_REGISTRO DE LOG PARA BENEFICIARIO

CREATE TABLE log_beneficiarios(
    id_log SERIAL PRIMARY KEY,
    operacao VARCHAR(10),
    valores_novos TEXT,
    valores_velhos TEXT,
    id_beneficiario INT, 
    id_usuario INT,
    data_log TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);



CREATE OR REPLACE FUNCTION gera_logs_beneficiarios() RETURNS TRIGGER
LANGUAGE PLPGSQL
AS
$$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_beneficiarios(operacao, valores_novos, valores_velhos, id_beneficiario, id_usuario) VALUES(TG_OP, NEW::TEXT, '', NEW.id_beneficiario, NEW.fk_usuario); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_beneficiarios(operacao, valores_novos, valores_velhos, id_beneficiario, id_usuario) VALUES(TG_OP, NEW::TEXT, OLD::TEXT, NEW.id_beneficiario, NEW.fk_usuario); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_beneficiarios(operacao, valores_novos, valores_velhos, id_beneficiario, id_usuario) VALUES(TG_OP, OLD::TEXT, '', OLD.id_beneficiario, OLD.fk_usuario);
        RETURN OLD;
    END IF;
END;
$$

CREATE TRIGGER logs_trigger_beneficiario AFTER INSERT OR UPDATE OR DELETE ON  beneficiarios 
FOR EACH ROW EXECUTE PROCEDURE gera_logs_beneficiarios();



--------------------------------------------------------------------------------------
--- TESTES MANUAIS PARA GERAR LOG MANULAMENTE

ALTER TABLE beneficiarios ADD COLUMN data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

UPDATE beneficiarios SET data_hora = NOW();

ALTER TABLE beneficiarios ALTER COLUMN data_hora SET NOT NULL;