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
}

?>