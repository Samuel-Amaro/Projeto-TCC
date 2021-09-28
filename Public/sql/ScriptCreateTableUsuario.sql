-- script para cria a tabela de armazenar dados do usuario do sistema.

CREATE TABLE usuario(
	id_usuario SERIAL PRIMARY KEY NOT NULL,
	cpf_usuario VARCHAR(14) NOT NULL,
	celular_usuario VARCHAR(15) NOT NULL,
	email_usuario VARCHAR(70) NOT NULL,
	cargo_usuario VARCHAR(100) NOT NULL,
	tipo_usuario VARCHAR(50) NOT NULL,
	-- so são permitidos 12 caracteres na interface mas como
	-- a senha vai ser criptografada implementar os 32 carateres
	senha_usuario VARCHAR(32) NOT NULL,
	--usar a data atual como o valor padrão para a coluna, 
	-- poderá usar CURRENT_DATE a DEFAULT
	-- yyyy-mm-dd formato por exemplo, 2000-12-31. 
	-- Ele também usa esse formato para inserir dados em uma coluna de data.
	data_cadastro_usuario DATE NOT NULL DEFAULT CURRENT_DATE
);

-- add nova coluna nome do usuario sem restrição not null
ALTER TABLE usuario ADD COLUMN nome_usuario VARCHAR(70);

-- atualizar o valor da nova coluna add para usuarios existentes
UPDATE usuario SET nome_usuario = 'Adm Sistema' WHERE id_usuario = 1;

-- add uma restrição a coluna nome_contato
ALTER TABLE usuario ALTER COLUMN nome_usuario SET NOT NULL;

--add uma constraint UNIQUE na coluna cpf, cada registro ser unico
CREATE UNIQUE INDEX CONCURRENTLY indice_exc_cpf ON usuario(cpf_usuario);

-- add a constraint UNIQUE na coluna cpf
ALTER TABLE usuario ADD CONSTRAINT unique_cpf UNIQUE USING INDEX indice_exc_cpf;

