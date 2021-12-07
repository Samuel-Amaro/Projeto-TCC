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
                $sql = "INSERT INTO movimentacoes_estoque_beneficios(id_tipo_beneficio, tipo_movimentacao, quantidade_mov, descricao) VALUES (?, ?, ?, ?);";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindValue(1, $model->getIdTipoBeneficio(), PDO::PARAM_INT);
                $stmt->bindValue(2, $model->getTipoMovimentacao(), PDO::PARAM_INT);
                $stmt->bindValue(3, $model->getQtdMovimentada(), PDO::PARAM_INT);
                $stmt->bindValue(4, $model->getDescricao(), PDO::PARAM_STR);
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
                $sql = "SELECT ES.id_estoque, ES.id_beneficio, ES.quantidade_mov, ES.tipo_mov, BE.nome, BE.quantidade_minima, 
                BE.quantidade_maxima, BE.id_beneficio, ES.data_hora_ultima_mov, ES.id_unidade_medida, 
                ES.quantidade_por_medida, UM.sigla 
                FROM movimentacoes_estoque_beneficios AS ES INNER JOIN beneficio AS BE 
                ON ES.id_beneficio = BE.id_beneficio 
                INNER JOIN unidades_medidas_beneficios AS UM ON ES.id_unidade_medida = UM.id_unidade
                ORDER BY ES.quantidade_mov ASC ;"; 
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

    public function select(string $param) {
        switch($param) {
            case 'qtd_total_entrada':
                
                break;
            default : 
                return false;
        }
    }

    public function selectTotalBeneficios(int $tipo_mov) {
        if(is_null($this->connection)) {
            return false; 
        }else{
            try {
                //entrada
                if($tipo_mov === 1) {
                    $sql = "SELECT SUM(MV.quantidade_mov) AS QTD_TOTAL_ENTRADA
                    FROM movimentacoes_estoque_beneficios AS MV WHERE MV.tipo_mov = 1;"; 
                }//saida
                else if($tipo_mov === 0){
                    $sql = "SELECT SUM(MV.quantidade_mov) AS QTD_TOTAL_SAIDA FROM movimentacoes_estoque_beneficios AS MV WHERE MV.tipo_mov = 0;";
                }//saldo atual de todo o estoque
                else{
                    $sql = "SELECT (SELECT SUM(quantidade_mov) AS QTD_ENTRADA FROM movimentacoes_estoque_beneficios WHERE tipo_mov = 1) - (SELECT SUM(quantidade_mov) AS QTD_SAIDA FROM movimentacoes_estoque_beneficios WHERE tipo_mov = 0) AS SALDO_ATUAL;";
                }
                $stmt = $this->connection->prepare($sql);
                if($stmt->execute()) {
                    $resultado = $stmt->fetchAll();
                    //se o resultado e um array, e esse array não estiver vazio
                    if(is_array($resultado) && !empty($resultado)) {
                        //$stmt = null;
                        //unset($this->connection);         
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
            } catch (PDOException $p) {
                $stmt = null;
                unset($this->connection);
                echo "Error!: falha ao preparar consulta SELECT TOTAL ENTRADAS movimentacoes_estoque_beneficios: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
            }    
        }
    }
}

?>