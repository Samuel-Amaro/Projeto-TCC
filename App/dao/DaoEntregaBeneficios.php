<?php 

require_once("../model/ModelEntregaBeneficios.php");
require_once("../utils/DataBase.php");
require_once("../model/ModelMovimentacoesEstoqueBeneficios.php");
require_once("DaoMovimentacoesEstoqueBeneficios.php");

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

    public function insert(ModelEntregaBeneficios $model, ModelMovimentacoesEstoqueBeneficios $modelMovimentacao) {
        if(is_null($this->connection)) {
            return false;
        }else{
            try {
                //inserir por meio de tranção, porque temos que registrar entrega na movimentação do estoque e registrar entrega na tabela de entregas
                $sql = "INSERT INTO entregas_beneficios(id_beneficiario, id_tipo_beneficio, quantidade_entregue, id_usuario_responsavel_entrega) VALUES (?, ?, ?, ?);";
                $stmt = $this->connection->prepare($sql);
                //movimentação estoque beneficios
                //inicia transação
                $this->connection->beginTransaction();
                //inserir registro primeiro em movimentação_Estoque
                $daoEstoque = new DaoMovimentacoesEstoqueBeneficios(new DataBase());
                if($daoEstoque->insert($modelMovimentacao)) {
                    //apos insert em movimentação estoque beneficio ter dado certo, insert em tbl_entrega_beneficios
                    $stmt->bindValue(1, $model->getIdBeneficiario(), PDO::PARAM_INT);
                    $stmt->bindValue(2, $model->getIdTipoBeneficio(), PDO::PARAM_INT);
                    $stmt->bindValue(3, $model->getQuantidadeEntregue(), PDO::PARAM_INT);
                    $stmt->bindValue(4, $model->getIdUsuarioResponsavelEntrega(), PDO::PARAM_INT);
                    if($stmt->execute()) {
                        if($stmt->rowCount() > 0) {
                            //confirma a transação de insert nas duas tabelas(movimentacao_Estoque, entrega_beneficios)
                            $this->connection->commit();
                            $stmt = null;
                            unset($this->connection);
                            return true;
                        }else{
                            $this->connection->rollBack();
                            $stmt = null;
                            unset($this->connection);
                            return false;
                        }
                    }else{
                        $this->connection->rollBack();
                        $stmt = null;
                        unset($this->connection);
                        return false;
                    }
                }else{
                    $this->connection->rollBack();
                    $stmt = null;
                    unset($this->connection);
                    return false; 
                }
            } catch (PDOException $p) {
                $stmt = null;
                unset($this->connection);
                echo "Error!: falha ao preparar consulta INSERT entrega_beneficio: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
            }
        }
    }
}

?>