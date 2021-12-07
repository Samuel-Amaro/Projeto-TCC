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
                $this->controllerListar($this->methodHttp);
                break;
            case "alterar": 
                $this->controllerAtualizar($this->methodHttp);
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
            if($this->daoTipoBeneficio->insert($this->modelTipoBeneficio)) {
                $this->setResponseJson("response", "Tipo benefício: {$this->modelTipoBeneficio->getNomeTipo()}. Foi cadastrado com sucesso. ");
                echo $this->getResponseJson(); 
            }else{
                $this->setResponseJson("response", "Tipo benefício:  {$this->modelTipoBeneficio->getNomeTipo()}. Não foi cadastrado houve um erro em nosso servidor, tente novamente mais tarde. ");
                echo $this->getResponseJson();
            }
        }else{
            $this->setResponseJson("response", "Opss... Tipo de beneficio não foi cadastrado, por favor tente novamente mais tarde, tivemos um problema interno em nosso servidor.");
            echo $this->getResponseJson();
        }
    }

    public function controllerListar(string $methodHttp) {
        if($methodHttp === "POST") {
            $this->daoTipoBeneficio = new DaoTipoBeneficio(new DataBase());
            $resultado = $this->daoTipoBeneficio->selectAll();
            if(is_array($resultado)) {
                $lista = array();
                foreach($resultado as $chave => $valor) {
                    array_push($lista, $valor);
                } 
                $response = array("data" => $lista);
                echo json_encode($response);    
            }else{
                $this->setResponseJson("response", "Sem tipos de benefícios cadastrados no momento. Por favor tente este ação novamente mais tarde.");
                echo $this->getResponseJson();
            }
        }else{
            $this->setResponseJson("response", "Opss... Tipo de benefícios não foi listados. Por favor tente novamente mais tarde, tivemos um problema interno em nosso servidor.");
            echo $this->getResponseJson();
        } 
    }

    public function controllerAtualizar(string $methodHttp) {
        if($methodHttp === "POST") {
            $this->modelTipoBeneficio = new ModelTipoBeneficio();
            $this->modelTipoBeneficio->setIdTipoBeneficio($_POST["id_tipo_beneficio"]);
            $this->modelTipoBeneficio->setIdUnidadeMedida($_POST["id_unidade_medida"]);
            $this->modelTipoBeneficio->setIdCategoria($_POST["id_categoria"]);
            $this->modelTipoBeneficio->setNomeTipo($_POST["nome_tipo"]);
            $this->daoTipoBeneficio = new DaoTipoBeneficio(new DataBase());
            if($this->daoTipoBeneficio->update($this->modelTipoBeneficio)) {
                $this->setResponseJson("response", "Benefício: {$this->modelTipoBeneficio->getNomeTipo()}. Foi atualizado com Sucesso");
                echo $this->getResponseJson();
            }else{
                $this->setResponseJson("response", "Benefício: {$this->modelTipoBeneficio->getNomeTipo()}. Não foi atualizado por favor tente este ação novamente mais tarde.");
                echo $this->getResponseJson();
            }
        }else{
            $this->setResponseJson("response", "Opss... Tipo de benefícios não foi atualizado. Por favor tente novamente mais tarde, tivemos um problema interno em nosso servidor.");
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