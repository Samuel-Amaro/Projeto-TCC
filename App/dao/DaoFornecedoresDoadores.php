<?php

require_once("../model/ModelFornecedoresDoadores.php");
require_once("../utils/DataBase.php");

class DaoFornecedoresDoadores{

    private PDO $connection;
    private ModelFornecedorDoador $modelFornecedorDoador;

    public function setConnection(DataBase $con) {
        $this->connection = $con;
    }
    public function getConnection() : PDO {
        return $this->connection;
    }
    public function setModel(ModelFornecedorDoador $model) {
        $this->modelFornecedorDoador = $model;
    }
    public function getModel() : ModelFornecedorDoador{
        return $this->modelFornecedorDoador;
    }

    /**
     * * Esta Função inseri um registro, no banco de dados, e apos o evento de insert gera o log pela trigger associada a tabela.
     */
    public function insertFornecedorDoador(ModelFornecedorDoador $newModel) {
        $this->modelFornecedorDoador = $newModel;
        if(is_null($this->connection)) {
            return false;
            die();
        }else{
            try{
                $sql = "INSERT INTO fornecedores_doadores(nome, descricao, identificacao, tipo_pessoa, cep, endereco, complemento, 
                bairro, cidade, uf, telefone_celular, telefone_fixo, cpf, cnpj, email) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
                $stmt = $this->connection->prepare($sql);
                $valores = array($this->modelFornecedorDoador->getNome(), $this->modelFornecedorDoador->getDescricao(), $this->modelFornecedorDoador->getIdentificacao(), $this->modelFornecedorDoador->getTipoPessoa(), $this->modelFornecedorDoador->getCep(), $this->modelFornecedorDoador->getEndereco(), $this->modelFornecedorDoador->getComplemento(), $this->modelFornecedorDoador->getBairro(), $this->modelFornecedorDoador->getCidade(), $this->modelFornecedorDoador->getUf(), $this->modelFornecedorDoador->getTelefoneCelular(), $this->modelFornecedorDoador->getTelefoneFixo(), $this->modelFornecedorDoador->getCpf(), $this->modelFornecedorDoador->getCnpj(), $this->modelFornecedorDoador->getEmail());
                //executou consulta com sucesso
                if($stmt) {
                    $stmt = null;
                    unset($this->connection);
                    return true;  
                }else{
                    $stmt = null;
                    unset($this->connection);
                    //falha ao executar consulta
                    //return null;
                    return false;
                }    
            }catch(PDOException $p) {
                $stmt = null;
                unset($this->connection);
                echo "Error!: falha ao preparar consulta INSERT fornecedor_doador: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
                //A função exit() termina a execução do script. Ela mostra o parâmetro status justamente antes de sair.
                die();
            }
        }
    }

}

?>