<?php

require_once("../dao/DaoBeneficiario.php");

//verifica qual o tipo de metodo e operação a se fazer
if($_SERVER["REQUEST_METHOD"] === "POST") { //Postagem de recursos no server
    $operacao = $_POST["operacao"];
    $ctr = new ControllerUsuario($operacao, "POST");
}else if($_SERVER["REQUEST_METHOD"] === "GET") { //obter recursos do server
    $operacao = $_GET["operacao"];
    $ctr = new ControllerUsuario($operacao, "GET");
}

class ControllerBeneficiario{
    
    private string $operacao;
    private string $methodHttp;
    private ModelBeneficiario $modelBenef;
    private DaoBeneficiario $daoBenef;
    private string $responseJson;

    public function __construct(string $operacao, string $methodHttp)
    {
        $this->operacao = $operacao;
        $this->methodHttp = $methodHttp;
        switch($this->operacao) {
            case "cadastro":
                $this->cadastroBeneficiario($this->methodHttp);
                break;
            default:
                break;
        }
    }

    public function cadastroBeneficiario($methodHttp) {
        if($methodHttp === "POST") {
           $this->modelBenef = new ModelBeneficiario();
           $this->modelBenef->setId(null);
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
           if($this->daoBenef->insertBeneficiario($this->modelBenef)) {
              $this->setResponseJson("Beneficiário Foi Cadastrado com Sucesso!");
              if(is_null($this->getResponseJson())) {
                 //erro, redireciona para nossa pagina de erro interno
              }else{
                echo $this->getResponseJson();
              }
           }else{
                //erro, redireciona para nossa pagina de erro interno
           }
        }else{
            //erro, redireciona para nossa pagina de erro interno
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
    public function setResponseJson(string $responseJ) {
        $this->responseJson = $responseJ;
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