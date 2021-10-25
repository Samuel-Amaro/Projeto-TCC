<?php

class ModelFornecedorDoador{

    private int $id;
    private string $nome;
    private ?string $descricao;
    private string $identificacao;
    private string $tipoPessoa;
    private ?string $cep;
    private string $endereco;
    private ?string $complemento;
    private string $bairro;
    private string $cidade;
    private string $uf;
    private string $telefoneCelular;
    private string $telefoneFixo;
    private string $dataHora;
    private ?string $cpf;
    private ?string $cnpj;
    private string $email; 

    public function __construct(){

    }

    public function setId(int $id) {
        $this->id = $id;
    }
    public function getId() : int {
        return $this->id;
    }
    public function setNome(string $nome) {
        $this->nome = $nome;
    }
    public function getNome() : string{
        return $this->nome;
    }
    public function setDescricao(?string $descricao) {
        $this->descricao = $descricao;
    }
    public function getDescricao() : ?string{
        return $this->descricao;
    }
    public function setIdentificacao(string $identificacao) {
        $this->identificacao = $identificacao;
    }
    public function getIdentificacao() : string{
        return $this->identificacao;
    }
    public function setTipoPessoa(string $tipo) {
        $this->tipoPessoa = $tipo;
    }
    public function getTipoPessoa() : string{
        return $this->tipoPessoa;
    }
    public function setCep(?string $cep) {
        $this->cep = $cep;
    }
    public function getCep() : ?string{
        return $this->cep;
    }
    public function setEndereco(string $endereco) {
        $this->endereco = $endereco;
    }
    public function getEndereco() : string{
        return $this->endereco;
    }
    public function setComplemento(?string $complemento) {
        $this->complemento = $complemento;
    }
    public function getComplemento() : ?string {
        return $this->complemento;
    }
    public function setBairro(string $bairro) {
        $this->bairro = $bairro;
    }
    public function getBairro() : string{
        return $this->bairro;
    }
    public function setCidade(string $cidade) {
        $this->cidade = $cidade;
    }
    public function getCidade() : string{
        return $this->cidade;
    }
    public function setUf(string $uf) {
        $this->uf = $uf;
    }
    public function getUf() : string{
        return $this->uf;
    }
    public function setTelefoneCelular(string $telefoneCel) {
        $this->telefoneCelular = $telefoneCel;
    }
    public function getTelefoneCelular() : string{
        return $this->telefoneCelular;
    }
    public function setTelefoneFixo(string $telefoneFix) {
        $this->telefoneFixo = $telefoneFix;
    }
    public function getTelefoneFixo() : string {
        return $this->telefoneFix;
    }
    public function setDataHora(string $dataH) {
        $this->dataHora = $dataH;
    }
    public function getDataHora() : string{
        return $this->dataHora;
    }
    public function setCpf(?string $cpf) {
        $this->cpf = $cpf;
    }
    public function getCpf() : ?string {
        return $this->cpf;
    }
    public function setCnpj(?string $cnpj) {
        $this->cnpj = $cnpj;
    }
    public function getCnpj() : ?string{
        return $this->cnpj;
    }
    public function setEmail(string $email) {
        $this->email = $email;
    }
    public function getEmail() : string{
        return $this->email;
    }

}

?>