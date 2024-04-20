<?php
require_once('cors.php');
require_once('db.php');
require_once('pessoa.php');
require_once('telefones.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $data = json_decode(file_get_contents('php://input')); 

  if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] == "/pessoa") {
    $array = array();
    $arrayNumeros= array();
    $arrayDescricao = array();
  
    foreach($data->telefones as $values){
      $telefone = new Telefone($values->numero, $values->descricao);
      $array[] = $telefone->getTelefone();
      $arrayNumeros[] = $telefone->getNumero();
      $arrayDescricao[] = $telefone->getDescricao();
    }
    $pessoa = new Pessoa($data->nome, $data->cpf, $data->rg, $data->cep, $data->logradouro, $data->complemento, $data->setor, $data->cidade, $data->uf, $array);
  
    $pdo->query("INSERT INTO pessoa (nome, cpf, rg, cep, logradouro, complemento, setor, cidade, uf) VALUES ('{$pessoa->getNome()}','{$pessoa->getCpf()}','{$pessoa->getRg()}','{$pessoa->getCep()}','{$pessoa->getLogradouro()}','{$pessoa->getComplemento()}','{$pessoa->getSetor()}','{$pessoa->getCidade()}','{$pessoa->getUf()}');");
    $index = $pdo->lastInsertId();
  
    for($i = 0; $i<count($array); $i++){
      $pdo->query("INSERT INTO telefones (\"pessoaId\", numero, descricao) VALUES ('{$index}', '{$arrayNumeros[$i]}', '{$arrayDescricao[$i]}');");
    }
    echo "pessoa inserida com sucesso!";
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  
  if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] == "/lista-todas-pessoas"){
    $data = $pdo->query("SELECT pessoa.*, json_agg(json_build_object('numero', telefones.numero, 'descricao', telefones.descricao)) AS telefones FROM pessoa LEFT JOIN telefones on pessoa.id = telefones.\"pessoaId\" GROUP BY pessoa.id;")->fetchAll(PDO::FETCH_ASSOC);

    $result = json_encode($data);
    echo $result;
  }else if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] == "/lista-todos-telefones"){
    $data = $pdo->query("SELECT * FROM telefones;")->fetchAll(PDO::FETCH_ASSOC);

    $result = json_encode($data);
    echo $result;
  }else if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] == "/pessoa"){
    $data = $pdo->query("SELECT pessoa.*, json_agg(json_build_object('numero', telefones.numero, 'descricao', telefones.descricao)) AS telefones FROM pessoa LEFT JOIN telefones on pessoa.id = telefones.\"pessoaId\" WHERE pessoa.id = {$_GET['pessoa-id']} GROUP BY pessoa.id;")->fetchAll(PDO::FETCH_ASSOC);

    $result = json_encode($data);
    echo $result;
  }else if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] == "/lista-telefones-pessoa"){
    $data = $pdo->query("SELECT * FROM telefones WHERE pessoaId={$_GET['pessoa-id']};")->fetchAll(PDO::FETCH_ASSOC);

    $result = json_encode($data);
    echo $result;
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
  if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] == "/pessoa") {
    $data = json_decode(file_get_contents("php://input")); 

    $array = array();
    $arrayNumeros= array();
    $arrayDescricao = array();
  
    foreach($data->telefones as $values){
      $telefone = new Telefone($values->numero, $values->descricao);
      $array[] = $telefone->getTelefone();
      $arrayNumeros[] = $telefone->getNumero();
      $arrayDescricao[] = $telefone->getDescricao();
    }
    $pessoa = new Pessoa($data->nome, $data->cpf, $data->rg, $data->cep, $data->logradouro, $data->complemento, $data->setor, $data->cidade, $data->uf, $array);
  
    $pdo->query("UPDATE pessoa SET nome='{$pessoa->getNome()}', cpf='{$pessoa->getCpf()}', rg='{$pessoa->getRg()}', cep='{$pessoa->getCep()}', logradouro='{$pessoa->getLogradouro()}', complemento='{$pessoa->getComplemento()}', setor='{$pessoa->getSetor()}', cidade='{$pessoa->getCidade()}', uf='{$pessoa->getUf()}' WHERE id='{$_GET['pessoa-id']}';");
  
    $pdo->query("DELETE FROM telefones WHERE \"pessoaId\" = {$_GET['pessoa-id']};");

    for($i = 0; $i<count($array); $i++){
      $pdo->query("INSERT INTO telefones (\"pessoaId\", numero, descricao) VALUES ('{$_GET['pessoa-id']}', '{$arrayNumeros[$i]}', '{$arrayDescricao[$i]}');");
    }

    echo "dados atualizados!";
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
  if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] == "/pessoa") {
    $pdo->query("DELETE FROM telefones WHERE \"pessoaId\" = {$_GET['pessoa-id']};");
    $pdo->query("DELETE FROM pessoa WHERE id = {$_GET['pessoa-id']};");
  
    echo "pessoa excluída do sistema!";
  }
}

