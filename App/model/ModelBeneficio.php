<?php

class ModelBeneficio{
    
    private int $idBeneficio;
    private string $descricao;
    private int $idTipoBeneficio;
    private int $idFornecimentoDoacao;
    private int $quantidade;
    private string $dataHora;

    public function __construct()
    {
        
    }

    public function setId(int $id) {
        $valor = filter_var($id, FILTER_VALIDATE_INT);
        $this->idBeneficio = filter_var($valor, FILTER_SANITIZE_NUMBER_INT); 
    }
    public function getId() : int {
        return $this->idBeneficio;
    }
    public function setDescricao(string $description) {
        $this->descricao = filter_var($description, FILTER_SANITIZE_STRING);
    }
    public function getDescricao() : string{
       return $this->descricao;   
    }
    public function setIdTipoBeneficio(int $id) {
        $valor = filter_var($id, FILTER_VALIDATE_INT);
        $this->idTipoBeneficio = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getIdTipoBeneficio() : int {
        return $this->idTipoBeneficio;
    }
    public function setIdFornecedorDoador(int $id) {
        $valor = filter_var($id, FILTER_VALIDATE_INT);
        $this->idFornecimentoDoacao = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getIdFornecedorDoador() : int{
        return $this->idFornecimentoDoacao;
    }
    public function setQuantidade(int $qtd) {
        $valor = filter_var($qtd, FILTER_VALIDATE_INT);
        $this->quantidade = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getQuantidade() : int{
        return $this->quantidade;
    }
    public function setDataHora(string $dh) {
        $this->dataHora = filter_var($dh, FILTER_SANITIZE_STRING);
    }
    public function getDataHora() : string{
        return $this->dataHora;
    }
}

?>