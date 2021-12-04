<?php 

require_once("../model/ModelTipoAquisicao.php");
require_once("../utils/DataBase.php");

class DaoTipoAquisicao{
    private PDO $connection;
    private ModelTipoAquisicao $tipoAquisicao;

    public function __construct(DataBase $con) {
        $this->connection = $con->conexaoSGBD;
    }

    public function setConnection(DataBase $con) {
        $this->connection = $con;
    }
    public function getConnection() : PDO {
        return $this->connection;
    }
    public function setModel(ModelTipoAquisicao $model) {
        $this->tipoAquisicao = $model;
    }
    public function getModel() : ModelTipoAquisicao{
        return $this->tipoAquisicao;
    }

    public function insert(ModelTipoAquisicao $tipo) {
        if(is_null($this->connection)) {
            return false;
        }else{
            try {
                $sql = "INSERT INTO tipo_aquisicao(tipo) VALUES (?);";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindValue(1, $tipo->getTipo(), PDO::PARAM_STR);
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
                //violação da constraint UNIQUE nome tipo
                if($p->getCode() === 23505) {
                    //nome de tipo no registro informado ja, existe na tabela
                    echo "Error!: falha ao preparar consulta INSERT tipo_aquisicao: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                    return false;
                    //A função exit() termina a execução do script. Ela mostra o parâmetro status justamente antes de sair.
                    die();
                }else{
                    echo "Error!: falha ao preparar consulta INSERT tipo_aquisicao: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                    return false;
                    //A função exit() termina a execução do script. Ela mostra o parâmetro status justamente antes de sair.
                    die();
                }
            }
        }
    }

    public function select() {
        if(is_null($this->connection)) {
            return false;    
        }else{
            try {
                $sql = "SELECT * FROM tipo_aquisicao ORDER BY tipo ASC;";
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
                echo "Error!: falha ao preparar consulta SELECT TIPO_AQUISICAO: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
            }
        } 
    }

    public function update(ModelTipoAquisicao $model) {
        if(is_null($this->connection)) {
            return false;    
        }else{
            try {
                $sql = "UPDATE tipo_aquisicao SET tipo=?
                WHERE id_tipo_aquisicao=?";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindValue(1, $model->getTipo(), PDO::PARAM_STR);
                $stmt->bindValue(2, $model->getId(), PDO::PARAM_INT);
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
                echo "Error!: falha ao preparar consulta UPDATE TIPO_AQUISICAO: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
            }
            
        }
    }

    public function delete(int $id) {
        if(is_null($this->connection)) {
            return false;    
        }else{
            try {
                $sql = "DELETE FROM tipo_aquisicao
                WHERE id_tipo_aquisicao=?";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindValue(1, $id, PDO::PARAM_INT);
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
                echo "Error!: falha ao preparar consulta DELETE TIPO_AQUISICAO: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
            }
        }
    }
}

?>