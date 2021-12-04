<?php 

require_once("../dao/DaoTipoAquisicao.php");
require_once("../utils/DataBase.php");

//verifica qual o tipo de metodo e operação a se fazer
if($_SERVER["REQUEST_METHOD"] == "POST") { //Postagem de recursos no server
    $operacao = $_POST["operacao"];
    $ctr = new ControllerTipoAquisicao($operacao, "POST");
}

class ControllerTipoAquisicao{
    private string $operacao;
    private string $methodHttp;
    private ModelTipoAquisicao $modelTipo;
    private DaoTipoAquisicao $daoTipo;
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
            $tipo = $_POST["tipo"];
            $this->daoTipo = new DaoTipoAquisicao(new DataBase());
            $this->modelTipo = new ModelTipoAquisicao();
            $this->modelTipo->setTipo($tipo);
            if($this->daoTipo->insert($this->modelTipo)) {
                $this->setResponseJson("response", "O tipo de aquisição : $tipo. Foi Cadastrada Com Sucesso.");
                echo $this->getResponseJson();    
            }else{
                $this->setResponseJson("response", "O tipo de aquisição : $tipo. Foi não foi cadastrado. Obtemos um erro interno. Por favor tente novamente.");
                echo $this->getResponseJson(); 
            } 
        }else{
            $this->setResponseJson("response", "Tipo Aquisição não foi cadastrada! obtemos um erro interno. por favor tente novamente.");
            echo $this->getResponseJson();    
        }
    }

    public function listar(string $methodHttp) {
        if($methodHttp === "POST") {
            $this->daoTipo = new DaoTipoAquisicao(new DataBase());
            $resultado = $this->daoTipo->select();
            if(is_array($resultado)) {
                $lista = array();
                foreach($resultado as $chave => $valor) {
                    array_push($lista, $valor);
                } 
                $response = array("data" => $lista);
                echo json_encode($response);    
            }else{
                $this->setResponseJson("response", "Sem tipos de aquisições cadastradas no momento.");
                echo $this->getResponseJson();
            }
        }else{
            $this->setResponseJson("response", "Obtemos um erro interno. Ao tentar listar as formas de aquisições cadastradas, por favor tente novamente.");
            echo $this->getResponseJson();
        }
    }

    public function atualizar(string $methodHttp) {
        if($methodHttp === "POST") {
            $this->modelTipo = new ModelTipoAquisicao();
            $this->modelTipo->setId($_POST["id"]);   
            $this->modelTipo->setTipo($_POST["tipo"]); 
            $this->daoTipo= new DaoTipoAquisicao(new DataBase());
            if($this->daoTipo->update($this->modelTipo)) {
                $this->setResponseJson("response", $_POST["tipo"] . " Foi atualizado com sucesso.");
                echo $this->getResponseJson();
            }else{
                $this->setResponseJson("response", $_POST["tipo"] . " Não foi atualizado.");
                echo $this->getResponseJson();
            }
        }else{
            $this->setResponseJson("response", "Obtemos um erro interno ao tentar fazer a atualização. Por favor tente novamente mais tarde.");
            echo $this->getResponseJson();
        }    
    }

    public function excluir(string $methodHttp) {
        if($methodHttp === "POST") {
            $id = filter_var($_POST["id"], FILTER_VALIDATE_INT);
            $this->daoTipo = new DaoTipoAquisicao(new DataBase());
            if($this->daoTipo->delete($id)) {
                $this->setResponseJson("response", "Tipo aquisição foi excluido com sucesso.");
                echo $this->getResponseJson();
            }else{
                $this->setResponseJson("response", "Obtemos um erro interno ao tentar fazer a exclusão. Por favor tente novamente mais tarde.");
                echo $this->getResponseJson();
            }
        }else{
            $this->setResponseJson("response", "Obtemos um erro interno ao tentar fazer a exclusão. Por favor tente novamente mais tarde.");
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
    public function setModel(ModelTipoAquisicao $model) {
        $this->modelTipo = $model;
    }
    public function getModel() : ModelTipoAquisicao{
        return $this->modelTipo;
    }
    public function setDao(DaoTipoAquisicao $dao) {
        $this->daoTipo = $dao;
    }
    public function getDao() : DaoTipoAquisicao{
        return $this->daoTipo;
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