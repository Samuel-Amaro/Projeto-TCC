<?php 

require_once("../model/ModelEntregaBeneficios.php");
require_once("../dao/DaoEntregaBeneficios.php");
require_once("../utils/DataBase.php");
require_once("../dao/DaoBeneficiario.php");
require_once("../dao/DaoTipoBeneficio.php");
require_once("../dao/DaoMovimentacoesEstoqueBeneficios.php");
require_once("../model/ModelMovimentacoesEstoqueBeneficios.php");

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
            case "cadastrar": 
                $this->controllerCadastrar($this->methodHttp);
                break;
            case "listar": 
                $this->controllerListarEntregas($this->methodHttp);
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

    public function controllerCadastrar(string $methodHttp) {
        if($methodHttp === "POST") {
            $nomesEntregasRealizadas = array();
            $nomesEntregasNaoRealizadas = array();
            //obtem array com objects entregas
            $entregas = json_decode($_POST["data"]);
            //percorre cada object
            foreach($entregas as $chave => $valor) {
                if(is_object($valor)) {
                    //object, model e dao entrega
                    $this->modelEntrega = new ModelEntregaBeneficios(); 
                    $this->daoEntrega = new DaoEntregaBeneficios(new DataBase());
                    $this->modelEntrega->setIdBeneficiario(intval($valor->idBeneficiario));
                    $this->modelEntrega->setIdTipoBeneficio(intval($valor->idTipoBeneficio));
                    $this->modelEntrega->setQuantidadeEntregue(intval($valor->quantidade));
                    $this->modelEntrega->setIdUsuarioResponsavelEntrega(intval($valor->idUsuarioLogado));
                    //verifica o estoque do beneficio
                    $daoTipoBeneficio = new DaoTipoBeneficio(new DataBase());
                    $resultadoEstoque = $daoTipoBeneficio->selectQuantidade(intval($valor->idTipoBeneficio));
                    if(is_array($resultadoEstoque)) {
                        $valorEstoque = $resultadoEstoque[0];
                        $qtdEstoque = intval($valorEstoque["qtd_atual"]);
                        //quantidade de retirada e permitida no estoque
                        if(intval($valor->quantidade) <= $qtdEstoque) {
                            //registra movimentação do estoque como saida
                            $modelMovimentacao = new ModelMovimentacoesEstoqueBeneficios();
                            $modelMovimentacao->setIdTipoBeneficio(intval($valor->idTipoBeneficio));
                            $modelMovimentacao->setTipoMovimentacao(0); //saida
                            $modelMovimentacao->setQtdMovimentada(intval($valor->quantidade));//quantidade
                            $modelMovimentacao->setDescricao("Entrega de benefício efetuada para:  {$valor->nomeBeneficiario}"); //descricao
                            if($this->daoEntrega->insert($this->modelEntrega, $modelMovimentacao)) {
                                //armazena nomes de pessoas que receberam a entrega
                                array_push($nomesEntregasRealizadas, $valor->nomeBeneficiario);
                            }else{
                                //armazena nomes de pessoas que não receberam
                                array_push($nomesEntregasNaoRealizadas, $valor->nomeBeneficiario);        
                            }    
                        }else{
                            $this->setResponseJson("response", "Não foi possivel registrar as entregas. A quantidade de saida : {$valor->quantidade} para o tipo de beneficio: {$valor->nomeTipoBeneficio} e maior do que ha no estoque que são:  $qtdEstoque. Por favor informe uma quantidade menor para que se possa efetuar a operação.");
                            echo $this->getResponseJson();   
                        }
                    }else{
                        $this->setResponseJson("response", "Não foi possivel registrar as entregas. Tivemos um erro interno ao consultar o estoque dos benefícios. Tente registrar as entregas novamente mais tarde.");
                        echo $this->getResponseJson();
                    }
                }else{
                    $this->setResponseJson("response", "Não foi possivel registrar as entregas. Tivemos um erro interno em nosso servidor, por favor tente esta operação novamente mais tarde.");
                    echo $this->getResponseJson();
                }
            }
            //nenhuma mensagem de erro gerada
            //retorna false se existir e não estiver vazia(mas !muda resultado)
            if(!empty($nomesEntregasRealizadas)) {
                $nomes = '<b>';
                foreach($nomesEntregasRealizadas as $chave => $valor) {
                    $nomes = $nomes . " </br> " . $valor;
                }
                $nomes = $nomes . "</b>";
                $this->setResponseJson("response", "As entregas foram registradas para os seguintes beneficiários: $nomes");
                echo $this->getResponseJson(); 
            }else if(!empty($idsTipoBeneficioNaoCadastrados)){
                $nomes = '<b>';
                foreach($idsTipoBeneficioNaoCadastrados as $chave => $valor) {
                    $nomes = $nomes . " </br>" . $valor;
                }
                $nomes = $nomes . "</b>";
                $this->setResponseJson("response", "As entregas destinadas para os seguintes beneficiários: $nomes não foram registradas devido a problema interno no servidor, por favor tente efetuar essa entrega novamente por favor.");
                echo $this->getResponseJson();
            }else{
                $this->setResponseJson("response", "Operação de registrar entrega, não foi realizada, tivemos um erro interno. Por favor tente esta ação novamente mais tarde.");
                echo $this->getResponseJson();
            }
        }else{
            $this->setResponseJson("response", "Method de solicitação HTTP não e do tipo post. Erro interno no servidor");
            echo $this->getResponseJson();
        }
    }

    public function controllerListarEntregas(string $methodHttp) {
        if($methodHttp === "POST") {
            $entregas = array();
            $this->daoEntrega = new DaoEntregaBeneficios(new DataBase());
            $resultado = $this->daoEntrega->selectAll();
            if(is_array($resultado)) {
                foreach($resultado as $chave => $valor) {
                    array_push($entregas, $valor);
                }
                $response = array("data" => $entregas);
                echo json_encode($response);
            }else{
                $this->setResponseJson("response", "Houve um erro ao buscar as entregas realizadas, por favor tente novamente esta operação. Erro interno no servidor.");
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