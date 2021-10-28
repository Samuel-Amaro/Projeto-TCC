<?php

require_once("../model/ModelFornecedoresDoadores.php");
require_once("../utils/DataBase.php");

class DaoFornecedoresDoadores{

    private PDO $connection;
    private ModelFornecedorDoador $modelFornecedorDoador;

    public function __construct(DataBase $con)
    {
        $this->connection = $con->conexaoSGBD;
    }

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
                $stmt->execute($valores);
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

    /**
     * * Esta função faz uma busca de todos dos registros na tabela
     */
    public function selectFornecedoresDoadores() {
        if(is_null($this->connection)) {
            return false;
            die();
        }else{
            try {
                $listaFornecedoresDoadores = array();
                $sql = "SELECT * FROM fornecedores_doadores ORDER BY nome ASC;";
                $stmt = $this->connection->prepare($sql);
                //consulta executada 
                if($stmt->execute()) {
                   //varias linhas de registro de resultado sql
                   if($stmt->rowCount() > 0) {
                      $resultadoSelect = $stmt->fetchAll();
                      $stmt = null;
                      unset($this->connection);
                      return $resultadoSelect; 
                   }else{
                      //nenhuma linha de registro sql de resultado do select
                      $stmt = null;
                      unset($this->connection);
                      return false;      
                   } 
                }else{
                      //consulta não foi executada
                      $stmt = null;
                      unset($this->connection);
                      return false;  
                }
            } catch (PDOException $p) {
                echo "Error!: falha ao preparar consulta SELECT fornecedor_doador: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                $stmt = null;
                unset($this->connection);
                return false;
                die("Error!: falha ao preparar consulta SELECT fornecedor_doador: <pre><code>" . $p->getMessage() . "</code></pre> </br>");
            }
        }
    }

}

?>