<?php

require_once("../model/ModelAuxUsuarioBeneficiario.php");
require_once("../utils/DataBase.php");

class DaoUsuarioBeneficiarioAux{

    private PDO $connection;
    private ModelOperacaoUsuarioBeneficiario $modelAux;

    public function __construct()
    {
        
    }

    public function insertOperacaoUsuarioBeneficiario(ModelOperacaoUsuarioBeneficiario $model) : bool {
        $this->modelAux = $model;
        if(is_null($this->connection)) {
            return false;
            die();
        }else{
            try {
                $sql = "INSERT INTO tbl_operaca_usuario_beneficiario(fk_beneficiario, fk_usuario, tipo_operacao, data_hora_operacao) VALUES (?, ?, ?, ?);";   
                $stmt = $this->connection->prepare($sql);
                $valores = array($this->modelAux->getFkBeneficiario(), $this->modelAux->getFkUsuario(), $this->modelAux->getTipoOperacao(), $this->modelAux->getDataHoraOperacao());
                $stmt->execute($valores);
                //executou consulta com sucesso
                if($stmt) {
                    $stmt = null;
                    $this->connection = null;
                    return true;
                }else{
                    //falha ao executar consulta
                    return false;
                }        
            } catch (PDOException $p) {
                $stmt = null;
                $this->connection = null;
                echo "Error!: falha ao preparar consulta INSERT tbl_operaca_usuario_beneficiario: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return null;
                //A função exit() termina a execução do script. Ela mostra o parâmetro status justamente antes de sair.
                die();
            }  
        }
    }

    public function setConnection(DataBase $con) {
        $this->connection = $con;
    }
    public function getConnection() : PDO {
        return $this->connection;
    }
    public function setModel(ModelOperacaoUsuarioBeneficiario $model) {
        $modelAux = $model;
    }
    public function getModel() : ModelOperacaoUsuarioBeneficiario {
        return $this->modelAux;
    }


}

?>