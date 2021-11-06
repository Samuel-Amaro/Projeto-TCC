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
                $sql = "SELECT id_categoria, nome FROM categoria_beneficios ORDER BY nome ASC;";
                $stmt = $this->connection->prepare($sql);
                if($stmt->execute()) {
                   if($stmt->rowCount() > 0) {
                      $resultado = $stmt->fetchAll(); 
                      $stmt = null;
                      unset($this->connection);
                      return is_array($resultado) ? $resultado : "Nenhuma categoria cadastrada";
                   }else{
                      $stmt = null;
                      unset($this->connection); 
                      return "Nenhuma categoria cadastrada";
                   } 
                }else{
                    $stmt = null;
                    unset($this->connection);
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

    public function select() {
        if(is_null($this->connection)) {
            die("<pre><code>Conexão para SELECT CATEGORIA BENEFICIO não foi estabelecida!</code></pre>");
            return false;
        }else{
            try {
                $sql = "SELECT * FROM categoria_beneficios ORDER BY nome ASC;";
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
                $stmt = null;
                unset($this->connection);
                echo "Error!: falha ao preparar consulta SELECT CATEGORIA BENEFICIO: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
            }
        } 
    }

    public function update(ModelCategoriaBeneficios $model) {
        $this->modelCategoria = $model; 
        if(is_null($this->connection)) {
            die("<pre><code>Conexão para SELECT CATEGORIA BENEFICIO não foi estabelecida!</code></pre>");
            return false;
        }else{
              try {
                  $sql = "UPDATE categoria_beneficios
                  SET nome=?, descricao=? WHERE id_categoria = ?;";
                  $stmt = $this->connection->prepare($sql);
                  $valores = array($model->getNome(), $model->getDescricao(), $model->getId());
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
                $stmt = null;
                unset($this->connection);
                echo "Error!: falha ao preparar consulta UPDATE CATEGORIA BENEFICIO: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
              }  
         }   
    }

    public function delete(int $idCategoria) { 
        if(is_null($this->connection)) {
            die("<pre><code>Conexão para DELETE CATEGORIA BENEFICIO não foi estabelecida!</code></pre>");
            return false;
        }else{
            try {
                $sql = "DELETE FROM categoria_beneficios
                WHERE id_categoria = ?;";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindValue(1, $idCategoria, PDO::PARAM_INT);
                if($stmt->execute()){
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
                echo "Error!: falha ao preparar consulta DELETE CATEGORIA BENEFICIO: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
            }   
        }
    }

}

?>