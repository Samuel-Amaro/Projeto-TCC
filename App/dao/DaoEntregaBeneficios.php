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

    public function selectAll() {
        if(is_null($this->connection)) {
            return false;
        }else{
            try {
                $sql = "SELECT TO_CHAR(EN.data_entrega, 'DD/MM/YYYY HH24:MI:SS') AS data_entrega_beneficio, EN.quantidade_entregue AS quantidade_entregue_beneficio, B.cpf_beneficiario, B.primeiro_nome_beneficiario || ' '||B.ultimo_nome_beneficiario AS nome_completo, B.nis_beneficiario, B.celular_beneficiario_required, B.celular_beneficiario_opcional, B.endereco_beneficiario, B.bairro_beneficiario, B.cidade_beneficiario, B.uf_beneficiario, B.qtd_pessoas_resid_beneficiario, B.renda_per_capita_beneficiario, B.email_benef, B.cep_benef, B.complemento_ende_benef, B.abrangencia_cras_benef, U.nome_usuario, U.cpf_usuario, U.email_usuario, U.cargo_usuario, U.celular_usuario, U.id_usuario,
                TB.nome_tipo AS nome_tipo_beneficio, TB.id_tipo_beneficio, UM.sigla As unidade_medida_beneficio, CB.nome AS categoria_beneficio FROM entregas_beneficios AS EN
                INNER JOIN beneficiarios AS B ON EN.id_beneficiario = B.id_beneficiario
                INNER JOIN usuario AS U ON EN.id_usuario_responsavel_entrega = U.id_usuario
                INNER JOIN tipo_beneficio AS TB ON EN.id_tipo_beneficio = TB.id_tipo_beneficio
                INNER JOIN unidades_medidas_beneficios AS UM ON TB.id_unidade_medida = UM.id_unidade
                INNER JOIN categoria_beneficios AS CB ON TB.id_categoria = CB.id_categoria;";
                $stmt = $this->connection->prepare($sql);
                if($stmt->execute()) {
                    $resultado = $stmt->fetchAll();
                    if($stmt->rowCount() > 0) {
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
                }else{
                    $stmt = null;
                    unset($this->connection);
                    return false;
                }
            } catch (PDOException $p) {
                $stmt = null;
                unset($this->connection);
                //echo "Error!: falha ao preparar consulta SELECT ALL beneficio: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
            }
        }
    }

    public function select(string $query) {
        if(is_null($this->connection)) {
            return false;
        }else{
            try {
                $stmt = $this->connection->prepare($query);
                if($stmt->execute()) {
                    $resultado = $stmt->fetchAll();
                    if($stmt->rowCount() > 0) {
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