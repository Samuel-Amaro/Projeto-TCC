<?php 

require_once("../model/ModelTipoBeneficio.php");
require_once("../utils/DataBase.php");

class DaoTipoBeneficio{
    
    private PDO $connection;
    private ModelTipoBeneficio $modelTipoBeneficio;

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
    public function setModel(ModelTipoBeneficio $model) {
        $this->modelTipoBeneficio = $model;
    }
    public function getModel() : ModelTipoBeneficio{
        return $this->modelTipoBeneficio;
    }

    public function insert(ModelTipoBeneficio $model) {
        if(is_null($this->connection)) {
            return false;
        }else{
            try {
                $sql = "INSERT INTO tipo_beneficio(nome_tipo, id_unidade_medida, id_categoria) VALUES (?, ?, ?);";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindValue(1, $model->getNomeTipo(), PDO::PARAM_STR);
                $stmt->bindValue(2, $model->getIdUnidadeMedida(), PDO::PARAM_INT);
                $stmt->bindValue(3, $model->getIdCategoria(), PDO::PARAM_INT);
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
                //violação da constraint UNIQUE nome beneficio
                if($p->getCode() === 23505) {
                    //nome de beneficio no registro informado ja, existe na tabela
                    //echo "Error!: falha ao preparar consulta INSERT TIPO_BENEFICIO: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                    return "ja_existe";
                    //A função exit() termina a execução do script. Ela mostra o parâmetro status justamente antes de sair.
                    //die();
                }else{
                    //echo "Error!: falha ao preparar consulta INSERT TIPO_BENEFICIO: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                    return false;
                    //A função exit() termina a execução do script. Ela mostra o parâmetro status justamente antes de sair.
                    //die();
                }
            }
        }    
    }

}

?>