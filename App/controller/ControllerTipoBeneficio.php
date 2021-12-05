<?php 

require_once("../dao/DaoTipoBeneficio.php");
require_once("../model/ModelTipoBeneficio.php");

//verifica qual o tipo de metodo e operação a se fazer
if($_SERVER["REQUEST_METHOD"] == "POST") { //Postagem de recursos no server
    $operacao = $_POST["operacao"];
    $ctr = new ControllerTipoBeneficio($operacao, "POST");
}

class ControllerTipoBeneficio{
    
    private string $operacao;
    private string $methodHttp;
    private ModelTipoBeneficio $modelTipoBeneficio;
    private DaoTipoBeneficio $daoTipoBeneficio;
    private array $responseJson;

    public function __construct(string $operacao, string $methodHttp)
    {
        $this->operacao = $operacao;
        $this->methodHttp = $methodHttp;
        switch($this->operacao) {
            case "cadastrar":
                $this->controllerCadastrar($this->methodHttp);
                break;
            case "listar": 
                //$this->listarFornecedoresDoadores($this->methodHttp);
                break;
            case "alterar": 
               // $this->alterarFornecedorDoador($this->methodHttp);
                break;
            case "deletar":
                //$this->excluirFornecedorDoador($this->methodHttp);
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

    public function controllerCadastrar(string $methodHttp) {
        if($methodHttp === "POST") {
            $this->modelTipoBeneficio = new ModelTipoBeneficio();
            $this->modelTipoBeneficio->setNomeTipo($_POST["nome_tipo"]); 
            $this->modelTipoBeneficio->setIdCategoria($_POST["id_categoria"]);
            $this->modelTipoBeneficio->setIdUnidadeMedida($_POST["id_unidade_medida"]);
            $this->daoTipoBeneficio = new DaoTipoBeneficio(new DataBase());
            $resultado = $this->daoTipoBeneficio->insert($this->modelTipoBeneficio);
            var_dump($resultado);
            //echo $resultado;
            //is_string($resultado) &&
            if($resultado === "ja_existe") {
                $this->setResponseJson("response", "Tipo benefício:{$this->modelTipoBeneficio->getNomeTipo()}. Ja existe e ja foi cadastrado. " . $resultado);
                echo $this->getResponseJson();
                //is_bool($resultado) &&
            }else if($resultado === true) {
                $this->setResponseJson("response", "Tipo benefício:{$this->modelTipoBeneficio->getNomeTipo()}. Foi cadastrado com sucesso. " . $resultado);
                echo $this->getResponseJson();   
            }else{
                $this->setResponseJson("response", "Tipo benefício: {$this->modelTipoBeneficio->getNomeTipo()}. Não foi cadastrado houve um erro em nosso servidor, tente novamente mais tarde. " . $resultado);
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
    public function setModel(ModelTipoBeneficio $model) {
        $this->modelTipoBeneficio = $model;
    }
    public function getModel() : ModelTipoBeneficio{
        return $this->modelTipoBeneficio;
    }
    public function setDao(DaoTipoBeneficio $dao) {
        $this->daoTipoBeneficio = $dao;
    }
    public function getDao() : DaoTipoBeneficio{
        return $this->daoTipoBeneficio;
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