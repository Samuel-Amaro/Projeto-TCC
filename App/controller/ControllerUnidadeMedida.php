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
                //$this->listarCategorias($this->methodHttp);
                break;
            case "atualizar": 
                //$this->atualizarCategoria($this->methodHttp);
                break;
            case "excluir":
                //$this->excluirCategoria($this->methodHttp);
                break;
            case "busca":
                //$this->buscarFornecedorDoador($this->methodHttp);
                break;
            default:
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