<?php
require_once("telefones.php");

class Pessoa {
  public $nome;
  public $cpf;
  public $rg;
  public $cep;
  public $logradouro;
  public $complemento;
  public $setor;
  public $cidade;
  public $uf;
  public $telefones = array();

  public function __construct($nome, $cpf, $rg, $cep, $logradouro, $complemento, $setor, $cidade, $uf, $telefones){
    $this->nome = $nome;
    $this->cpf = $cpf;
    $this->rg = $rg;
    $this->cep = $cep;
    $this->logradouro = $logradouro;
    $this->complemento = $complemento;
    $this->setor = $setor;
    $this->cidade = $cidade;
    $this->uf = $uf;
    $this->telefones = $telefones;
  }

  public function getNome(){
    return $this->nome;
  }

  public function getCpf(){
    return $this->cpf;
  }

  public function getRg(){
    return $this->rg;
  }

  public function getCep(){
    return $this->cep;
  }

  public function getLogradouro(){
    return $this->logradouro;
  }

  public function getComplemento(){
    return $this->complemento;
  }

  public function getSetor(){
    return $this->setor;
  }

  public function getCidade(){
    return $this->cidade;
  }

  public function getUf(){
    return $this->uf;
  }
}
