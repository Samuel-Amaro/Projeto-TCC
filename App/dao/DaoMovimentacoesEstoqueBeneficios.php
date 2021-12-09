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
                $sql = "SELECT DISTINCT MEB_EXTERNO.id_tipo_beneficio, TB.nome_tipo, UMB.sigla, C.nome, (SELECT SUM(MEB.quantidade_mov) AS QTD_ENTRADA FROM movimentacoes_estoque_beneficios AS MEB INNER JOIN tipo_beneficio AS TB ON MEB.id_tipo_beneficio = TB.id_tipo_beneficio
                WHERE TB.id_tipo_beneficio = MEB_EXTERNO.id_tipo_beneficio AND MEB.tipo_movimentacao = 1 ) - (SELECT SUM(MEB.quantidade_mov) AS QTD_SAIDA FROM movimentacoes_estoque_beneficios AS MEB INNER JOIN tipo_beneficio AS TB ON MEB.id_tipo_beneficio = TB.id_tipo_beneficio
                WHERE TB.id_tipo_beneficio = MEB_EXTERNO.id_tipo_beneficio AND MEB.tipo_movimentacao = 0 ) AS saldo_atual FROM movimentacoes_estoque_beneficios AS MEB_EXTERNO 
                INNER JOIN tipo_beneficio as TB ON MEB_EXTERNO.id_tipo_beneficio = TB.id_tipo_beneficio
                INNER JOIN unidades_medidas_beneficios AS UMB ON TB.id_unidade_medida = UMB.id_unidade INNER JOIN categoria_beneficios AS C ON TB.id_categoria = C.id_categoria;"; 
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
                    $sql = "SELECT SUM(MEB.quantidade_mov) AS qtd_total_entrada FROM movimentacoes_estoque_beneficios AS MEB INNER JOIN tipo_beneficio AS TB ON MEB.id_tipo_beneficio = TB.id_tipo_beneficio WHERE MEB.tipo_movimentacao = 1 GROUP BY MEB.tipo_movimentacao;"; 
                }//saida
                else if($tipo_mov === 0){
                    $sql = "SELECT SUM(MEB.quantidade_mov) AS qtd_total_saida FROM movimentacoes_estoque_beneficios AS MEB INNER JOIN tipo_beneficio AS TB ON MEB.id_tipo_beneficio = TB.id_tipo_beneficio WHERE MEB.tipo_movimentacao = 0 GROUP BY MEB.tipo_movimentacao;";
                }//saldo atual de todo o estoque
                else{
                    $sql = "SELECT (SELECT SUM(MEB.quantidade_mov) AS qtd_total_entrada_estoque FROM movimentacoes_estoque_beneficios AS MEB WHERE MEB.tipo_movimentacao = 1) - 
                   (SELECT SUM(MEB.quantidade_mov) AS qtd_total_saida_estoque FROM movimentacoes_estoque_beneficios AS MEB WHERE MEB.tipo_movimentacao = 0) AS saldo_geral_estoque;";
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