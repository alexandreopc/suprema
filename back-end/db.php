<?php
  $host = 'localhost';
  $port = '5432';
  $dbname = 'desafioPHP';
  $user = 'postgres';
  $password = '123456';

  try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
  } catch (PDOException $e) {
    echo "Erro ao se conectar no BD. <br>";
    die($e->getMessage());
  }