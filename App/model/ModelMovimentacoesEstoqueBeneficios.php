<?php

class ModelMovimentacoesEstoqueBeneficios{
    
    private int $idEstoque;
    private int $idTipoBeneficio;
    private int $qtdMovimentada;
    private string $dataHoraUltimaMovimentacao;
    private int $tipoMovimentacao;
    private string $descricao;

    public function __construct()
    {
        
    }

    public function setIdEstoque(int $id) {
        $valor = filter_var($id, FILTER_VALIDATE_INT);
        $this->idEstoque = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getIdEstoque() : int {
       return $this->idEstoque; 
    }
    public function setQtdMovimentada(int $qtd) {
        $valor = filter_var($qtd, FILTER_VALIDATE_INT);
        $this->qtdMovimentada = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getQtdMovimentada() : int {
        return $this->qtdMovimentada;
    }
    public function setDataHoraUltimaMovimentacao(string $dataHora) {
        $this->dataHoraUltimaMovimentacao = $dataHora; 
    }
    public function getDataHoraUltimaMovimentacao() : string {
        return $this->dataHoraUltimaMovimentacao;
    }
    public function setTipoMovimentacao(int $tipo) {
       if($tipo === 0 || $tipo === 1) {
          $this->tipoMovimentacao = $tipo;  
       }
    }
    public function getTipoMovimentacao() : int{
       return $this->tipoMovimentacao; 
    }
    public function setIdTipoBeneficio(int $id) {
        $valor = filter_var($id, FILTER_VALIDATE_INT);
        $this->idTipoBeneficio = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getIdTipoBeneficio() : int{
        return $this->idTipoBeneficio;
    }
    public function setDescricao(string $des) {
        $this->descricao = filter_var($des, FILTER_SANITIZE_STRING);
    }
    public function getDescricao() : string{
        return $this->descricao;
    }
}

?>