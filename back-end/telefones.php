<?php
class Telefone {
  public $numero;
  public $descricao;

  public function __construct($numero, $descricao){
    $this->numero = $numero;
    $this->descricao = $descricao;
  }

  public function getTelefone(){
    return "{$this->numero} - {$this->descricao}";
  }

  public function getNumero(){
    return $this->numero;
  }

  public function getDescricao(){
    return $this->descricao;
  }
}