<?php 

require_once("../dao/DaoUnidadesMedidas.php");
require_once("../utils/DataBase.php");

//verifica qual o tipo de metodo e operação a se fazer
if($_SERVER["REQUEST_METHOD"] == "POST") { //Postagem de recursos no server
    $operacao = $_POST["operacao"];
    $ctr = new ControllerUnidadeMedida($operacao, "POST");
}

class ControllerUnidadeMedida{
    private string $operacao;
    private string $methodHttp;
    private ModelUnidadesMedidas $modelUnidade;
    private DaoUnidadesMedidas $daoUnidade;
    private array $responseJson;

    public function __construct(string $operacao, string $methodHttp)
    {
        $this->operacao = $operacao;
        $this->methodHttp = $methodHttp;
        switch($this->operacao) {
            case "cadastrar":
                $this->cadastrar($methodHttp);
                break;
            case "listar": 
                $this->listar($this->methodHttp);
                break;
            case "atualizar": 
                $this->atualizar($methodHttp);
                break;
            case "excluir":
                $this->excluir($this->methodHttp);
                break;
            case "busca":
                //$this->buscarFornecedorDoador($this->methodHttp);
                break;
            default:
                $this->setResponseJson("response", "Operação solicitada para o servidor não esta implementada!");
                echo $this->getResponseJson();                
                break;
        }
    }

    public function cadastrar(string $methodHttp) {
        if($methodHttp === "POST") {
            $this->modelUnidade = new ModelUnidadesMedidas();
            $this->modelUnidade->setSigla($_POST["sigla"]);
            $this->modelUnidade->setDescricao($_POST["descricao"]);
            $this->daoUnidade = new DaoUnidadesMedidas(new DataBase());
            if($this->daoUnidade->insert($this->modelUnidade)) {
                $this->setResponseJson("response", "Unidade Medida Foi Cadastrada Com Sucesso.");
                echo $this->getResponseJson();
            }else{
                $this->setResponseJson("response", "Unidade de medida não foi cadastrada! obtemos um erro interno. por favor tente novamente.");
                echo $this->getResponseJson();
            }
        }else{
            $this->setResponseJson("response", "Unidade de medida não foi cadastrada! obtemos um erro interno. por favor tente novamente.");
            echo $this->getResponseJson();    
        }
    }

    public function listar(string $methodHttp) {
        if($methodHttp === "POST") {
           $this->daoUnidade = new DaoUnidadesMedidas(new DataBase());
           $resultado = $this->daoUnidade->select();
           if(is_array($resultado)) {
              $lista = array();
              foreach($resultado as $chave => $valor) {
                array_push($lista, $valor);
              } 
              $response = array("data" => $lista);
              echo json_encode($response);
           }else{
              $this->setResponseJson("response", "Sem unidades de medidas cadastradas");
              echo $this->getResponseJson();  
           } 
        }else{
            $this->setResponseJson("response", "Opss... tivemos um problema interno em nosso servidor, por favor tente novamente mais tarde!");
            echo $this->getResponseJson();
        }
    }

    public function atualizar(string $methodHttp) {
        if($methodHttp === "POST") {
           $this->modelUnidade = new ModelUnidadesMedidas();
           $this->modelUnidade->setId($_POST["id"]);
           $this->modelUnidade->setSigla($_POST["sigla"]);
           $this->modelUnidade->setDescricao($_POST["descricao"]);
           $this->daoUnidade = new DaoUnidadesMedidas(new DataBase());
           if($this->daoUnidade->update($this->modelUnidade)) {
                $this->setResponseJson("response", "Unidade de medida foi atualizada");
                echo $this->getResponseJson();    
           }else{
                $this->setResponseJson("response", "Opss... Unidade de medida não foi atualizada, por favor tente novamente mais tarde, tivemos um problema interno em nosso servidor.");
                echo $this->getResponseJson();
           } 
        }else{
            $this->setResponseJson("response", "Opss... Unidade de medida não foi atualizada, por favor tente novamente mais tarde, tivemos um problema interno em nosso servidor.");
            echo $this->getResponseJson();
        }
    }

    public function excluir(string $methodHttp) {
        if($methodHttp === "POST") {
            $this->daoUnidade = new DaoUnidadesMedidas(new DataBase());
            if($this->daoUnidade->delete($_POST["id"])) {
                $this->setResponseJson("response", "Unidade de medida foi deletada");
                echo $this->getResponseJson();   
            }else{
                $this->setResponseJson("response", "Opss... Unidade de medida não foi deletada, por favor tente novamente mais tarde, tivemos um problema interno em nosso servidor.");
                echo $this->getResponseJson();
            }
        }else{
            $this->setResponseJson("response", "Opss... Unidade de medida não foi deletada, por favor tente novamente mais tarde, tivemos um problema interno em nosso servidor.");
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
    public function setModel(ModelUnidadesMedidas $model) {
        $this->modelUnidade = $model;
    }
    public function getModel() : ModelUnidadesMedidas{
        return $this->modelUnidade;
    }
    public function setDao(DaoUnidadesMedidas $dao) {
        $this->daoUnidade = $dao;
    }
    public function getDao() : DaoUnidadesMedidas{
        return $this->daoUnidade;
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