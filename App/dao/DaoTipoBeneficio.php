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
                    return false;
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

    public function selectAll() {
        if(is_null($this->connection)) {
            return false;
        }else{
            try {
                $sql = "SELECT TB.id_tipo_beneficio, TB.nome_tipo, TB.data_hora, UM.id_unidade,
                UM.sigla, C.id_categoria, C.nome 
                FROM tipo_beneficio AS TB 
                INNER JOIN unidades_medidas_beneficios AS UM
                ON TB.id_unidade_medida = UM.id_unidade
                INNER JOIN categoria_beneficios AS C
                ON TB.id_categoria = C.id_categoria
                ORDER BY TB.nome_tipo ASC;";
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
                return false;
            }
        } 
    }

    public function update(ModelTipoBeneficio $model) {
        if(is_null($this->connection)) {
            return false;     
        }else{
            try {
                $sql = "UPDATE tipo_beneficio
                SET nome_tipo=?, id_unidade_medida=?, id_categoria=? WHERE id_tipo_beneficio=?;";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindValue(1, $model->getNomeTipo(), PDO::PARAM_STR);
                $stmt->bindValue(2, $model->getIdUnidadeMedida(), PDO::PARAM_INT);
                $stmt->bindValue(3, $model->getIdCategoria(), PDO::PARAM_INT);
                $stmt->bindValue(4, $model->getIdTipoBeneficio(), PDO::PARAM_INT);
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
                return false;
            }
        } 
    }

    public function delete(int $id) {
        if(is_null($this->connection)) {
            return false;    
        }else{
            try {
                $sql = "DELETE FROM tipo_beneficio WHERE id_tipo_beneficio = ?;";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindValue(1, $id, PDO::PARAM_INT);
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
                return false;
            }
        } 
    }

    public function search(string $nomeTipo) {
        if(is_null($this->connection)) {
            return false;
        }else{
            try {
                $sql = "SELECT DISTINCT MEB_EXTERNO.id_tipo_beneficio, TB.nome_tipo, UMB.sigla AS unidade_medida, C.nome AS nome_categoria, (SELECT SUM(MEB.quantidade_mov) AS QTD_ENTRADA FROM movimentacoes_estoque_beneficios AS MEB INNER JOIN tipo_beneficio AS TB_INTERNO ON MEB.id_tipo_beneficio = TB_INTERNO.id_tipo_beneficio WHERE TB_INTERNO.id_tipo_beneficio = MEB_EXTERNO.id_tipo_beneficio AND MEB.tipo_movimentacao = 1) - 
                (SELECT SUM(MEB.quantidade_mov) AS QTD_SAIDA FROM movimentacoes_estoque_beneficios AS MEB
                INNER JOIN tipo_beneficio AS TB ON MEB.id_tipo_beneficio = TB.id_tipo_beneficio WHERE TB.id_tipo_beneficio = MEB_EXTERNO.id_tipo_beneficio AND MEB.tipo_movimentacao = 0) AS qtd_atual FROM movimentacoes_estoque_beneficios AS MEB_EXTERNO INNER JOIN tipo_beneficio as TB ON MEB_EXTERNO.id_tipo_beneficio = TB.id_tipo_beneficio INNER JOIN unidades_medidas_beneficios AS UMB ON TB.id_unidade_medida = UMB.id_unidade INNER JOIN categoria_beneficios AS C ON TB.id_categoria = C.id_categoria WHERE TB.nome_tipo LIKE ?;";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindValue(1, "%" . $nomeTipo . "%", PDO::PARAM_STR);
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
                return false;
            }
        }
    }

}

?>