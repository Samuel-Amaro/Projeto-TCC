<?php 

require_once("../model/ModelUnidadesMedidas.php");
require_once("../utils/DataBase.php");

class DaoUnidadesMedidas{
    private PDO $connection;
    private ModelUnidadesMedidas $modelUnidade;

    public function __construct(DataBase $con) {
        $this->connection = $con->conexaoSGBD;
    }

    public function setConnection(DataBase $con) {
        $this->connection = $con;
    }
    public function getConnection() : PDO {
        return $this->connection;
    }
    public function setModel(ModelUnidadesMedidas $model) {
        $this->modelUnidade = $model;
    }
    public function getModel() : ModelUnidadesMedidas{
        return $this->modelUnidade;
    }

    public function insert(ModelUnidadesMedidas $model) : bool {
        $this->modelUnidade = $model;
        if(is_null($this->connection)) {
            return false;
            die("<pre><code>CONEXÃO NÃO ESTABELECIDA PARA INSERT UNIDADES DE MEDIDA</code></pre>");
        }else{
            try {
                $sql = "INSERT INTO unidades_medidas_beneficios(sigla, descricao) VALUES(?,?);";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindValue(1, $model->getSigla(), PDO::PARAM_STR);
                $stmt->bindValue(2, $model->getDescricao(), PDO::PARAM_STR);
                if($stmt->execute()) {
                    if($stmt->rowCount() > 0) {
                        $stmt = null;
                        unset($this->connection);
                        return true;
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
            } catch (PDOException $p) {
                echo "Error!: falha ao preparar consulta INSERT UNIDADES DE MEDIDA: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
            }
        }
    }
}

?>