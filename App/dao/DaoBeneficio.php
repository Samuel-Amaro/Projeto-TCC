<?php

require_once("../model/ModelBeneficio.php");
require_once("../utils/DataBase.php");

class DaoBeneficio{

    private PDO $connection;
    private ModelBeneficio $modelBeneficio;

    public function __construct(DataBase $con) {
        $this->connection = $con->conexaoSGBD;
    }

    public function setConnection(DataBase $con) {
        $this->connection = $con;
    }
    public function getConnection() : PDO {
        return $this->connection;
    }
    public function setModel(ModelBeneficio $model) {
        $this->modelBeneficio = $model;
    }
    public function getModel() : ModelBeneficio{
        return $this->modelBeneficio;
    }

    /**
     * * Esta função inseri um registro na tabela beneficio no banco de dados
     */
    public function insertBeneficio(ModelBeneficio $model) {
        $this->modelBeneficio = $model;
        if(is_null($this->connection)) {
            return false;
        }else{
            try {
                $sql = "INSERT INTO beneficio(descricao, nome, id_categoria, id_fornecedor_doador, forma_aquisicao, quantidade_minima, quantidade_maxima) VALUES (?, ?, ?, ?, ?, ?, ?);";
                $stmt = $this->connection->prepare($sql);
                $valores = array($model->getDescricao(), $model->getNome(), $model->getDescricao(), $model->getFkCategoria(), $model->getFkFornecedorDoador(), $model->getFormaAquisicao(), $model->getQtdMinima(), $model->getQtdMaxima());
                if($stmt->execute($valores)) {
                    if($stmt->rowCount() > 0) {
                       $stmt = null;
                       unset($this->connection);
                       //Retorna o ID da última linha inserida ou valor de sequência
                       //id do registro que acabou de ser inserido na tabela
                       //$idUltimoRegistroInserido = is_string($this->connection->lastInsertId()) ? $this->connection->lastInsertId() : "-1";
                       return is_string($this->connection->lastInsertId()) ? $this->connection->lastInsertId() : "-1";
                    }else{
                        $stmt = null;
                       unset($this->connection);
                       return false;
                    }
                }
            } catch (PDOException $p) {
                $stmt = null;
                unset($this->connection);
                //violação da constraint UNIQUE nome beneficio
                if($p->getCode() === 23505) {
                    //nome de beneficio no registro informado ja, existe na tabela
                    echo "Error!: falha ao preparar consulta INSERT beneficio: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                    return false;
                    //A função exit() termina a execução do script. Ela mostra o parâmetro status justamente antes de sair.
                    die();
                }else{
                    echo "Error!: falha ao preparar consulta INSERT beneficio: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                    return false;
                    //A função exit() termina a execução do script. Ela mostra o parâmetro status justamente antes de sair.
                    die();
                }
            }
        }
    }


}
?>