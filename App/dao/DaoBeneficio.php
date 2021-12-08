<?php

require_once("../model/ModelBeneficio.php");
require_once("../utils/DataBase.php");
require_once("../model/ModelFornecimentoDoacaoBeneficio.php");
require_once("../model/ModelMovimentacoesEstoqueBeneficios.php");

class DaoBeneficio{

    private PDO $connection;
    private ModelBeneficio $modelBeneficio;

    public function __construct(DataBase $con) {
        $this->connection = $con->conexaoSGBD;
    }

    public function setConnection(DataBase $con) {
        $this->connection = $con;
    }
    public function getConnection() : PDO {
        return $this->connection;
    }
    public function setModel(ModelBeneficio $model) {
        $this->modelBeneficio = $model;
    }
    public function getModel() : ModelBeneficio{
        return $this->modelBeneficio;
    }

    /**
     * * Esta função inseri um registro na tabela beneficio no banco de dados
     */
    public function insertBeneficio(ModelBeneficio $model, int $idFornecedorDoador, int $idTipoAquisicao) {
        if(is_null($this->connection)) {
            return false;
        }else{
            try {
                $sql = "INSERT INTO beneficio(descricao, id_tipo_beneficio, id_fornecedor_doador, quantidade) VALUES (?, ?, ?, ?);";
                $stmt = $this->connection->prepare($sql);
                $modelFornecimentoDoacao = new ModelFornecimentoDoacaoBeneficio();
                $modelFornecimentoDoacao->setIdFornecedorDoador($idFornecedorDoador);
                $modelFornecimentoDoacao->setIdTipoAquisicao($idTipoAquisicao);
                //inicia transação
                $this->connection->beginTransaction();
                //inseri registro primeiro em tbl fornecimento_doacao
                $daoFornecimentoDoacao = new DaoFornecimentoDoacaoBeneficio(new DataBase());
                $resultInsert = $daoFornecimentoDoacao->insert($modelFornecimentoDoacao);
                //traz id do insert tbl fornecimento_doacao
                if(is_string($resultInsert) && intval($resultInsert) > 0) {
                    //inserir registro em tbl beneficio
                    $stmt->bindValue(1, $model->getDescricao(), PDO::PARAM_STR); 
                    $stmt->bindValue(2, $model->getIdTipoBeneficio(), PDO::PARAM_STR);
                    $stmt->bindValue(3, intval($resultInsert), PDO::PARAM_INT);
                    $stmt->bindValue(4, $model->getQuantidade(), PDO::PARAM_INT);
                    if($stmt->execute()) {
                        if($stmt->rowCount() > 0) {
                            //insert tbl beneficio deu certo
                            //insert agora em tbl movimentacao_estoque_beneficio    
                            $modelEstoque = new ModelMovimentacoesEstoqueBeneficios();
                            $modelEstoque->setIdTipoBeneficio($model->getIdTipoBeneficio());
                            $modelEstoque->setTipoMovimentacao(1);
                            $modelEstoque->setQtdMovimentada($model->getQuantidade());
                            $modelEstoque->setDescricao('');
                            $daoEstoque = new DaoMovimentacoesEstoqueBeneficios(new DataBase());
                            if($daoEstoque->insert($modelEstoque)) {
                                //confirma o lote de transação, todos os inserts deram certo, inseriu em 3 tabelas em uma unica transação, fica visivel para todos os usuarios essa operações no banco
                                $this->connection->commit();
                                $stmt = null;
                                unset($this->connection);
                                return true;
                            }else{
                                //cancela transação porque insert tbl_movimentacao_estoque_beneficio deu erro
                                $this->connection->rollBack();
                                $stmt = null;
                                unset($this->connection);
                                return false;
                            }
                        }else{
                            //cancela transação, porque insert em tbl_beneficio deu erro
                            $this->connection->rollBack();
                            $stmt = null;
                            unset($this->connection);
                            return false;
                        }
                    }else{
                        //cancela transação, porque insert em tbl_beneficio deu erro
                        $this->connection->rollBack();
                        $stmt = null;
                        unset($this->connection);
                        return false;
                    }
                }else{
                    //deu erro não trouxe id do insert tbl_fornecimento_doacao_beneficio
                    //cancela transação
                    $this->connection->rollBack();
                    $stmt = null;
                    unset($this->connection);
                    return false;
                }
            } catch (PDOException $p) {
                //deu exception erro, cancela tudo
                $stmt = null;
                unset($this->connection);
                $this->connection->rollBack();
                echo "Error!: falha ao preparar consulta INSERT beneficio: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
                //A função exit() termina a execução do script. Ela mostra o parâmetro status justamente antes de sair.
                die();
            }
        }
    }

    public function selectAll() {
        if(is_null($this->connection)) {
           return false;
        }else{
            try {
                $sql = "SELECT B.id_beneficio, B.nome AS nome_beneficio, B.forma_aquisicao AS forma_aquisicao_beneficio, B.data_hora AS data_hora_beneficio, B.quantidade_minima AS quantidade_minima_beneficio, B.quantidade_maxima AS quantidade_maxima_beneficio, B.descricao AS descricao_beneficio, B.saldo AS saldo, CB.id_categoria, CB.nome AS nome_categoria_beneficio,
                FD.id AS id_fornecedor_doador, FD.nome AS nome_fornecedor_doador, FD.cpf AS cpf_fornecedor_doador, FD.cnpj AS cnpj_fornecedor_doador, FD.identificacao AS identificacao_fornecedor_doador, FD.tipo_pessoa AS tipo_pessoa_fornecedor_doador,
                FD.email AS email_fornecedor_doador FROM beneficio AS B INNER JOIN categoria_beneficios AS CB ON B.id_categoria = CB.id_categoria INNER JOIN fornecedores_doadores AS FD ON B.id_fornecedor_doador = FD.id;";
                $stmt = $this->connection->prepare($sql);
                if($stmt->execute()) {
                    $resultado = $stmt->fetchAll();
                    if($stmt->rowCount() > 0) {
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
                }else{
                    $stmt = null;
                    unset($this->connection);
                    return false;
                }
            } catch (PDOException $p) {
                $stmt = null;
                unset($this->connection);
                echo "Error!: falha ao preparar consulta SELECT ALL beneficio: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
            }
        }
    }

    public function selectCountBeneficios() {
        if(is_null($this->connection)) {
            return false;
        }else{
            try {
                $sql = "SELECT COUNT(nome) AS qtd_beneficios_cadastrados FROM beneficio;";
                $stmt = $this->connection->prepare($sql);
                if($stmt->execute()) {
                    $resultado = $stmt->fetchAll();
                    if($stmt->rowCount() > 0) {
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
                }else{
                    $stmt = null;
                    unset($this->connection);
                    return false;
                }
            } catch (PDOException $p) {
                $stmt = null;
                unset($this->connection);
                echo "Error!: falha ao preparar consulta SELECT COUNT beneficio: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
            }
        }
    }


    public function selectCountBeneficiosCategoria() {
        if(is_null($this->connection)) {
            return false;
        }else{
            try {
                $sql = "SELECT CB.nome, COUNT(B.nome) AS QTD_BENEFICIO_CATEGORIA 
                FROM beneficio AS B 
                INNER JOIN categoria_beneficios AS CB
                ON B.id_categoria = CB.id_categoria
                GROUP BY CB.nome ORDER BY QTD_BENEFICIO_CATEGORIA;";
                $stmt = $this->connection->prepare($sql);
                if($stmt->execute()) {
                    $resultado = $stmt->fetchAll();
                    if($stmt->rowCount() > 0) {
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
                }else{
                    $stmt = null;
                    unset($this->connection);
                    return false;
                }
            } catch (PDOException $p) {
                $stmt = null;
                unset($this->connection);
                echo "Error!: falha ao preparar consulta SELECT COUNT BENEFICIOS CATEGORIA: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
            }
        }
    }

    /**
     * esta função traz todas as movimentações de estoque de um beneficio, ordenada pela sua data de movimentação, usando o id passado por parametro
     */
    public function selectMovimentacoesBeneficio(int $id) {
        if(is_null($this->connection)) {
           return false; 
        }else{
            try {
                $sql = "SELECT MV.quantidade_mov, MV.data_hora_ultima_mov, MV.tipo_mov,
                UM.sigla, MV.quantidade_por_medida
                FROM movimentacoes_estoque_beneficios AS MV
                INNER JOIN beneficio AS B 
                ON MV.id_beneficio = B.id_beneficio
                INNER JOIN unidades_medidas_beneficios AS UM
                ON MV.id_unidade_medida = UM.id_unidade
                WHERE MV.id_beneficio = ? ORDER BY MV.data_hora_ultima_mov ASC;";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindValue(1, $id, PDO::PARAM_INT);
                if($stmt->execute()) {
                    $resultado = $stmt->fetchAll();
                    if($stmt->rowCount() > 0) {
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
                }else{
                    $stmt = null;
                    unset($this->connection);
                    return false;
                }
            } catch (PDOException $p) {
                $stmt = null;
                unset($this->connection);
                echo "Error!: falha ao preparar consulta SELECT MOVIMENTACOES BENEFICIO: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return false;
            }
        }
    }


}
?>