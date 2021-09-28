
CREATE TABLE tbl_operaca_usuario_beneficiario(
    id_operacao SERIAL PRIMARY KEY NOT NULL,
    fk_beneficiario INT NOT NULL,
    fk_usuario INT NOT NULL,
    tipo_operacao VARCHAR(50) NOT NULL, --INSERT, DELETE, UPDATE
    data_hora_operacao DATE NOT NULL DEFAULT CURRENT_DATE,
    -- fk_user
    CONSTRAINT fk_usuario FOREIGN KEY(fk_usuario) REFERENCES usuario(id_usuario) ON DELETE CASCADE,
    --fk beneficiario
    CONSTRAINT fk_beneficiario FOREIGN KEY(fk_beneficiario) REFERENCES beneficiario(id_beneficiario) ON DELETE CASCADE
);

ALTER TABLE tbl_operaca_usuario_beneficiario ADD CONSTRAINT check_operacao
	CHECK (
		tipo_operacao = 'INSERT' OR tipo_operacao = 'DELETE' OR tipo_operacao = 'UPDATE' 
    );
