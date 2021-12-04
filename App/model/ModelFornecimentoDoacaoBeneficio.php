<?php 

class ModelFornecimentoDoacaoBeneficio{
    
    private int $idFornecimentoDoacaoBeneficio;
    private int $idFornecedorDoador;
    private int $idTipoAquisicao;
    private string $dataHora;

    public function __construct()
    {
        
    }

    public function setIdFornecimentoDoacaoBeneficio(int $id) {
        $valor = filter_var($id, FILTER_VALIDATE_INT);
        $this->idFornecimentoDoacaoBeneficio = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getIdFornecimentoDoacaoBeneficio() : int{
        return $this->idFornecimentoDoacaoBeneficio;
    }
    public function setIdFornecedorDoador(int $id) {
        $valor = filter_var($id, FILTER_VALIDATE_INT);
        $this->idFornecedorDoador = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getIdFornecedorDoador() : int{
        return $this->idFornecedorDoador;
    }
    public function setIdTipoAquisicao(int $id) {
        $valor = filter_var($id, FILTER_VALIDATE_INT);
        $this->idTipoAquisicao = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getIdTipoAquisicao() : int {
        return $this->idTipoAquisicao;
    }
    public function setDataHora(string $dataHora) {
        $this->dataHora = filter_var($dataHora, FILTER_SANITIZE_STRING);
    }
    public function getDataHora() : string{
        return $this->dataHora;
    }
}

?>