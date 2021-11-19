<?php

require_once("../model/ModelMovimentacoesEstoqueBeneficios.php");
require_once("../utils/DataBase.php");

class DaoMovimentacoesEstoqueBeneficios{

    private PDO $connection;
    private ModelMovimentacoesEstoqueBeneficios $modelMovimentacoes;

    public function __construct(DataBase $con) {
        $this->connection = $con->conexaoSGBD;
    }

    public function setConnection(DataBase $con) {
        $this->connection = $con;
    }
    public function getConnection() : PDO {
        return $this->connection;
    }
    public function setModel(ModelMovimentacoesEstoqueBeneficios $model) {
        $this->modelMovimentacoes = $model;
    }
    public function getModel() : ModelMovimentacoesEstoqueBeneficios{
        return $this->modelMovimentacoes;
    }

    /**
     * * Esta função inseri um registro na tabela estoque_movimentações_beneficios do banco de dados
     */
    public function insert(ModelMovimentacoesEstoqueBeneficios $model) : bool {
        $this->modelMovimentacoes = $model;
        if(is_null($this->connection)) {
            return false;
        }else{
            try {
                $sql = "INSERT INTO movimentacoes_estoque_beneficios(id_beneficio, quantidade_mov, tipo_mov, id_unidade_medida, quantidade_por_medida) VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->connection->prepare($sql);
                $valores = array($model->getFkBeneficio(), $model->getQtdMovimentada(), $model->getTipoMovimentacao(), $model->getFkUnidadeMedida(), $model->getQtdPorMedida());
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
            }catch(PDOException $p) {
                $stmt = null;
                unset($this->connection);
                echo "Error!: falha ao preparar consulta INSERT movimentacoes_estoque_beneficios: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
                die(); //sai do script
            }  
        } 
    }

    public function selectAll() {
        if(is_null($this->connection)) {
           return false; 
        }else{
            try{
                $sql = "SELECT ES.quantidade_mov, ES.tipo_mov, BE.nome, BE.quantidade_minima, BE.quantidade_maxima, BE.id_beneficio FROM movimentacoes_estoque_beneficios AS ES INNER JOIN beneficio AS BE ON ES.id_beneficio = BE.id_beneficio ORDER BY ES.quantidade_mov ASC;"; 
                $stmt = $this->connection->prepare($sql);
                if($stmt->execute()) {
                    $resultado = $stmt->fetchAll();
                    //se o resultado e um array, e esse array não estiver vazio
                    if(is_array($resultado) && !empty($resultado)) {
                        $stmt = null;
                        unset($this->connection);         
                        return $resultado;
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
            }catch (PDOException $p) {
                $stmt = null;
                unset($this->connection);
                echo "Error!: falha ao preparar consulta SELECT movimentacoes_estoque_beneficios: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
                die();
            }
        }
        
    }
}

?>