<?php

require_once("../model/ModelBeneficio.php");
require_once("../utils/DataBase.php");
require_once("../model/ModelFornecimentoDoacaoBeneficio.php");
require_once("../model/ModelMovimentacoesEstoqueBeneficios.php");
require_once("DaoFornecimentoDoacaoBeneficio.php");
require_once("DaoMovimentacoesEstoqueBeneficios.php");

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
                if(is_string($resultInsert)) {
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
                $this->connection->rollBack();
                $stmt = null;
                unset($this->connection);
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
                $sql = "SELECT B.id_beneficio AS id_beneficio, B.descricao AS descricao_beneficio, 
                B.quantidade AS quantidade_inicial_beneficio, B.data_hora AS data_hora_insercao_beneficio, B.id_tipo_beneficio, B.id_fornecedor_doador, FD.nome AS nome_fornecedor_doador, FD.identificacao AS identificacao_fornecedor_doador, FD.tipo_pessoa AS tipo_pessoa_fornecedor_doador, FD.cpf AS cpf_fornecedor_doador, 
                FD.cnpj AS cnpj_fornecedor_doador, FD.email AS email_fornecedor_doador, TA.id_tipo_aquisicao, TA.tipo AS tipo_aquisicao, TB.nome_tipo AS nome_tipo_beneficio, TB.id_tipo_beneficio, UMB.sigla AS unidade_medida_beneficio, UMB.id_unidade AS id_unidade_medida, C.nome AS nome_categoria, C.id_categoria AS id_categoria_beneficio FROM beneficio AS B INNER JOIN fornecimento_doacao_beneficio AS FDB ON B.id_fornecedor_doador = FDB.id_fornecimento_doacao_beneficio INNER JOIN fornecedores_doadores AS FD ON FDB.id_fornecedores_doadores = FD.id INNER JOIN tipo_aquisicao AS TA ON FDB.id_tipo_aquisicao = TA.id_tipo_aquisicao INNER JOIN tipo_beneficio AS TB ON B.id_tipo_beneficio = TB.id_tipo_beneficio INNER JOIN unidades_medidas_beneficios AS UMB ON TB.id_unidade_medida = UMB.id_unidade INNER JOIN categoria_beneficios AS C ON TB.id_categoria = C.id_categoria;";
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
                $sql = "SELECT  COUNT(DISTINCT id_tipo_beneficio) AS qtd_beneficios 
                FROM beneficio;";
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
                $sql = "SELECT CB.nome AS nome_categoria, COUNT(DISTINCT TB.nome_tipo) AS qtd_beneficio_categoria 
                FROM tipo_beneficio AS TB INNER JOIN categoria_beneficios AS CB ON TB.id_categoria = CB.id_categoria GROUP BY CB.nome;";
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
                $sql = "SELECT MEB.quantidade_mov,  MEB.data_hora_mov, MEB.tipo_movimentacao,
                MEB.descricao, TB.nome_tipo, UMB.sigla, CB.nome
                FROM movimentacoes_estoque_beneficios MEB
                INNER JOIN tipo_beneficio AS TB
                ON MEB.id_tipo_beneficio = TB.id_tipo_beneficio
                INNER JOIN unidades_medidas_beneficios AS UMB
                ON TB.id_unidade_medida = UMB.id_unidade
                INNER JOIN categoria_beneficios AS CB
                ON TB.id_categoria = CB.id_categoria
                WHERE MEB.id_tipo_beneficio = ? ORDER BY MEB.data_hora_mov ASC;";
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