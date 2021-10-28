<?php

require_once("../dao/DaoFornecedoresDoadores.php");
require_once("../utils/DataBase.php");

//verifica qual o tipo de metodo e operação a se fazer
if($_SERVER["REQUEST_METHOD"] == "POST") { //Postagem de recursos no server
    $operacao = $_POST["operacao"];
    $ctr = new ControllerFornecedoresDoadores($operacao, "POST");
}

class ControllerFornecedoresDoadores{

    private string $operacao;
    private string $methodHttp;
    private ModelFornecedorDoador $modelFornDoador;
    private DaoFornecedoresDoadores $daoForneDoador;
    private array $responseJson;

    public function __construct(string $operacao, string $methodHttp)
    {
        $this->operacao = $operacao;
        $this->methodHttp = $methodHttp;
        switch($this->operacao) {
            case "cadastrar":
                $this->cadastrarFornecedorDodador($this->methodHttp);
                break;
            case "listar": 
                $this->listarFornecedoresDoadores($this->methodHttp);
                break;
            case "alteracao": 
                //$this->atualizarBeneficiario($this->methodHttp);
                break;
            case "deletar":
               // $this->excluirBeneficiario($this->methodHttp);
                break;
            default:
                break;
        }
    }

    /**
     * * Esta função e responsavel por cadastrar um fornecedor ou doador no sistema, chamando a camada model responsavel junto com a dao
     */
    public function cadastrarFornecedorDodador(string $methodHttp) {
        if($methodHttp === "POST") {
            $this->modelFornDoador = new ModelFornecedorDoador();
            $this->modelFornDoador->setNome($_POST["nome"]); //nome
            $this->modelFornDoador->setDescricao(empty($_POST["descricao"]) ? null : $_POST["descricao"]); //descrição
            $this->modelFornDoador->setTipoPessoa($_POST["tipoPessoa"]); //Tipo Pessoa
            $this->modelFornDoador->setIdentificacao($_POST["identificacao"]); //Identificação
            $this->modelFornDoador->setCpf(empty($_POST["cpf"]) ? null : $_POST["cpf"]); //cpf
            $this->modelFornDoador->setCnpj(empty($_POST["cnpj"]) ? null : $_POST["cnpj"]); //cnpj
            $this->modelFornDoador->setCep(empty($_POST["cep"]) ? null : $_POST["cep"]); //cep
            $this->modelFornDoador->setEndereco($_POST["endereco"]); //endereço
            $this->modelFornDoador->setComplemento(empty($_POST["complemento"]) ? null : $_POST["complemento"]); //complemento
            $this->modelFornDoador->setBairro($_POST["bairro"]); //bairro
            $this->modelFornDoador->setCidade($_POST["cidade"]); //cidade
            $this->modelFornDoador->setUf($_POST["estado"]); //estado
            $this->modelFornDoador->setTelefoneCelular($_POST["telefoneCelular"]); //telefone celular
            $this->modelFornDoador->setTelefoneFixo($_POST["telefoneFixo"]); //telefone fixo
            $this->modelFornDoador->setEmail(empty($_POST["email"]) ? null : $_POST["email"]); //email
            $this->daoForneDoador = new DaoFornecedoresDoadores(new DataBase());
            if($this->daoForneDoador->insertFornecedorDoador($this->modelFornDoador)) {
                if($this->modelFornDoador->getIdentificacao() === "DOADOR") {
                    $this->setResponseJson("response", "Ótimo você acaba de cadastrar um doador.");
                    echo $this->getResponseJson();
                }else{
                    $this->setResponseJson("response", "Ótimo você acaba de cadastrar um fornecedor.");
                    echo $this->getResponseJson();
                }
            }else{
                $this->setResponseJson("response", "Ops.. temos um problema interno em nosso servidor, tenta ação novamente.");
                echo $this->getResponseJson();
            }
        }else{
            $this->setResponseJson("response", "Ops.. request method HTTP não e do tipo POST");
            echo $this->getResponseJson();
        }
    }

    /**
     * * Esta função busca todos fornecedores e doadores cadastrados
     */
    public function listarFornecedoresDoadores(string $methodHttp) {
        if($methodHttp === "POST") {
           $this->daoForneDoador = new DaoFornecedoresDoadores(new DataBase()); 
           $listaResultadoFornecedoresDoadores = $this->daoForneDoador->selectFornecedoresDoadores();
           if(is_array($listaResultadoFornecedoresDoadores)) {
              //verificar a forma como arrumar esses dados e formatados em json para o front end
              $lista = array();
              foreach($listaResultadoFornecedoresDoadores as $chave => $valor) {
                 array_push($lista, $valor);
              } 
              $response = array("data" => $lista);
              echo json_encode($response);
           }else{
              $this->setResponseJson("response", "Sem Fornecedores e Doadores Cadastrados");
              echo $this->getResponseJson();
           }
        }else{
            $this->setResponseJson("response", "Ops.. request method HTTP não e do tipo POST");
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
    public function setModel(ModelFornecedorDoador $model) {
        $this->modelBenef = $model;
    }
    public function getModel() : ModelFornecedorDoador{
        return $this->modelBenef;
    }
    public function setDao(DaoFornecedoresDoadores $dao) {
        $this->daoBenef = $dao;
    }
    public function getDao() : DaoFornecedoresDoadores{
        return $this->daoBenef;
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