<?php 

require_once("../model/ModelFornecimentoDoacaoBeneficio.php");
require_once("../utils/DataBase.php");

class DaoFornecimentoDoacaoBeneficio{
    
    private PDO $connection;
    private ModelFornecimentoDoacaoBeneficio $modelFornDoacBenef;

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
    public function setModel(ModelFornecimentoDoacaoBeneficio $model) {
        $this->modelFornDoacBenef = $model;
    }
    public function getModel() : ModelFornecimentoDoacaoBeneficio{
        return $this->modelFornDoacBenef;
    }

    public function insert(ModelFornecimentoDoacaoBeneficio $model) {
        if(is_null($this->connection)) {
            return false; 
        }else{
            try {
                $sql = "INSERT INTO fornecimento_doacao_beneficio(id_fornecedores_doadores, id_tipo_aquisicao) VALUES (?, ?);";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindValue(1, $model->getIdFornecedorDoador(), PDO::PARAM_INT);
                $stmt->bindValue(2, $model->getIdTipoAquisicao(), PDO::PARAM_INT);
                if($stmt->execute()) {
                    if($stmt->rowCount() > 0) {
                        $stmt = null;
                        unset($this->connection);
                        //retorna o id do ultimo registro inserido ou false
                        return is_string($this->connection->lastInsertId()) ? $this->connection->lastInsertId() : false;
                    }else{
                        $stmt = null;
                        unset($this->connection);
                        return false;
                    }
                }else{
                    $stmt = null;
                    unset($this->connection);
                    return false;
                }
            }catch (PDOException $p) {
                $stmt = null;
                unset($this->connection);
                echo "Error!: falha ao preparar consulta INSERT fornecimento_doacao_beneficio: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;   
            }
        }
    }
}

?>