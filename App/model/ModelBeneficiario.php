<?php

//namespace ModelBeneficiario;

class ModelBeneficiario {
    
    private int $id;
    private string $cpf;
    private string $primeiroNome;
    private string $ultimoNome;
    private string $nis;
    private string $celularRequired;
    private ?string $celularOpcional;
    private string $endereco;
    private string $bairro;
    private string $cidade;
    private string $uf;
    private int $qtdPessoasResidencia;
    private float $rendaPerCapita;
    private ?string $observacao;
    private ?string $email;
    private ?string $cep;
    private ?string $complemento_ende;
    private string $abrangenciaCras;

    public function __construct()
    {
        
    }

    public function setId(?int $idP) {
        $this->id = $idP;
    }
    public function getId() : int {
        return $this->id;
    }
    public function setCpf(string $cpfP) {
        $this->cpf = $cpfP;
    }
    public function getCpf() : string{
        return $this->cpf;
    }
    public function setPrimeiroNome(string $primeiroNomeP) {
        $this->primeiroNome = $primeiroNomeP;
    }
    public function getPrimeiroNome() : string{
        return $this->primeiroNome;
    }
    public function setUltimoNome(string $ultimoNomeP) {
        $this->ultimoNome = $ultimoNomeP;
    }
    public function getUltimoNome() : string {
        return $this->ultimoNome;
    }
    public function setNis(string $nisP) {
        $this->nis = $nisP;
    }
    public function getNis() : string {
        return $this->nis;
    }
    public function setCelularRequired(string $celularRequiredP) {
        $this->celularRequired = $celularRequiredP;
    }
    public function getCelularRequired() : string {
        return $this->celularRequired;
    }
    public function setCelularOpcional(string $celularOpcionalP) {
        if(empty($celularOpcionalP)) {
            $this->celularOpcional = null;
        }else{
            $this->celularOpcional = $celularOpcionalP;
        }
    }
    public function getCelularOpcional() : ?string{
        return $this->celularOpcional; 
    }
    public function setEndereco(string $enderecoP) {
        $this->endereco = $enderecoP;
    }
    public function getEndereco() : string {
        return $this->endereco;
    }
    public function setBairro(string $bairroP) {
        $this->bairro = $bairroP;
    }
    public function getBairro() : string {
        return $this->bairro;
    }
    public function setCidade(string $cidadeP) {
        $this->cidade = $cidadeP;
    }
    public function getCidade() : string {
        return $this->cidade;
    }
    public function setUf(string $ufP) {
        $this->uf = $ufP;
    }
    public function getUf() : string {
       return $this->uf;  
    }
    public function setQtdPessoasResidencia(int $qtdPessoasResidenciaP) {
        $this->qtdPessoasResidencia = $qtdPessoasResidenciaP;
    }
    public function getQtdPessoasResidencia() : int{
        return $this->qtdPessoasResidencia;
    }
    public function setRendaPerCapita(float $rendaPerCapitaP) {
        $this->rendaPerCapita = $rendaPerCapitaP;
    }
    public function getRendaPerCapita() : float{
        return $this->rendaPerCapita;
    }
    public function setObservacao(string $observaoP) {
        if(empty($observaoP)){
            $this->observacao = null;
        }else{
            $this->observacao = $observaoP;
        }   
    }
    public function getObservacao() : ?string{
        return $this->observacao;
    }
    public function setEmail(string $emailP) {
        if(!filter_var($emailP, FILTER_VALIDATE_EMAIL) === false) {
            $this->email = $emailP; 
        }else{
            $this->email = null;
        }
    }
    public function getEmail() : ?string{
        return $this->email;    
    }
    public function setCep(string $cepP) {
       if(empty($cepP)) {
          $this->cep = null;
       }else{
            $this->cep = $cepP;
        }
    }
    public function getCep() : ?string{
        return $this->cep;
    }
    public function setComplementoEnde(string $complementoP) {
        if(empty($complementoP)) {
            $this->complemento_ende = null;
        }else{
            $this->complemento_ende = $complementoP;
        }
    }
    public function getComplementoEnde() : ?string{
        return $this->complemento_ende;
    }
    public function setAbrangenciaCras(string $abrangeP) {
        $this->abrangenciaCras = $abrangeP;
    }
    public function getAbrangenciaCras() : string{
        return $this->abrangenciaCras;
    }
}

?>