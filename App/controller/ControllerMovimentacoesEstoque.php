<?php

require_once("../dao/DaoMovimentacoesEstoqueBeneficios.php");
require_once("../model/ModelMovimentacoesEstoqueBeneficios.php");

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $operacao = $_POST["operacao"];
    $controller = new ControllerMovimentacoesEstoque($operacao, "POST");
}

class ControllerMovimentacoesEstoque{
    
    private string $operacao;
    private string $methodHttp;
    private ModelMovimentacoesEstoqueBeneficios $modelEstoque;
    private DaoMovimentacoesEstoqueBeneficios $daoEstoque;
    private array $responseJson;

    public function __construct(string $operacao, string $methodHttp)
    {
        $this->operacao = $operacao;
        $this->methodHttp = $methodHttp;
        switch($this->operacao) {
            case "listar":
                $this->listarBeneficios($this->methodHttp);
                break;
            default:
                echo "Operação solicitada na controller não existe";
        }
    }

    public function listarBeneficios(string $methodHttp) {
        if($methodHttp === "POST") {
            $this->daoEstoque = new DaoMovimentacoesEstoqueBeneficios(new DataBase());
            $resul = $this->daoEstoque->selectAll();
            if(is_array($resul)) {
               $lista = array();
               foreach($resul as $chave => $valor) {  
                    if($valor["tipo_mov"] === 1) {
                       $valor["tipo_mov"] = "ENTRADA";
                    }else{
                        $valor["tipo_mov"] = "SAIDA";
                    }
                    array_push($lista, $valor);
               }
               $response = array("data" => $lista);
               echo json_encode($response);      
            }else{
                $this->setResponseJson("response", "Houve um erro ao buscar os beneficios cadastrados. erro interno no servidor.");
                echo $this->getResponseJson(); 
            }
        }else{
            $this->setResponseJson("response", "Method HTTP não e do tipo POST, erro interno no servidor.");
            echo $this->getResponseJson();
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
    public function setResponseJson(string $chave, string $responseValor) {
        if($chave === "response") {
            $res = array($chave => $responseValor = $responseValor); 
        }else{
            $res = array($chave => $responseValor);
        }
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
    public function setModelEstoque(ModelMovimentacoesEstoqueBeneficios $m) {
        $this->modelEstoque = $m;
    }
    public function getModelEstoque() : ModelMovimentacoesEstoqueBeneficios{
        return $this->modelEstoque;
    }
    public function setDaoEstoque(DaoMovimentacoesEstoqueBeneficios $d) {
        $this->daoEstoque = $d;
    }
    public function getDaoEstoque() : DaoMovimentacoesEstoqueBeneficios{
        return $this->daoEstoque;
    }
}

?>