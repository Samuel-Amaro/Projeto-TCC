<?php

require_once("../model/ModelBeneficio.php");
require_once("../utils/DataBase.php");

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
    public function insertBeneficio(ModelBeneficio $model) {
        $this->modelBeneficio = $model;
        if(is_null($this->connection)) {
            return false;
        }else{
            try {
                $sql = "INSERT INTO beneficio(descricao, nome, id_categoria, id_fornecedor_doador, forma_aquisicao, quantidade_minima, quantidade_maxima) VALUES (?, ?, ?, ?, ?, ?, ?);";
                $stmt = $this->connection->prepare($sql);
                $valores = array($model->getDescricao(), $model->getNome(), $model->getFkCategoria(), $model->getFkFornecedorDoador(), $model->getFormaAquisicao(), $model->getQtdMinima(), $model->getQtdMaxima());
                if($stmt->execute($valores)) {
                    if($stmt->rowCount() > 0) {
                       //$stmt = null;
                       //unset($this->connection);
                       //Retorna o ID da última linha inserida ou valor de sequência
                       //id do registro que acabou de ser inserido na tabela
                       return is_string($this->connection->lastInsertId()) ? $this->connection->lastInsertId() : "-1";
                    }else{
                        $stmt = null;
                        unset($this->connection);
                        return false;
                    }
                }
            } catch (PDOException $p) {
                $stmt = null;
                unset($this->connection);
                //violação da constraint UNIQUE nome beneficio
                if($p->getCode() === 23505) {
                    //nome de beneficio no registro informado ja, existe na tabela
                    echo "Error!: falha ao preparar consulta INSERT beneficio: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                    return false;
                    //A função exit() termina a execução do script. Ela mostra o parâmetro status justamente antes de sair.
                    die();
                }else{
                    echo "Error!: falha ao preparar consulta INSERT beneficio: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                    return false;
                    //A função exit() termina a execução do script. Ela mostra o parâmetro status justamente antes de sair.
                    die();
                }
            }
        }
    }

    public function selectAll() {
        if(is_null($this->connection)) {
           return false;
        }else{
            try {
                $sql = "SELECT B.id_beneficio, B.nome AS nome_beneficio, B.forma_aquisicao AS forma_aquisicao_beneficio, B.data_hora AS data_hora_beneficio, B.quantidade_minima AS quantidade_minima_beneficio, B.quantidade_maxima AS quantidade_maxima_beneficio, B.descricao AS descricao_beneficio, CB.id_categoria, CB.nome AS nome_categoria_beneficio,
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


}
?>