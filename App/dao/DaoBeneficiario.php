<?php

//namespace DaoBeneficiario;
//use ModelBeneficiario;

require_once("../model/ModelBeneficiario.php");
require_once("../utils/DataBase.php");

class DaoBeneficiario{

    private PDO $connection;
    private ModelBeneficiario $modelBeneficiario;

    public function __construct(DataBase $con, ModelBeneficiario $model) {
        $this->connection = $con->conexaoSGBD;
        $this->modelBeneficiario = $model;
    }

    public function setConnection(DataBase $con) {
        $this->connection = $con;
    }
    public function getConnection() : PDO {
        return $this->connection;
    }
    public function setModel(ModelBeneficiario $model) {
        $this->modelBeneficiario = $model;
    }
    public function getModel() : ModelBeneficiario{
        return $this->modelBeneficiario;
    }
}

?>