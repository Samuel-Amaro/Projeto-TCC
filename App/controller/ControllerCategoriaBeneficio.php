<?php 

require_once("../dao/DaoCategoriaBeneficios.php");
require_once("../utils/DataBase.php");

//verifica qual o tipo de metodo e operação a se fazer
if($_SERVER["REQUEST_METHOD"] == "POST") { //Postagem de recursos no server
    $operacao = $_POST["operacao"];
    $ctr = new ControllerCategoriaBeneficios($operacao, "POST");
}

class ControllerCategoriaBeneficios{
    private string $operacao;
    private string $methodHttp;
    private ModelCategoriaBeneficios $modelCategoria;
    private DaoCategoriaBeneficios $daoCategoria;
    private array $responseJson;

    public function __construct(string $operacao, string $methodHttp)
    {
        $this->operacao = $operacao;
        $this->methodHttp = $methodHttp;
        switch($this->operacao) {
            case "cadastro":
                $this->cadastrarCategoria($this->methodHttp);
                break;
            case "listar": 
                //$this->listarFornecedoresDoadores($this->methodHttp);
                break;
            case "alterar": 
                //$this->alterarFornecedorDoador($this->methodHttp);
                break;
            case "deletar":
                //$this->excluirFornecedorDoador($this->methodHttp);
                break;
            case "busca":
                //$this->buscarFornecedorDoador($this->methodHttp);
                break;
            default:
                break;
        }
    }

    public function cadastrarCategoria(string $methodHttp) {
        if($methodHttp === "POST") {
            $this->modelCategoria = new ModelCategoriaBeneficios();
            $this->modelCategoria->setNome($_POST["nome"]);
            $this->modelCategoria->setDescricao($_POST["descricao"]);
            $this->daoCategoria = new DaoCategoriaBeneficios(new DataBase());
            if($this->daoCategoria->insert($this->modelCategoria)) {
                $this->setResponseJson("response", "Categoria foi cadastrada com sucesso!");
                echo $this->getResponseJson();
            }else{
                $this->setResponseJson("response", "Categoria não foi cadastrada! obtemos um erro interno. por favor tente novamente.");
                echo $this->getResponseJson();
            }
        }else{
            $this->setResponseJson("response", "Obtemos um erro interno. por favor tente novamente.");
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
    public function setModel(ModelCategoriaBeneficios $model) {
        $this->modelCategoria = $model;
    }
    public function getModel() : ModelCategoriaBeneficios{
        return $this->modelCategoria;
    }
    public function setDao(DaoCategoriaBeneficios $dao) {
        $this->daoCategoria = $dao;
    }
    public function getDao() : DaoCategoriaBeneficios{
        return $this->daoCategoria;
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