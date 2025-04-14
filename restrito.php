<?php
/*
verificar se os dados do formulario do index vieram, 
verificar se o email e a senha estao corretos corretos, 
criar uma sessao global com as informacoes importantes, 
apresentar os dados de acessibilidade na tela de restrito.php, 
salvar os novos valores atualizados para o banco de dados, 
atualizando os novos valores mostrados na tela
*/
session_start();
require 'conexao.php';
require 'class/acessibilidade.class.php';
require 'class/usuario.class.php';
require 'functions.php';

// Verificar se os dados do formulário do index vieram
$formulario = verificarFormularioIndex();

if ($formulario) {
    $email = $formulario['email'];
    $senha = $formulario['senha'];
    
    // Verificar se o email e a senha estão corretos
    //$usuario = verificarCredenciais($pdo, $email, $senha);
    $usuario = Usuario::verificarCredenciais($pdo, $email, $senha);
    if ($usuario) {
        // Criar sessão com os dados do usuário
        $_SESSION['logado'] = true;
        $_SESSION['usuario_id'] = $usuario->get_usuario_id();
        $_SESSION['nome'] = $usuario->get_nome();
        $_SESSION['email'] = $usuario->get_email();
        
    } else {
        echo "<script>alert('Usuário ou senha incorretos!');</script>";
        header("Location: index.php");
        exit;
    }
}

// Verificar se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: index.php");
    exit;
}

// Buscar os dados de acessibilidade do banco de dados
$usuario_id = $_SESSION['usuario_id'];
$acessibilidade = Acessibilidade::buscarDadosAcessibilidade($pdo, $usuario_id);

//echo '<pre>';print_r($_POST);echo '</pre>';

if (isset($_POST['salvar'])) {
    $dadosAtualizados = [
        'pictograma' => $_POST['pictograma'],
        'pictograma_tamanho' => $_POST['pictograma_tamanho'],
        'daltonico' => $_POST['daltonico'],
        'protanopia' => $_POST['protanopia'],
        'deuteranopia' => $_POST['deuteranopia'],
        'tritanopia' => $_POST['tritanopia'],
        'legenda' => $_POST['legenda'],
        'legenda_velocidade' => $_POST['legenda_velocidade'],
        'legenda_cor' => $_POST['legenda_cor'],
        'legenda_tamanho' => $_POST['legenda_tamanho'],
        'legenda_posicao' => $_POST['legenda_posicao'],
        'legenda_fundo' => $_POST['legenda_fundo'],
        'musica' => $_POST['musica'],
        'musica_volume' => $_POST['musica_volume'],
        'efeitos_sonoros' => $_POST['efeitos_sonoros'],
        'efeitos_sonoros_volume' => $_POST['efeitos_sonoros_volume'],
        'interprete' => $_POST['interprete'],
        'interprete_expressoes_faciais' => $_POST['interprete_expressoes_faciais'],
        'interprete_gestos' => $_POST['interprete_gestos'],
        'interprete_audio' => $_POST['interprete_audio'],
        'interprete_audio_velocidade' => $_POST['interprete_audio_velocidade'],
        'interprete_audio_volume' => $_POST['interprete_audio_volume']
    ];

    // Salvar os dados no banco de dados
    Acessibilidade::salvarDadosAcessibilidade($pdo, $_SESSION['usuario_id'], $dadosAtualizados);

    // Redirecionar para recarregar os dados atualizados
    header("Location: restrito.php");
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
    <form action="restrito.php" method="post" class="container-fluid">
    <h1><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-universal-access-circle" viewBox="0 0 16 16">
    <path d="M8 4.143A1.071 1.071 0 1 0 8 2a1.071 1.071 0 0 0 0 2.143m-4.668 1.47 3.24.316v2.5l-.323 4.585A.383.383 0 0 0 7 13.14l.826-4.017c.045-.18.301-.18.346 0L9 13.139a.383.383 0 0 0 .752-.125L9.43 8.43v-2.5l3.239-.316a.38.38 0 0 0-.047-.756H3.379a.38.38 0 0 0-.047.756Z"/>
    <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0M1 8a7 7 0 1 1 14 0A7 7 0 0 1 1 8"/> 
    </svg> Configurações de Acessibilidade</h1>
    <button class="btn btn-lg btn-primary col-lg-12" type="submit" name="salvar">Salvar</button>
    <hr />
        <h3>Comunicação</h3>
        <div class="row">
            <div class="col"> Pictogramas         
                 <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Pictogramas" data-bs-content="Pictogramas são imagens que representam ideias, objetos ou ações. Eles ajudam a tornar a comunicação mais clara e acessível, especialmente para pessoas com dificuldades de compreensão verbal.">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg></a>
            </div>
                <div class="col">
                <input type="hidden" name="pictograma" value="0">
                <input class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" name="pictograma" <?=Acessibilidade::isChecked($acessibilidade->get_pictograma()); ?> > ( Ativar / Desativar )
            </div>
        </div>

        <div class="row">
            <div class="col"> Tamanho dos pictogramas
            <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Tamanho do Pictogramas" data-bs-content="Ajuste o tamanho dos pictogramas para facilitar a visualização. Pictogramas maiores podem ser mais fáceis de entender, especialmente para pessoas com dificuldades visuais.">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg></a>
            </div>
            <div class="col">
                <select id="pictograma_tamanho" name="pictograma_tamanho" class="form-select">
                    <option value="1" <?php echo ($acessibilidade->get_pictograma_tamanho() == 1) ? 'selected' : ''; ?> >pequeno</option>
                    <option value="2" <?php echo ($acessibilidade->get_pictograma_tamanho() == 2) ? 'selected' : ''; ?> >médio</option>
                    <option value="3" <?php echo ($acessibilidade->get_pictograma_tamanho() == 3) ? 'selected' : ''; ?> >grande</option>
                </select>
            </div>
        </div>
        <hr />
        <h3>Configuração de Cores para Daltônicos </h3>
        <div class="row">
            <div class="col"> Padrão
            <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Padrão" data-bs-content="Ajuste padrão do sistema.">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg></a>
            </div>
            <div class="col">
            <input type="hidden" name="daltonico" value="0">
            <input class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" name="daltonico" <?=Acessibilidade::isChecked($acessibilidade->get_daltonico() ); ?>>
            ( Ativar / Desativar )
            </div>
        </div>
        <div class="row">
            <div class="col">Protanopia
            <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Protanopia" data-bs-content="Protanopia possui dificuldade de distinguir cores vermelhas. Geralmente percebe tons de marrom, verde ou cinza no lugar do vermelho.">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg></a>
            </div>
            <div class="col">
                 <input type="hidden" name="protanopia" value="0">
                <input class="form-check-input" type="checkbox" value="1" name="protanopia" id="flexCheckChecked" <?=Acessibilidade::isChecked($acessibilidade->get_protanopia()); ?>>
                ( Ativar / Desativar )                
            </div>
        </div>
        <div class="row">
            <div class="col">Deuteranopia
            <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Deuteranopia" data-bs-content="Deuteranopia possui dificuldade de distinguir cores verdes. Geralmente confunde tons de verde e amarelo.">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg></a>
            </div>
            <div class="col">
                <input type="hidden" name="deuteranopia" value="0">
                <input class="form-check-input" type="checkbox" value="1" name="deuteranopia" id="flexCheckChecked" <?= Acessibilidade::isChecked($acessibilidade->get_deuteranopia()); ?>>
                ( Ativar / Desativar )               
            </div>
        </div>
        <div class="row">
            <div class="col">Tritanopia
                <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Tritanopia" data-bs-content="Tritanopia possui dificuldade em distinguir entre verde-azul, amarelo-rosa e roxo-vermelho.">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg></a>
            </div>
            <div class="col">
                <input type="hidden" name="tritanopia" value="0">
                <input class="form-check-input" type="checkbox" value="1" name="tritanopia" id="flexCheckChecked" <?=Acessibilidade::isChecked($acessibilidade->get_tritanopia()); ?>>
                ( Ativar / Desativar )  
               
            </div>
        </div>
        <hr />
        <h3>Legendas</h3>
        <div class="row">
            <div class="col"> Legendas
            <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Legendas" data-bs-content="Legendas são textos que aparecem na tela para descrever as falas do assistente virtual. Elas ajudam a entender o conteúdo.">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg></a>
            </div>
            <div class="col">
                <input type="hidden" name="legenda" value="0">
                <input class="form-check-input" type="checkbox" value="1" name="legenda" id="flexCheckChecked" <?=Acessibilidade::isChecked($acessibilidade->get_legenda()); ?>>
                ( Ativar / Desativar )                  
            </div>
        </div>
        <div class="row">
            <div class="col"> Velocidade das legendas 
            <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title=" Velocidade das Legendas" data-bs-content="O ajuste da velocidade das legendas permite que o usuário escolha a rapidez com que as legendas aparecem na tela. Isso é útil para pessoas que podem ter dificuldades em acompanhar o ritmo normal.">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg></a>
            </div>
            <div class="col">
                <select id="legenda_velocidade" name="legenda_velocidade" class="form-select">
                    <option value="1" <?php echo ($acessibilidade->get_legenda_velocidade() == 1) ? 'selected' : ''; ?> >1.0</option>
                    <option value="2" <?php echo ($acessibilidade->get_legenda_velocidade() == 2) ? 'selected' : ''; ?> >1.5</option>
                    <option value="3" <?php echo ($acessibilidade->get_legenda_velocidade() == 3) ? 'selected' : ''; ?> >2.0</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col"> Cor da letra das legendas
            <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Cor da letra das legendas" data-bs-content="A cor da letra das legendas pode ser ajustada para melhorar a legibilidade e o contraste com o fundo.">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg></a>
            </div>
            <div class="col">
                <input type="color" id="legenda_cor" name="legenda_cor" class="form-control form-control-color" value="<?=$acessibilidade->get_legenda_cor(); ?>" >
            </div>
        </div>
        <div class="row">
            <div class="col"> Cor do fundo das legendas
            <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Cor do fundo das legendas" data-bs-content="A cor do fundo das legendas pode ser ajustada para melhorar a legibilidade e o contraste com o texto.">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg></a>
            </div>
            <div class="col">
                <input type="color" id="legenda_fundo" name="legenda_fundo" class="form-control form-control-color" value="<?=$acessibilidade->get_legenda_fundo(); ?>" >
            </div>
        </div>
        <div class="row">
            <div class="col">Tamanho do texto da legenda
            <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Tamanho do texto da legenda" data-bs-content="O Tamanho do texto da legenda pode ser ajustado para melhorar a legibilidade para pessoas com dificuldades visuais.">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg></a>
            </div>
            <div class="col">
                <select id="legenda_tamanho" name="legenda_tamanho" class="form-select">
                    <option value="1" <?php echo ($acessibilidade->get_legenda_tamanho() == 1) ? 'selected' : ''; ?> >pequeno</option>
                    <option value="2" <?php echo ($acessibilidade->get_legenda_tamanho() == 2) ? 'selected' : ''; ?> >médio</option>
                    <option value="3" <?php echo ($acessibilidade->get_legenda_tamanho() == 3) ? 'selected' : ''; ?> >grande</option>
                </select>
            </div>
        </div>  
        <div class="row">
            <div class="col">Posição do balão de diálogo da legenda
            <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Posição do balão de diálogo da legenda" data-bs-content="A Posição do balão de diálogo da legenda pode ser ajustada para melhorar a legibilidade na interação com o assistente virtual.">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg></a>
            </div>
            <div class="col">
                <select id="legenda_posicao" name="legenda_posicao" class="form-select">
                    <option value="1" <?php echo ($acessibilidade->get_legenda_posicao() == 1) ? 'selected' : ''; ?> >em cima</option>
                    <option value="2" <?php echo ($acessibilidade->get_legenda_posicao() == 2) ? 'selected' : ''; ?> >no meio</option>
                    <option value="3" <?php echo ($acessibilidade->get_legenda_posicao() == 3) ? 'selected' : ''; ?> >em baixo</option>
                </select>
            </div>
        </div>        
        <hr />
        <h3>Música e Efeitos Sonoros</h3>
        <div class="row">
            <div class="col">Música
            <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Música" data-bs-content="A música de fundo pode ser ajustada para criar uma atmosfera mais envolvente. Isso pode ajudar a manter o interesse do usuário e tornar a experiência mais agradável.">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg></a>
            </div>
            <div class="col">
                <input type="hidden" name="musica" value="0">
                <input class="form-check-input" type="checkbox" value="1" name="musica" id="flexCheckChecked" <?=Acessibilidade::isChecked( $acessibilidade->get_musica()); ?>>
                ( Ativar / Desativar )
            </div>
        </div>
        <div class="row">
            <div class="col">Volume da música 
                <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Volume da Música" data-bs-content="O volume da música pode ser ajustado para não interferir na compreensão do assistente virtual. Isso é importante para garantir que o usuário possa ouvir claramente as instruções e informações.">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg></a>
        </div>
            <div class="col">
            <input type="range" class="form-range" id="musica_volume" name="musica_volume" min="0" max="10" value="<?php echo $acessibilidade->get_musica_volume(); ?>">          
            </div>
        </div>

        <div class="row">
            <div class="col">Efeitos sonoros
            <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Efeitos sonoros" data-bs-content="Os efeitos sonoros são sons que acompanham as ações do assistente virtual. Eles ajudam a criar uma experiência mais imersiva e envolvente.">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg></a>
            </div>
            <div class="col">
                <input type="hidden" name="efeitos_sonoros" value="0">
                <input class="form-check-input" type="checkbox" value="1" name="efeitos_sonoros" id="flexCheckChecked" <?=Acessibilidade::isChecked($acessibilidade->get_efeitos_sonoros()); ?>>
                ( Ativar / Desativar )
            </div>
        </div>
        <div class="row">
            <div class="col">Volume dos efeitos sonoros
            <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Volume dos Efeitos sonoros" data-bs-content="O volume dos efeitos sonoros pode ser ajustado para para auxiliar a chamar a atenção do usuário quando necessário.">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg></a>
            </div>
            <div class="col">
            <input type="range" class="form-range" id="efeitos_sonoros_volume" name="efeitos_sonoros_volume" min="0" max="10" value="<?php echo $acessibilidade->get_efeitos_sonoros_volume(); ?>">          
            </div>
        </div>
        <hr />
        <h3>Assistente Virtual (Intérprete)</h3>
        <div class="row">
            <div class="col">Assistente virtual
            <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Assistente virtual" data-bs-content="O assistente virtual pode ser ligado ou desligado conforme necessário.">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg></a>
            </div>
            <div class="col">
                <input type="hidden" name="interprete" value="0">
                <input class="form-check-input" type="checkbox" value="1" name="interprete" id="flexCheckChecked" <?=Acessibilidade::isChecked($acessibilidade->get_interprete()); ?>>
                ( Ativar / Desativar )                
            </div>
        </div>
        <div class="row">
            <div class="col">Expressões faciais
            <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Expressões faciais" data-bs-content="As expressões faciais do assistente virtual podem ser ajustadas para melhorar a comunicação não verbal. Isso pode ajudar a transmitir emoções e intenções de forma mais clara.">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg></a>
            </div>
            <div class="col">
                <input type="hidden" name="interprete_expressoes_faciais" value="0">
                <input class="form-check-input" type="checkbox" value="1" name="interprete_expressoes_faciais" id="flexCheckChecked" <?=Acessibilidade::isChecked($acessibilidade->get_interprete_expressoes_faciais()); ?>>
                ( Ativar / Desativar ) 
                
            </div>
        </div>
        <div class="row">
            <div class="col">Linguagem de sinais
            <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Linguagem de sinais" data-bs-content="A linguagem de sinais pode ser ligada ou desligada para melhorar a comunicação não verbal. Isso é importante para garantir que o usuário possa entender claramente as instruções e informações.">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg></a>
            </div>
            <div class="col">
                <input type="hidden" name="interprete_gestos" value="0">
                <input class="form-check-input" type="checkbox" value="1" name="interprete_gestos" id="flexCheckChecked" <?=Acessibilidade::isChecked($acessibilidade->get_interprete_gestos()); ?>> ( Ativar / Desativar ) 
            </div>
        </div>
        <div class="row">
            <div class="col">Áudio do Assistente virtual
            <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Áudio do Assistente virtual" data-bs-content="O áudio do assistente virtual pode ser ajustado para melhorar a comunicação. Isso é importante para garantir que o usuário possa ouvir claramente as instruções e informações.">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg></a>
            </div>
            <div class="col">
                <input type="hidden" name="interprete_audio" value="0">
                <input class="form-check-input" type="checkbox" value="1" name="interprete_audio" id="flexCheckChecked" <?=Acessibilidade::isChecked($acessibilidade->get_interprete_audio()); ?>> ( Ativar / Desativar ) 
                
            </div>
        </div>
        <div class="row">
            <div class="col">Velocidade do Áudio do Assistente virtual
            <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Velocidade do Áudio do Assistente virtual" data-bs-content="A velocidade áudio do assistente virtual pode ser ajustada para melhorar a comunicação. Isso é importante para garantir que o usuário possa ouvir claramente as instruções e informações.">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg></a>
            </div>
            <div class="col">
                <select id="interprete_audio_velocidade" name="interprete_audio_velocidade" class="form-select">
                    <option value="1" <?php echo ($acessibilidade->get_interprete_audio_velocidade() == 1) ? 'selected' : ''; ?> >1.0</option>
                    <option value="2" <?php echo ($acessibilidade->get_interprete_audio_velocidade() == 2) ? 'selected' : ''; ?> >1.5</option>
                    <option value="3" <?php echo ($acessibilidade->get_interprete_audio_velocidade() == 3) ? 'selected' : ''; ?> >2.0</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col">Volume do Áudio do Assistente virtual
            <a tabindex="0" class="btn btn-outline-second" data-bs-toggle="popover" data-bs-trigger="focus" title="Volume do Áudio do Assistente virtual" data-bs-content="O volume áudio do assistente virtual pode ser ajustado para garantir que o usuário possa ouvir claramente as instruções e informações.">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
            </svg></a>
            </div>
            <div class="col">
            <input type="range" class="form-range" id="interprete_audio_volume" name="interprete_audio_volume" min="0" max="10" value="<?php echo $acessibilidade->get_interprete_audio_volume(); ?>">          
            </div>
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