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
        $response = '';
        if($methodHttp === "POST") {
            $beneficios = array();
            $dados = json_decode($_POST["data"]);
            foreach($dados as $chave => $valor) {
                if(is_object($valor)) {
                $beneficio = new ModelBeneficio();
                $beneficio->setNome($valor->nome); //nome
                $beneficio->setDescricao($valor->descricao); //descricao
                $beneficio->setFormaAquisicao($valor->formaAquisicao); //forma aquisição
                $beneficio->setQtdMaxima($valor->qtdMaxima); //qtd maxima
                $beneficio->setQtdMinima($valor->qtdMinima); //qtd minima
                $beneficio->setFkCategoria($valor->categoriaId); //categoria id
                $beneficio->setFkFornecedorDoador($valor->idFornecedorOuDoador); //id fornecedor/Doador
                $movEstoqueBeneficio = new ModelMovimentacoesEstoqueBeneficios();
                $movEstoqueBeneficio->setQtdMovimentada($valor->qtdTotal); //qtd total
                $movEstoqueBeneficio->setTipoMovimentacao(1); //1 == entrada estoque
                $movEstoqueBeneficio->setFkUnidadeMedida($valor->unidadeMedidaId); //id da unidade de medida
                $movEstoqueBeneficio->setQtdPorMedida($valor->qtdMedida); //qtd por medida
                $arrayBeneficio = array($beneficio, $movEstoqueBeneficio);
                array_push($beneficios, $arrayBeneficio); 
                }
            }
            $this->daoBeneficio = new DaoBeneficio(new DataBase());
            foreach($beneficios as $chave => $valor) {
                    $resultadoInsertBeneficio = $this->daoBeneficio->insertBeneficio($valor[0]);
                    if(is_string($resultadoInsertBeneficio)) {
                        $this->daoEstoque = new DaoMovimentacoesEstoqueBeneficios(new DataBase());
                        $valor[1]->setFkBeneficio(intval($resultadoInsertBeneficio));
                        $resultadoInsertEstoque = $this->daoEstoque->insert($valor[1]);
                        if($resultadoInsertEstoque) {
                            /*$descricaoCortada = $valor[0]->getDescricao();
                            $descricaoCortada = substr($descricaoCortada, 0, 10);
                            $response = $response . "Beneficio com nome: {$valor[0]->getNome()} e com descrição: $descricaoCortada... foi cadastrado com sucesso. ";
                            */
                        }else{
                            $descricaoCortada = $valor[0]->getDescricao();
                            $descricaoCortada = substr($descricaoCortada, 0, 10);
                            $response = $response . "Beneficio com nome: {$valor[0]->getNome()} e com descrição: $descricaoCortada... foi cadastrado com sucesso. Porem sua movimentação de estoque não foi efetuada. houve um erro. ";
                        }
                    }else{
                        $descricaoCortada = $valor[0]->getDescricao();
                        $descricaoCortada = substr($descricaoCortada, 0, 10);
                        $response = $response . "Beneficio com nome: {$valor[0]->getNome()} e com descrição: $descricaoCortada... não foi cadastrado houve um erro interno no servidor.";
                    }
            }
            //nenhuma mensagem de erro gerada
            if(empty($response)) {
               $this->setResponseJson("response", "Beneficios foi cadastrados com sucesso.");
               echo $this->getResponseJson(); 
            }else{
                //mensagens de erro geradas
                $this->setResponseJson("response", $response);
                echo $this->getResponseJson();
            }
        }else{
            $this->setResponseJson("response", "Erro interno no servidor, method HTTP não e do tipo post, tente esta ação mais tarde por favor!");
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