<?php

require_once("../dao/DaoBeneficiario.php");
require_once("../utils/DataBase.php");
//require_once("../model/ModelAuxUsuarioBeneficiario.php");
//require_once("../dao/DaoUsuarioBeneficiarioAux.php");

//verifica qual o tipo de metodo e operação a se fazer
if($_SERVER["REQUEST_METHOD"] == "POST") { //Postagem de recursos no server
    $operacao = $_POST["operacao"];
    $ctr = new ControllerBeneficiario($operacao, "POST");
}

class ControllerBeneficiario{
    
    private string $operacao;
    private string $methodHttp;
    private ModelBeneficiario $modelBenef;
    private DaoBeneficiario $daoBenef;
    private array $responseJson;

    public function __construct(string $operacao, string $methodHttp)
    {
        $this->operacao = $operacao;
        $this->methodHttp = $methodHttp;
        switch($this->operacao) {
            case "cadastro":
                $this->cadastroBeneficiario($this->methodHttp);
                break;
            case "listar": 
                $this->listaBeneficiarios($this->methodHttp);
                break;
            case "alteracao": 
                $this->atualizarBeneficiario($this->methodHttp);
                break;
            case "deletar":
                $this->excluirBeneficiario($this->methodHttp);
                break;
            default:
                break;
        }
    }

    /**
     * * Este metodo e responsavel por controlar a operação de um beneficiario se cadastrar no sistema, e depois gerar uma resposta para o front end, se deu certo ou não a operação
     *  
    */
    public function cadastroBeneficiario($methodHttp) {
        if($methodHttp === "POST") {
           $this->modelBenef = new ModelBeneficiario();
           $this->modelBenef->setPrimeiroNome($_POST["primeiroNome"]);     
           $this->modelBenef->setUltimoNome($_POST["ultimoNome"]);  
           $this->modelBenef->setCpf($_POST["cpf"]);
           $this->modelBenef->setCelularRequired($_POST["telefoneObrigatorio"]);
           $this->modelBenef->setCelularOpcional($_POST["telefoneOpcional"]);
           $this->modelBenef->setCep($_POST["cep"]); 
           $this->modelBenef->setEmail($_POST["email"]);
           $this->modelBenef->setEndereco($_POST["endereco"]);
           $this->modelBenef->setComplementoEnde($_POST["complemento"]);
           $this->modelBenef->setCidade($_POST["cidade"]);
           $this->modelBenef->setUf($_POST["estado"]);
           $this->modelBenef->setBairro($_POST["bairro"]);
           $this->modelBenef->setNis($_POST["nis"]);
           $this->modelBenef->setQtdPessoasResidencia($_POST["qtdPessoasResidencia"]);
           $this->modelBenef->setRendaPerCapita($_POST["rendaPerCapita"]);
           $this->modelBenef->setObservacao($_POST["obs"]);
           $this->modelBenef->setAbrangenciaCras($_POST["abrangencia"]);
           $this->modelBenef->setFkUsuario($_POST["id_usuario"]);
           $this->daoBenef = new DaoBeneficiario(new DataBase());
           //insert foi efetuado com sucesso e gera log em log_beneficiarios
           if($this->daoBenef->insertBeneficiario($this->modelBenef)) {
                $this->setResponseJson("computedString", "Beneficiário Foi Cadastrado com Sucesso!");
                //houve erro ao encodificar o json response
                if(is_null($this->getResponseJson())) {
                    //erro, redireciona para nossa pagina de erro interno
                }else{
                    //response do server, cospe um json
                    echo $this->getResponseJson();
                }
           }else{
                $this->setResponseJson("computedString", "Houve um erro no servidor, ao executar o SQL insert da operação de um usuário sobre um beneficiário.");
                //houve erro ao encodificar o json response
                if(is_null($this->getResponseJson())) {
                    //erro, redireciona para nossa pagina de erro interno
                }else{
                    //response do server, cospe um json
                    echo $this->getResponseJson();
                }
           }
        }else{
            $this->setResponseJson("computedString", "Houve um erro no servidor, o controller recebeu um request sem ser do method do tipo POST");
            //houve erro ao encodificar o json response
            if(is_null($this->getResponseJson())) {
                //erro, redireciona para nossa pagina de erro interno
            }else{
                //response do server, cospe um json
                echo $this->getResponseJson();
            }
            //erro, redireciona para nossa pagina de erro interno
        }
    }

    public function listaBeneficiarios($methodHttp) {
        if($methodHttp === "POST"){
            $this->daoBenef = new DaoBeneficiario(new DataBase());
            if(is_null($beneficiatios =  $this->daoBenef->selectBeneficiarios())) {
                $this->setResponseJson("computedString", "Erro no nosso sistema, erro interno, erro ao fazer consulta select beneficiarios na camada controller!");
                echo $this->getResponseJson();
            }else{
                $this->setResponseJson("computedString", "Erro no nosso sistema, erro interno, erro ao fazer consulta select beneficiarios na camada controller!");
                if(json_encode($beneficiatios) != '') {
                $responseResultados = array("draw" => 1, "recordsTotal" => count($beneficiatios), "recordsFiltered" => count($beneficiatios), "data" => array()); //[]
                    
                    foreach($beneficiatios as $chave => $valor) { 
                        $valorCorretoTratado = ["id" => $valor["id_beneficiario"], 
                        "cpf" => $valor["cpf_beneficiario"], 
                        "primeiro_nome" => $valor["primeiro_nome_beneficiario"], 
                        "ultimo_nome" => $valor["ultimo_nome_beneficiario"], 
                        "nis" => $valor["nis_beneficiario"], 
                        "celular_required" => $valor["celular_beneficiario_required"], 
                        "celular_opcional" => ($valor["celular_beneficiario_opcional"] == null) ? "" : $valor["celular_beneficiario_opcional"], 
                        "endereco" => $valor["endereco_beneficiario"], 
                        "bairro" => $valor["bairro_beneficiario"], 
                        "cidade" => $valor["cidade_beneficiario"], 
                        "uf" => $valor["uf_beneficiario"], 
                        "qtd_pessoas_home" => $valor["qtd_pessoas_resid_beneficiario"], 
                        "renda" => $valor["renda_per_capita_beneficiario"], 
                        //"obs" => ($valor["observacao_beneficiario"] == null) ? "" : $valor["observacao_beneficiario"], 
                        "email" => ($valor["email_benef"] == null) ? "" : $valor["email_benef"], 
                        "cep" => ($valor["cep_benef"] == null) ? "" : $valor["cep_benef"], 
                        "complemento_ende" => ($valor["complemento_ende_benef"] == null) ? "" : $valor["complemento_ende_benef"], 
                        "abrangencia_cras" => $valor["abrangencia_cras_benef"], 
                        "data_hora" => $valor["data_hora"]];
                        array_push($responseResultados["data"], $valorCorretoTratado);
                    }
                    echo json_encode($responseResultados);
                }
                else{
                    echo $this->getResponseJson();
                }
            }
        }
    }

    /**
     * este metodo e responsavel por atualizar um usuario, retorna uma resposta da atualizaçaõ em json para o front end
    */
    public function atualizarBeneficiario($methodHttp) {
        if($methodHttp === "POST") {
            $this->daoBenef = new DaoBeneficiario(new DataBase());
            $this->modelBenef = new ModelBeneficiario();
            $this->modelBenef->setId($_POST["idBeneficiario"]);
            $this->modelBenef->setPrimeiroNome($_POST["primeiroNome"]);
            $this->modelBenef->setUltimoNome($_POST["ultimoNome"]);
            $this->modelBenef->setCpf($_POST["cpf"]);
            $this->modelBenef->setCelularRequired($_POST["telefoneObrigatorio"]);
            $this->modelBenef->setCelularOpcional($_POST["telefoneOpcional"]);
            $this->modelBenef->setCep($_POST["cep"]);
            $this->modelBenef->setEmail($_POST["email"]);
            $this->modelBenef->setEndereco($_POST["endereco"]);
            $this->modelBenef->setComplementoEnde($_POST["complemento"]);
            $this->modelBenef->setCidade($_POST["cidade"]);
            $this->modelBenef->setUf($_POST["estado"]);
            $this->modelBenef->setBairro($_POST["bairro"]);
            $this->modelBenef->setNis($_POST["nis"]);
            $this->modelBenef->setQtdPessoasResidencia($_POST["qtdPessoasResidencia"]);
            $this->modelBenef->setRendaPerCapita($_POST["rendaPerCapita"]);
            $this->modelBenef->setObservacao($_POST["obs"]);
            $this->modelBenef->setFkUsuario($_POST["id_usuario"]);
            $this->modelBenef->setAbrangenciaCras($_POST["abrangencia"]);
            $resultado = $this->daoBenef->updateBeneficiario($this->modelBenef);
            if($resultado) {
                $response = array("computedString" => "Beneficiário foi atualizado com sucesso! Recarregue a página novamente para as informações modificadas!", "modal" => "sucesso", "resultado" => $resultado);
                echo json_encode($response);
            }else{
                $response = array("computedString" => "Beneficiário não foi atualizado, porque daoBeneficiario update deu erro!", "modal" => "error", "resultado" => $resultado);
                echo json_encode($response);
            }
        }else{
            $response = array("computedString" => "Beneficiário não foi atualizado, method HTTP não e POST!");
            echo json_encode($response);
        }
    }

    /**
     * este metodo exclui um beneficiario
     */
    public function excluirBeneficiario($methodHttp) {
        if($methodHttp === "POST") {
            $this->daoBenef = new DaoBeneficiario(new DataBase());
            if($this->daoBenef->deleteBeneficiario($_POST["idBeneficiario"])) {
                $response = array("computedString" => "Beneficiário deletado com sucesso! Recarregue a página novamente para as informações modificadas!", "modal" => "sucesso");
                echo json_encode($response);
            }else{
                $response = array("computedString" => "Beneficiário não foi deletado, porque daoBeneficiario DELETE deu erro!", "modal" => "error");
                echo json_encode($response);
            }
        }else{
            $response = array("computedString" => "Beneficiário não foi atualizado, method HTTP não e POST!");
            echo json_encode($response);
        }
    }

    public function setOperacao(string $op) {
        $this->operacao = $op;
    } 
    public function getOperacao() : string{
        return $this->operacao;
    }
    public function setMetodoHttp(string $metHt) {
        $this->methodHttp = $metHt;
    }
    public function getMetodoHttp() : string{
        return $this->methodHttp;
    }
    public function setModel(ModelBeneficiario $model) {
        $this->modelBenef = $model;
    }
    public function getModel() : ModelBeneficiario{
        return $this->modelBenef;
    }
    public function setDao(DaoBeneficiario $dao) {
        $this->daoBenef = $dao;
    }
    public function getDao() : DaoBeneficiario{
        return $this->daoBenef;
    }
    public function setResponseJson(string $chave, string $responseValor) {
        $res = array($chave => $responseValor);
        $this->responseJson = $res;
    }
    public function getResponseJson() {
        if(empty($this->responseJson)) {
            return null;
        }else{
            if(empty(json_encode($this->responseJson))) {
                return null;
            }else{
                return json_encode($this->responseJson);
            }
        }
    } 
}

?>