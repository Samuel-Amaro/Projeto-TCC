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
                $this->cadastrarBeneficio($methodHttp);
                break;
            default:
                break;
        }    
    }

    public function cadastrarBeneficio(string $methodHttp) {
        $dados = json_decode($_POST["data"]);
        foreach($dados as $chave => $valor) {
            if(is_object($valor)) {
               echo $valor->nome; 
            }else{
               echo "Não e object"; 
            }
        }
        var_dump($dados);
        /*if($methodHttp === "POST") {
          $this->modelBeneficio = new ModelBeneficio();
          $this->modelBeneficio->setDescricao($_POST["descricao"]);
          $this->modelBeneficio->setNome($_POST["nome"]);
          $this->modelBeneficio->setFkCategoria($_POST["categoriaId"]);
          $this->modelBeneficio->setFkFornecedorDoador($_POST["idFornecedorOuDoador"]);
          $this->modelBeneficio->setFormaAquisicao($_POST["formaAquisicao"]);
          $this->modelBeneficio->setQtdMaxima($_POST["qtdMaxima"]);
          $this->modelBeneficio->setQtdMinima($_POST["qtdMinima"]);
          $this->daoBeneficio = new DaoBeneficio(new DataBase());
          $resultadoInsertBeneficio = $this->daoBeneficio->insertBeneficio($this->modelBeneficio);
          if(is_string($resultadoInsertBeneficio)) {
            $this->modelEstoque = new ModelMovimentacoesEstoqueBeneficios();
            $this->modelEstoque->setFkBeneficio(intval($resultadoInsertBeneficio));
            $this->modelEstoque->setQtdMovimentada($_POST["qtdTotal"]);
            $this->modelEstoque->setFkUnidadeMedida($_POST["unidadeMedidaId"]);
            $this->modelEstoque->setQtdPorMedida($_POST["qtdMedida"]);
            $this->modelEstoque->setTipoMovimentacao(1); //ENTRADA ESTOQUE
            $this->daoEstoque = new DaoMovimentacoesEstoqueBeneficios(new DataBase());
            if($this->daoEstoque->insert($this->modelEstoque)) {
                $this->setResponseJson("response", "Beneficio cadastrado com sucesso. Movimentação do estoque como uma entrada para o beneficio foi registrada.");
                echo $this->getResponseJson(); 
            }else{
                $this->setResponseJson("response", "FALHA ao inserir a movimentação de estoque, do beneficio, movimentação não foi registrada, tivemos um problema interno em nosso servidor, por favor, tente novamente esta tarefa mais tarde.");
                echo $this->getResponseJson(); 
            }
          }else{
            $this->setResponseJson("response", "FALHA ao inserir o beneficio, beneficio não foi cadastrado, tivemos um problema interno em nosso servidor, por favor, tente novamente esta tarefa mais tarde.");
            echo $this->getResponseJson();
          }
        }else{
            $this->setResponseJson("response", "Erro interno no servidor, method HTTP não e do tipo POST");
            echo $this->getResponseJson();
        }*/ 
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