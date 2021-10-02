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
     * @return string|null retornar o id do ultimo insert executado ou um valor null
    */
    public function insertBeneficiario(ModelBeneficiario $newModelBene) {
        $this->modelBeneficiario = $newModelBene;
        if(is_null($this->connection)) {
            return null;
            die();
        }else{
            try {
                $sql = "INSERT INTO beneficiario(
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
                            email, 
                            cep, 
                            complemento_ende, 
                            abrangencia_cras) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";   
                $stmt = $this->connection->prepare($sql);
                $valores = array($this->modelBeneficiario->getCpf(), $this->modelBeneficiario->getPrimeiroNome(),  $this->modelBeneficiario->getUltimoNome(), $this->modelBeneficiario->getNis(),$this->modelBeneficiario->getCelularRequired(),  $this->modelBeneficiario->getCelularOpcional(), $this->modelBeneficiario->getEndereco(), $this->modelBeneficiario->getBairro(), $this->modelBeneficiario->getCidade(), $this->modelBeneficiario->getUf(), $this->modelBeneficiario->getQtdPessoasResidencia(), $this->modelBeneficiario->getRendaPerCapita(), $this->modelBeneficiario->getObservacao(), $this->modelBeneficiario->getEmail(), $this->modelBeneficiario->getCep(), $this->modelBeneficiario->getComplementoEnde(), $this->modelBeneficiario->getAbrangenciaCras());
                $stmt->execute($valores);
                //executou consulta com sucesso
                if($stmt) {
                    $stmt = null;
                    //unset($this->connection);
                    return $this->connection->lastInsertId(); //) ? $this->connection->lastInsertId() : null;
                }else{
                    $stmt = null;
                    unset($this->connection);
                    //falha ao executar consulta
                    return null;
                }        
            } catch (PDOException $p) {
                $stmt = null;
                unset($this->connection);
                echo "Error!: falha ao preparar consulta INSERT beneficiario: <pre><code>" . $p->getMessage() . "</code></pre> </br>";
                return null;
                //A função exit() termina a execução do script. Ela mostra o parâmetro status justamente antes de sair.
                die();
            }      
        }
    }

    public function selectBeneficiario(string $cpf) {
        if(is_null($this->connection)) {
            return null;
            die();
        }else{
            try {
                $sql = "SELECT * FROM beneficiario WHERE cpf_beneficiario = ?;";
                $stmt = $this->connection->prepare($sql);
                $valores = array($cpf);
                if($stmt->execute($valores)) {
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
               echo "Error!: falha ao executar consulta SELECT beneficiario: <pre><code>" . $e->getMessage() . "</code></pre></br>";
               return null;
            }
        }
    }


}

?>