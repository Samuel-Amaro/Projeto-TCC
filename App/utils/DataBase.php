<?php

/**
 * esta classe representa as conexões com o banco de dados 
*/
class DataBase{

    //constantes
    private const DSN = "pgsql";
    private const HOST = "localhost";
    private const PORT = "5432";
    private const DBNAME = "db_social";
    private const USER = "postgres";
    private const PASSWORD = "123";

    //atributo
    public $conexaoSGBD;

    public function  __construct() {
        $this->conexaoSGBD = $this->conectaBanco();
    }

    /**
     * cria uma conexão com o bando de dados 
    */
    private function conectaBanco() {
        try {
            $dsn = self::DSN . ": host = " . self::HOST . "; port = " . self::PORT . "; dbname = " . self::DBNAME . ";";
            //echo $dsn;
            $dbh = new PDO($dsn, self::USER, self::PASSWORD);
            return $dbh;
        } catch (PDOException $e) {
            print "Error!: ao se conectar ao SGBD Postgres: " . $e->getMessage() . "</br>";
            die("Error: <code> {$e->getMessage()} </code>");
            return null;
        }
    }

    /**
     * fecha a conexão com o banco de dados 
    */
    public function fecharConexao() : bool {
        if(empty($this->conexaoSGBD) || is_null($this->conexaoSGBD) || !isset($this->conexaoSGBD)) {
            return true;
        }else{
            $this->conexaoSGBD = null;
            unset($this->conexaoSGBD);
        }
    }


}


?>