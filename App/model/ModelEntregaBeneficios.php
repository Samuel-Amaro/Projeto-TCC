<?php 

class ModelEntregaBeneficios{

    private int $idEntregaBeneficio;
    private string $dataEntrega;
    private int $idBeneficiario;
    private int $idTipoBeneficio;
    private int $quantidadeEntregue;
    private int $idUsuarioResponsavelEntrega;

    public function __construct()
    {
        
    }

    public function setIdEntregaBeneficio(int $id) {
        $valor = filter_var($id, FILTER_VALIDATE_INT);
        $this->idEntregaBeneficio = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getIdEntregaBeneficio() : int {
        return $this->idEntregaBeneficio;
    }
    public function setDataEntrega(string $data) {
        $this->dataEntrega = filter_var($data, FILTER_SANITIZE_STRING);
    }
    public function getDataEntrega() : string{
        return $this->dataEntrega;
    }
    public function setIdBeneficiario(int $id) {
        $valor = filter_var($id, FILTER_VALIDATE_INT);
        $this->idBeneficiario = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getIdBeneficiario() : int {
        return $this->idBeneficiario;
    }
    public function setIdTipoBeneficio(int $id) {
        $valor = filter_var($id, FILTER_VALIDATE_INT);
        $this->idTipoBeneficio = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getIdTipoBeneficio() : int {
       return $this->idTipoBeneficio; 
    }
    public function setQuantidadeEntregue(int $qtd) {
        $valor = filter_var($qtd, FILTER_VALIDATE_INT);
        $this->quantidadeEntregue = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getQuantidadeEntregue() : int{
        return $this->quantidadeEntregue;
    }
    public function setIdUsuarioResponsavelEntrega(int $id) {
        $valor = filter_var($id, FILTER_VALIDATE_INT);
        $this->idUsuarioResponsavelEntrega = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }
    public function getIdUsuarioResponsavelEntrega() : int{
        return $this->idUsuarioResponsavelEntrega;
    }
}

?>