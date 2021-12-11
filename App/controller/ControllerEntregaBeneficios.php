<?php 

require_once("../model/ModelEntregaBeneficios.php");
require_once("../dao/DaoEntregaBeneficios.php");
require_once("../utils/DataBase.php");
require_once("../dao/DaoBeneficiario.php");

//verifica qual o tipo de metodo e operação a se fazer
if($_SERVER["REQUEST_METHOD"] == "POST") { //Postagem de recursos no server
    $operacao = $_POST["operacao"];
    $ctr = new ControllerEntregaBeneficios($operacao, "POST");
}

class ControllerEntregaBeneficios{
    
    private string $operacao;
    private string $methodHttp;
    private ModelEntregaBeneficios $modelEntrega;
    private DaoEntregaBeneficios $daoEntrega;
    private array $responseJson;

    public function __construct(string $operacao, string $methodHttp)
    {
        $this->operacao = $operacao;
        $this->methodHttp = $methodHttp;
        switch($this->operacao) {
            case "busca-beneficiario":
            $this->controllerListBeneficiarios($this->methodHttp);
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
                $this->setResponseJson("response", "Operação solicitada na CONTROLLER ENTREGA BENEFÍCIOS, não existe.");
                echo $this->getResponseJson();
                break;
        }
    }

    public function controllerListBeneficiarios(string $methodHttp) {
        if($methodHttp === "POST") {
            $termo = $_POST["termo"];
            $nome = filter_var($termo, FILTER_SANITIZE_STRING);
            $daoBeneficiario = new DaoBeneficiario(new DataBase());
            $resultado = $daoBeneficiario->search($nome);
            if(is_array($resultado)) {
                $lista = array();
                foreach($resultado as $chave => $valor) {
                   //OBS: pode-se adicionar o tanto de chaves que quiser no array para la no autocomplete recuperar como uma propriedade de um objeto
                   $item = array("value" => $valor["primeiro_nome_beneficiario"] . $valor["ultimo_nome_beneficiario"], "label" => $valor["primeiro_nome_beneficiario"] . $valor["ultimo_nome_beneficiario"], "desc" => "<b>CPF:</b> " . $valor["cpf_beneficiario"] . " <b>NIS:</b> " . $valor["nis_beneficiario"], "id" => $valor["id_beneficiario"]); 
                   array_push($lista, $item);
                }
                echo json_encode($lista);
            }else{
                $this->setResponseJson("response", "Nenhum beneficiário encontrado.");
                echo $this->getResponseJson();
            }
        }else{
            $this->setResponseJson("response", "Method de solicitação HTTP não e do tipo post. Erro interno no servidor");
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
    public function setModel(ModelEntregaBeneficios $model) {
        $this->modelEntrega = $model;
    }
    public function getModel() : ModelEntregaBeneficios{
        return $this->modelEntrega;
    }
    public function setDao(DaoEntregaBeneficios $dao) {
        $this->daoEntrega = $dao;
    }
    public function getDao() : DaoEntregaBeneficios{
        return $this->daoEntrega;
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