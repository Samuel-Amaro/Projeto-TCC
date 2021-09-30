<?php

require_once("../dao/DaoBeneficiario.php");
require_once("../utils/DataBase.php");

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
            default:
                break;
        }
    }

    public function cadastroBeneficiario($methodHttp) {
        if($methodHttp === "POST") {
           $this->modelBenef = new ModelBeneficiario();
           //$this->modelBenef->setId(null);
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
           $this->daoBenef = new DaoBeneficiario(new DataBase());
           if($this->daoBenef->insertBeneficiario($this->modelBenef)) {
              $this->setResponseJson("computedString", "Beneficiário Foi Cadastrado com Sucesso!");
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

    public function verificaSeBeneficiarioExiste($methodHttp, string $cpf) {
        if($methodHttp === "POST"){
            $this->daoBenef = new DaoBeneficiario(new DataBase());
            $cpf = $_POST["cpf"];
            //beneficiario ja existe no sistema
            if(is_null($this->daoBenef->selectBeneficiario($cpf))) {
                $this->setResponseJson("computedString", "Beneficiário já esta, cadastrado no sistema!");
                if(is_null($this->getResponseJson())) {
                    //erro, redireciona para nossa pagina de erro interno
                }else{
                    echo $this->getResponseJson();
                }
            }else{
                //beneficiario não existe pode cadastrar
            }
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