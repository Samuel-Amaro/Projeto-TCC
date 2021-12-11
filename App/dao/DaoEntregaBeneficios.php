<?php 

require_once("../model/ModelEntregaBeneficios.php");
require_once("../utils/DataBase.php");

class DaoEntregaBeneficios{

    private PDO $connection;
    private ModelEntregaBeneficios $modelEntrega;

    public function __construct(DataBase $con) {
        $this->connection = $con->conexaoSGBD;
    }

    public function setConnection(DataBase $con) {
        $this->connection = $con;
    }
    public function getConnection() : PDO {
        return $this->connection;
    }
    public function setModel(ModelEntregaBeneficios $model) {
        $this->modelEntrega = $model;
    }
    public function getModel() : ModelEntregaBeneficios{
        return $this->modelEntrega;
    }

    public function insert(ModelEntregaBeneficios $model) {
        if(is_null($this->connection)) {
            return false;
        }else{
            try {
                $sql = "INSERT INTO entregas_beneficios(id_beneficiario, id_tipo_beneficio, quantidade_entregue, id_usuario_responsavel_entrega) VALUES (?, ?, ?, ?);";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindValue(1, $model->getIdBeneficiario(), PDO::PARAM_INT);
                $stmt->bindValue(2, $model->getIdTipoBeneficio(), PDO::PARAM_INT);
                $stmt->bindValue(3, $model->getQuantidadeEntregue(), PDO::PARAM_INT);
                $stmt->bindValue(4, $model->getIdUsuarioResponsavelEntrega(), PDO::PARAM_INT);
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
                $stmt = null;
                unset($this->connection);
                echo "Error!: falha ao preparar consulta INSERT entrega_beneficio: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
            }
        }
    }
}

?>