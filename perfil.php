<?php
/*
verificar se o email e a senha estao corretos corretos, 
apresentar os dados do usuario  na tela de restrito.php, 
salvar os novos valores atualizados para o banco de dados, 
atualizando os novos valores mostrados na tela
*/
session_start();
require 'conexao.php';
require 'class/usuario.class.php';
require 'functions.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: index.php");
    exit;
}


// Buscar os dados de acessibilidade do banco de dados
$usuario_id = $_SESSION['usuario_id'];

$usuario = Usuario::buscaUsuario($pdo, $usuario_id);
$nome = $usuario->get_nome();
$email = $usuario->get_email();
$senha = $usuario->get_senha();

//echo '<pre>';print_r($_POST);echo '</pre>';

if (isset($_POST['salvar'])) {
    $dadosAtualizados = [
        'nome' => $_POST['nome'],
        'email'=> $_POST['email'],
        'senha' => $_POST['senha']
    ];

    // Salvar os dados no banco de dados
    Usuario::salvarDados($pdo, $usuario_id, $dadosAtualizados);
    
    // Redirecionar para recarregar os dados atualizados
    header("Location: perfil.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Sistema restrito</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Prova de Conceito (PoC) para a Tese">
    <meta name="author" content="Lara Popov Zambiasi">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel='stylesheet' type='text/css' media='screen' href='css/main.css'>  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <script src="js/functions.js"></script>
    
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-light fixed-top" style="background-color: #e3f2fd;">
      <div class="container-fluid">
                <a class="navbar-brand" href="#" ><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16">
                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
                </svg>  Sistema Restrito </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <h4>Bem vindo <?=$_SESSION['nome']; ?></h4>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="restrito.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-universal-access-circle" viewBox="0 0 16 16">
            <path d="M8 4.143A1.071 1.071 0 1 0 8 2a1.071 1.071 0 0 0 0 2.143m-4.668 1.47 3.24.316v2.5l-.323 4.585A.383.383 0 0 0 7 13.14l.826-4.017c.045-.18.301-.18.346 0L9 13.139a.383.383 0 0 0 .752-.125L9.43 8.43v-2.5l3.239-.316a.38.38 0 0 0-.047-.756H3.379a.38.38 0 0 0-.047.756Z"/>
            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0M1 8a7 7 0 1 1 14 0A7 7 0 0 1 1 8"/> 
            </svg> Acessibilidade</a></li>
                        <li class="nav-item"><a class="nav-link" href="perfil.php"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
        </svg> Meu perfil</a> </li>
                        <li class="nav-item"><a class="nav-link" href="logout.php"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
    <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
    <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117M11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5M4 1.934V15h6V1.077z"/>
    </svg> Sair</a> </li>                                     
                    </ul>
                </div>
      </div>
    </nav>
    <div class="container">
    <form action="perfil.php" method="post" class="container-fluid">
        <h1><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
        </svg>  Meu perfil</h1>

        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" aria-describedby="nomeHelp" value="<?=$nome; ?>">
            <small id="nomeHelp" class="form-text text-muted">Digite o seu nome.</small>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="<?=$email; ?>">
            <small id="emailHelp" class="form-text text-muted">Digite seu email, será usado para entrar no sistema.</small>
        </div>

        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" aria-describedby="senhaHelp" value="<?=$senha; ?>">
            
            <small id="senhaHelp" class="form-text text-muted">Escolha uma senha forte de 6 a 8 digitos que conhenham caracteres especiais, como “@”, “!”, “#”, “$”, “%” ou “&” </small>
        </div>
        <hr />
          
        <input type="hidden" name="salvar" value="1">
        <button class="btn btn-lg btn-primary col-lg-12" type="submit" name="salvar">Salvar</button>        
    </form>
    </div>
    <div id="footer">
        <p class="mt-5 mb-3 text-muted">&copy; 2025 Lara Popov Zambiasi</p>
    </div>
</body>
</html>