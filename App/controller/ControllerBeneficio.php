<?php

require_once("../model/ModelBeneficio.php");
require_once("../model/ModelMovimentacoesEstoqueBeneficios.php");
require_once("../dao/DaoBeneficio.php");
require_once("../dao/DaoMovimentacoesEstoqueBeneficios.php");
require_once("../utils/DataBase.php");

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $operacao = $_POST["operacao"];
    $controller = new ControllerBeneficio($operacao, "POST");
}

class ControllerBeneficio{
    
    private string $operacao;
    private string $methodHttp;
    private ModelBeneficio $modelBeneficio;
    private DaoBeneficio $daoBeneficio;
    private ModelMovimentacoesEstoqueBeneficios $modelEstoque;
    private DaoMovimentacoesEstoqueBeneficios $daoEstoque;
    private array $responseJson;

    public function __construct(string $operacao, string $methodHttp)
    {
        $this->operacao = $operacao;
        $this->methodHttp = $methodHttp;
        switch($this->operacao) {
            case "cadastrar":
                $this->controllerCadastrar($methodHttp);
                break;
            case "listar":
                $this->controllerListar($methodHttp);
                break;
            case "listarMovimentacoesBeneficio":
                $this->listarMovimentacoesBeneficio($methodHttp);
                break;
            case "dataChart":
                $this->controllerChartsBarra($methodHttp);
                break;
            default:
                break;
        }    
    }

    public function controllerCadastrar(string $methodHttp) {
        $idsTipoBeneficioCadastrados = array();
        $idsTipoBeneficioNaoCadastrados = array();
        if($methodHttp === "POST") {
            $beneficios = array();
            $dados = json_decode($_POST["data"]);
            foreach($dados as $chave => $valor) {
                if(is_object($valor)) {
                    $this->daoBeneficio = new DaoBeneficio(new DataBase());
                    $beneficio = new ModelBeneficio();
                    $beneficio->setIdTipoBeneficio(intval($valor->idTipeBeneficio));
                    $beneficio->setDescricao($valor->descricao); //descricao
                    $beneficio->setQuantidade(intval($valor->quantidade)); //quantidade
                    $beneficio->setIdFornecedorDoador(intval($valor->idFornecedorDoador)); //id fornecedor/Doador
                    if($this->daoBeneficio->insertBeneficio($beneficio, intval($valor->idFornecedorDoador), intval($valor->idTipoAquisicao))) {
                        //se a transacao de insert der certo armazena id do tipo para mandar mensagem de sucesso
                        array_push($idsTipoBeneficioCadastrados, $beneficio->getIdTipoBeneficio()); 
                    }else{
                        //se a transa????o de insert der erro ou gerar erro armazena id do tipo para mandar mensagem de sucesso 
                        array_push($idsTipoBeneficioNaoCadastrados, $beneficio->getIdTipoBeneficio());
                    } 
                }
            }
            //nenhuma mensagem de erro gerada
            //retorna false se existir e n??o estiver vazia(mas !muda resultado)
            if(!empty($idsTipoBeneficioCadastrados)) {
                $ids = '<b>';
                foreach($idsTipoBeneficioCadastrados as $chave => $valor) {
                    $ids = $ids . " e " . $valor;
                }
                $ids = $ids . "</b>";
                $this->setResponseJson("response", "Benef??cios com o tipo de benef??cios $ids foi cadastrados com sucesso.");
                echo $this->getResponseJson(); 
            }else if(!empty($idsTipoBeneficioNaoCadastrados)){
                $ids = '<b>';
                foreach($idsTipoBeneficioNaoCadastrados as $chave => $valor) {
                    $ids = $ids . " e " . $valor;
                }
                $ids = $ids . "</b>";
                $this->setResponseJson("response", "Benef??cios com o tipo de benef??cios $ids. N??o foi cadastrados houve erros internos em nosso servidor e n??o foi possivel realizar a opera????o, por favor tente novamente mais tarde esta opera????o.");
                echo $this->getResponseJson();
            }else{
                $this->setResponseJson("response", "Opera????o de cadastrar os benef??cios, n??o foi realizada, tivemos um erro interno. Por favor tente esta a????o novamente mais tarde.");
                echo $this->getResponseJson();
            }
        }else{
            $this->setResponseJson("response", "Erro interno no servidor, method HTTP n??o e do tipo post, tente esta a????o mais tarde por favor!");
            echo $this->getResponseJson();
        }
    }

    public function controllerListar(string $methodHttp) {
        if($methodHttp === "POST") {
            $beneficios = array();
            $this->daoBeneficio = new DaoBeneficio(new DataBase());
            $resul = $this->daoBeneficio->selectAll();  
            if(is_array($resul)) {
                $lista = array();
                foreach($resul as $chave => $valor) {
                    array_push($lista, $valor);   
                }
                $response = array("data" => $lista);
                echo json_encode($response);
            }else{
                $this->setResponseJson("response", "Houve um erro ao buscar os beneficios cadastrados. erro interno no servidor.");
                echo $this->getResponseJson();
            }         
        }else{
            $this->setResponseJson("response", "Erro interno no servidor, method HTTP n??o e do tipo post, tente esta a????o mais tarde por favor!");
            echo $this->getResponseJson();  
        }
    }

    public function listarMovimentacoesBeneficio(string $methodHttp) {
        if($methodHttp === "POST") {
            $id = filter_var($_POST["id_beneficio"], FILTER_VALIDATE_INT); // AND filter_var($_POST["id_beneficio"], FILTER_SANITIZE_NUMBER_INT);
            $this->daoBeneficio = new DaoBeneficio(new DataBase());
            $result = $this->daoBeneficio->selectMovimentacoesBeneficio($id);
            if(is_array($result)) {
                $lista = array();
                foreach($result as $chave => $valor) {
                    array_push($lista, $valor);
                } 
                $response = array("dados" => $lista);
                echo json_encode($response); 
            }else{
                $this->setResponseJson("response", "Houve um erro ao buscar as movimenta????es dos beneficio. erro interno no servidor.");
                echo $this->getResponseJson();
            } 
        }else{
            $this->setResponseJson("response", "Erro interno no servidor, method HTTP n??o e do tipo post, tente esta a????o mais tarde por favor!");
            echo $this->getResponseJson(); 
        }
    }

    public function controllerChartsBarra(string $methodHttp) {
        if($methodHttp === "POST") {
            $lista = array();
            $this->daoBeneficio = new DaoBeneficio(new DataBase());
            $resultado = $this->daoBeneficio->selectCountBeneficiosCategoria();
            if(is_array($resultado)) {
                foreach($resultado as $chave => $valor) {
                    array_push($lista, $valor);
                }
                $res = array("dados" => $lista);
                echo json_encode($res);
            }else{
                $res = array("dados" => "resultado n??o e array");
                echo json_encode($res);
            }
        }else{
            $res = array("dados" => "methodo n??o e do tipo post");
            echo json_encode($res);
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
    public function setModel(ModelBeneficio $model) {
        $this->modelBeneficio = $model;
    }
    public function getModel() : ModelBeneficio{
        return $this->modelBeneficio;
    }
    public function setDao(DaoBeneficio $dao) {
        $this->daoBeneficio = $dao;
    }
    public function getDao() : DaoBeneficio{
        return $this->daoBeneficio;
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