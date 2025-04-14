<?php
require_once "conexao.php";

//Classe Usuario
//Responsável por manipular os dados do usuário no banco de dados

class Usuario{
    //Atributos
    public $usuario_id;
    public $nome;
    public $email;
    public $senha;
    //Construtor
    function __construct($usuario_id, $nome, $email, $senha){
      $this->usuario_id = $usuario_id;
      $this->nome = $nome;
      $this->email = $email;
      $this->senha = $senha;
    }
    
    function get_usuario_id(){
      return $this->usuario_id;
    }
    function get_nome(){
      return $this->nome;
    }
    function get_email(){
      return $this->email;
    }
    function get_senha(){
      return $this->senha;
    }
    
    // Método para verificar credenciais
    public static function verificarCredenciais($pdo, $email, $senha) {
      try {
          $stmt = $pdo->prepare("SELECT * FROM usuario WHERE email = :email");
          $stmt->bindValue(':email', $email, PDO::PARAM_STR);
          $stmt->execute();
          $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

          // Verificar se o email e a senha correspondem
          if ($usuario && ($email == $usuario['email']) && ($senha == $usuario['senha'])) {
              // Retornar uma instância da classe Usuario
              return new Usuario(
                  $usuario['usuario_id'], 
                  $usuario['nome'], 
                  $usuario['email'], 
                  $usuario['senha']
              );
          }
      } catch (PDOException $e) {
          die("Erro ao verificar credenciais: " . $e->getMessage());
      }
      return null;
   }

   //Método para buscar usuário por ID
   public static function buscaUsuario($pdo, $usuario_id) {
      try {
          $stmt = $pdo->prepare("SELECT * FROM usuario WHERE usuario_id = :usuario_id");
          $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
          $stmt->execute();
          $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

          // Retornar uma instância da classe Usuario
          return new Usuario(
              $usuario['usuario_id'], 
              $usuario['nome'], 
              $usuario['email'], 
              $usuario['senha']
          );
      } catch (PDOException $e) {
          die("Erro ao buscar usuário: " . $e->getMessage());
      }
   }

   //Método para salvar dados do usuário	
   public static function salvarDados($pdo, $usuario_id, $dadosAtualizados) {
      try {
          $stmt = $pdo->prepare("UPDATE usuario SET nome = :nome, email = :email, senha = :senha WHERE usuario_id = :usuario_id");
          $stmt->bindValue(':nome', $dadosAtualizados['nome'], PDO::PARAM_STR);
          $stmt->bindValue(':email', $dadosAtualizados['email'], PDO::PARAM_STR);
          $stmt->bindValue(':senha', $dadosAtualizados['senha'], PDO::PARAM_STR);
          $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
          $stmt->execute();
      } catch (PDOException $e) {
          die("Erro ao salvar dados: " . $e->getMessage());
      }
   }   
    
}


?>