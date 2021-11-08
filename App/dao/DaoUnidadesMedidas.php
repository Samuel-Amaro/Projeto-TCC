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

    public function select() {
        if(is_null($this->connection)) {
            return false;
            die("<pre><code>CONEXÃO NÃO ESTABELECIDA PARA SELECT UNIDADES DE MEDIDA</code></pre>");
        }else{
            try {
                $sql = "SELECT id_unidade, sigla, descricao FROM unidades_medidas_beneficios ORDER BY descricao ASC";
                $stmt = $this->connection->prepare($sql);
                if($stmt->execute()) {
                    if($stmt->rowCount() > 0) {
                        $resultado = $stmt->fetchAll();
                        $stmt = null;
                        unset($this->connection);
                        return is_array($resultado) ? $resultado : false;
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
                echo "Error!: falha ao preparar consulta SELECT UNIDADES DE MEDIDA: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
            }
        }
    }

    public function update(ModelUnidadesMedidas $model) {
        $this->modelUnidade = $model;
        if(is_null($this->connection)) {
            return false;
            die("<pre><code>CONEXÃO NÃO ESTABELECIDA PARA UPDATE UNIDADES DE MEDIDA</code></pre>");
        }else{
            try {
                $sql = "UPDATE unidades_medidas_beneficios SET sigla=?, descricao=? WHERE id_unidade=?;";
                $stmt = $this->connection->prepare($sql);
                $valores = array($model->getSigla(), $model->getDescricao(), $model->getId());   
                if($stmt->execute($valores)) {
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
                echo "Error!: falha ao preparar consulta UPDATE UNIDADES DE MEDIDA: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
            }
        }
    }

    public function delete(int $idUnidadeMedida) {
        if(is_null($this->connection)) {
            return false;
            die("<pre><code>CONEXÃO NÃO ESTABELECIDA PARA DELETE UNIDADES DE MEDIDA</code></pre>");
        }else{
            try {
                $sql = "DELETE FROM unidades_medidas_beneficios
                WHERE id_unidade = ?;";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindValue(1, $idUnidadeMedida, PDO::PARAM_INT);   
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
                echo "Error!: falha ao preparar consulta DELETE UNIDADES DE MEDIDA: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
            }
        }
    }
}

?>