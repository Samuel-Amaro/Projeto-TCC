<?php 

require_once("../model/ModelCategoriaBeneficios.php");
require_once("../utils/DataBase.php");

class DaoCategoriaBeneficios{
    private PDO $connection;
    private ModelCategoriaBeneficios $modelCategoria;

    public function __construct(DataBase $con) {
        $this->connection = $con->conexaoSGBD;
    }

    public function setConnection(DataBase $con) {
        $this->connection = $con;
    }
    public function getConnection() : PDO {
        return $this->connection;
    }
    public function setModel(ModelCategoriaBeneficios $model) {
        $this->modelCategoria = $model;
    }
    public function getModel() : ModelCategoriaBeneficios{
        return $this->modelCategoria;
    }

    public function insert(ModelCategoriaBeneficios $model) {
        $this->modelCategoria = $model;
        if(is_null($this->connection)) {
            return false;
            die("<pre><code>Conexão não estabelecida para executar insert CATEGORIA</code></pre>");
        }else{
            try {
                $sql = "INSERT INTO categoria_beneficios(nome, descricao) VALUES(?, ?);";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindValue(1, $model->getNome(), PDO::PARAM_STR);
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
                $stmt = null;
                unset($this->connection);
                if($p->getCode() === 23505) {
                    //categoria, existentens ja cadastrados
                    echo "Error!: falha ao preparar consulta INSERT CATEGORIA BENEFICIO: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                    return false;
                    die();
                }else{
                    echo "Error!: falha ao preparar consulta INSERT CATEGORIA BENEFICIO: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                    return false;
                    die();
                }
            }
        }
    }

    public function selectAll() {
        if(is_null($this->connection)) {
            return "Nenhuma categoria cadastrada";
            die("<pre><code>Conexão não estabelecida para executar SELECT CATEGORIA</code></pre>");
        }else{
            try {
                $sql = "SELECT id_categoria, nome FROM categoria_beneficios;";
                $stmt = $this->connection->prepare($sql);
                if($stmt->execute()) {
                   if($stmt->rowCount() > 0) {
                      return $stmt->fetchAll();  
                   }else{
                      return "Nenhuma categoria cadastrada";
                   } 
                }else{
                    return "Nenhuma categoria cadastrada";
                }
            } catch (PDOException $p) {
                $stmt = null;
                unset($this->connection);
                echo "Error!: falha ao preparar consulta SELECT CATEGORIA BENEFICIO: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return "Nenhuma categoria cadastrada";
            }
        }
    }

}

?>