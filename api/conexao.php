<?php
//iniciar a sessão


try {
  $host = 'localhost';
  $dbname = 'lara';
  $username = 'lara';
  $password = '1234';
  /*$host = 'localhost';
  $dbname = 'lara';
  $username = 'root';
  $password = '';*/

  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Conexão bem-sucedida!";
} catch (PDOException $e) {
  die("Erro na conexão: " . $e->getMessage());
}
?>