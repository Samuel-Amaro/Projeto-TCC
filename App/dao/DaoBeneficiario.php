<?php

//namespace DaoBeneficiario;
//use ModelBeneficiario;

require_once("../model/ModelBeneficiario.php");
require_once("../utils/DataBase.php");

class DaoBeneficiario{

    private PDO $connection;
    private ModelBeneficiario $modelBeneficiario;

    public function __construct(DataBase $con) {
        $this->connection = $con->conexaoSGBD;
    }

    public function setConnection(DataBase $con) {
        $this->connection = $con;
    }
    public function getConnection() : PDO {
        return $this->connection;
    }
    public function setModel(ModelBeneficiario $model) {
        $this->modelBeneficiario = $model;
    }
    public function getModel() : ModelBeneficiario{
        return $this->modelBeneficiario;
    }

    /**
     * * Esta função executa uma cunsulta insert  na tbl_beneficiario no banco de dados db_social
     *  
     * @return bool true : se usuario tiver sido inserido com sucesso e gerado log, false: caso hava algum erro interno
    */
    public function insertBeneficiario(ModelBeneficiario $newModelBene) : bool {
        $this->modelBeneficiario = $newModelBene;
        if(is_null($this->connection)) {
            //return null;
            return false;
            die();
        }else{
            try {
                $sql = "INSERT INTO beneficiarios(
                            cpf_beneficiario, 
                            primeiro_nome_beneficiario, 
                            ultimo_nome_beneficiario, 
                            nis_beneficiario, 
                            celular_beneficiario_required, 
                            celular_beneficiario_opcional, 
                            endereco_beneficiario, 
                            bairro_beneficiario, 
                            cidade_beneficiario, 
                            uf_beneficiario, 
                            qtd_pessoas_resid_beneficiario, 
                            renda_per_capita_beneficiario, 
                            observacao_beneficiario,
                            fk_usuario, 
                            email_benef, 
                            cep_benef, 
                            complemento_ende_benef, 
                            abrangencia_cras_benef) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";   
                $stmt = $this->connection->prepare($sql);
                $valores = array($this->modelBeneficiario->getCpf(), $this->modelBeneficiario->getPrimeiroNome(),  $this->modelBeneficiario->getUltimoNome(), $this->modelBeneficiario->getNis(),$this->modelBeneficiario->getCelularRequired(),  $this->modelBeneficiario->getCelularOpcional(), $this->modelBeneficiario->getEndereco(), $this->modelBeneficiario->getBairro(), $this->modelBeneficiario->getCidade(), $this->modelBeneficiario->getUf(), $this->modelBeneficiario->getQtdPessoasResidencia(), $this->modelBeneficiario->getRendaPerCapita(), $this->modelBeneficiario->getObservacao(), $this->modelBeneficiario->getFkUsuario(), $this->modelBeneficiario->getEmail(), $this->modelBeneficiario->getCep(), $this->modelBeneficiario->getComplementoEnde(), $this->modelBeneficiario->getAbrangenciaCras());
                $stmt->execute($valores);
                //executou consulta com sucesso
                if($stmt) {
                    $stmt = null;
                    unset($this->connection);
                    return true;  //$this->connection->lastInsertId(); //) ? $this->connection->lastInsertId() : null;
                }else{
                    $stmt = null;
                    unset($this->connection);
                    //falha ao executar consulta
                    //return null;
                    return false;
                }        
            } catch (PDOException $p) {
                $stmt = null;
                unset($this->connection);
                if($p->getCode() === 23505) {
                    //cpf ou nis, existentens ja cadastrados
                    echo "Error!: falha ao preparar consulta INSERT beneficiario: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                    return false;
                    //A função exit() termina a execução do script. Ela mostra o parâmetro status justamente antes de sair.
                    die();
                }else{
                    echo "Error!: falha ao preparar consulta INSERT beneficiario: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                    return false;
                    //A função exit() termina a execução do script. Ela mostra o parâmetro status justamente antes de sair.
                    die();
                }
            }      
        }
    }

    public function selectBeneficiarios() {
        if(is_null($this->connection)) {
            return null;
            die();
        }else{
            try {
                $sql = "SELECT * FROM beneficiarios;";
                $stmt = $this->connection->prepare($sql);
                if($stmt->execute()) {
                    $resultado = $stmt->fetchAll();
                    if(empty($resultado)) {
                        $stmt = null;
                        unset($this->connection);
                        return null;
                    }else{
                        $stmt = null;
                        unset($this->connection);
                        return $resultado;
                    }
                }else{
                   $stmt = null;
                   unset($this->connection);
                   return null; 
                }
            } catch (PDOException $e) {
               echo "Error!: falha ao executar consulta SELECT beneficiarios: <pre><code>" . $e->getMessage() . "</code></pre></br>";
               return null;
            }
        }
    }

    /**
     * Este metodo atualiza uma registro de um beneficiario, que foi solicitado por uma usuario;
     *  
    */
    public function updateBeneficiario(ModelBeneficiario $newModelBene) : bool{
        $this->modelBeneficiario = $newModelBene;
        if(is_null($this->connection)) {
            return false;
            die();
        }else{
            try{
                //não esta atualizando porque não estou inicializando o atributo id do model
               $sql = "UPDATE beneficiarios SET 
               cpf_beneficiario = ?,
               primeiro_nome_beneficiario=?,
               ultimo_nome_beneficiario=?,
               nis_beneficiario=?,
               celular_beneficiario_required=?,
               celular_beneficiario_opcional=?,
               endereco_beneficiario=?,
               bairro_beneficiario=?,
               cidade_beneficiario=?,
               uf_beneficiario=?,
               qtd_pessoas_resid_beneficiario=?,
               renda_per_capita_beneficiario=?, 
               observacao_beneficiario=?,
               fk_usuario=?,
               email_benef=?,
               cep_benef=?,
               complemento_ende_benef=?,
               abrangencia_cras_benef=?  
               WHERE id_beneficiario = ?;";
               $stmt = $this->connection->prepare($sql);
               $valores = array($this->modelBeneficiario->getCpf(), $this->modelBeneficiario->getPrimeiroNome(), $this->modelBeneficiario->getUltimoNome(), $this->modelBeneficiario->getNis(), $this->modelBeneficiario->getCelularRequired(), $this->modelBeneficiario->getCelularOpcional(), $this->modelBeneficiario->getEndereco(), $this->modelBeneficiario->getBairro(), $this->modelBeneficiario->getCidade(), $this->modelBeneficiario->getUf(), $this->modelBeneficiario->getQtdPessoasResidencia(), $this->modelBeneficiario->getRendaPerCapita(), $this->modelBeneficiario->getObservacao(), $this->modelBeneficiario->getFkUsuario(), $this->modelBeneficiario->getEmail(), $this->modelBeneficiario->getCep(), $this->modelBeneficiario->getComplementoEnde(), $this->modelBeneficiario->getAbrangenciaCras(), $this->modelBeneficiario->getId());
               if($stmt->execute($valores)) {
                    //1 ou mais linhas atualizadas
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
            } catch (PDOException $e) {
               header("Location: ../view/ErroInterno500.php"); // "Error!: falha ao executar consulta UPDATE beneficiarios: <pre><code>" . $e->getMessage() . "</code></pre></br>";
               $stmt = null;
               unset($this->connection);
               return false;
            }
        }
    }

    /**
     * este metodo deleta um registro de beneficiario pelo seu id
     */
    public function deleteBeneficiario(int $idBeneficiario) : bool {
        if(is_null($this->connection)) {
            return false;
            die();
        }else{
            try {
                $sql = "DELETE FROM beneficiarios
                WHERE id_beneficiario = ?;";
                $stmt = $this->connection->prepare($sql);
                $stmt->bindValue(1, $idBeneficiario, PDO::PARAM_INT);
                if($stmt->execute()) {
                    //1 ou mais linhas deletadas
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
            } catch(PDOException $th) {
               echo "Error!: falha ao executar consulta DELETE beneficiarios: <pre><code>" . $th->getMessage() . "</code></pre></br>";
               $stmt = null;
               unset($this->connection);
               return false;
            }  
        }
    }

    public function selectCountBeneficiarios() {
        if(is_null($this->connection)) {
            return false;
        }else{
            try {
                $sql = "SELECT COUNT(nis_beneficiario) as qtd FROM beneficiarios;";
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
                echo "Error!: falha ao executar consulta SELECT COUNT beneficiarios: <pre><code>" . $p->getMessage() . "</code></pre></br>";
                $stmt = null;
                unset($this->connection);
                return false;
            }
        }
    }
}

?>