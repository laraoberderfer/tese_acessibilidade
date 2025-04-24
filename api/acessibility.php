<?php
header("Content-Type: application/json");
require 'conexao.php';
require '../class/acessibilidade.class.php';

$method = $_SERVER['REQUEST_METHOD'];
//$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        handleGet($pdo);
        break;
   /* case 'POST':
        handlePost($pdo, $input);
        break;*/
    case 'PUT':
        handlePut($pdo, $input);
        break;
    /*case 'DELETE':
        handleDelete($pdo, $input);
        break;*/
    default:
        echo json_encode(['message' => 'Invalid request method']);
        break;
}

function handleGet($pdo): void {
    $sql = "SELECT * FROM acessibilidade";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $usuario_id =  $result['usuario_id'];

    $sql = "SELECT email FROM usuario WHERE usuario_id = :usuario_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue("usuario_id", $usuario_id);
    $stmt->execute();
    $email =  $result['email'];
}
/*
function handlePost($pdo, $input) {
    $sql = "INSERT INTO acessibilidade (nome, email) VALUES (:nome, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nome' => $input['nome'], 'email' => $input['email']]);
    echo json_encode(['message' => 'Usuario criado com sucesso']);
}
*/
function handlePut($pdo, $input) {
    /*$sql = "UPDATE usuario SET name = :name, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $input['name'], 'email' => $input['email'], 'id' => $input['id']]);
    */
    $stmt = $pdo->prepare("UPDATE acessibilidade SET 
                pictograma = :pictograma,
                pictograma_tamanho = :pictograma_tamanho,
                daltonico = :daltonico,
                protanopia = :protanopia,
                deuteranopia = :deuteranopia,
                tritanopia = :tritanopia,
                legenda = :legenda,
                legenda_velocidade = :legenda_velocidade,
                legenda_cor = :legenda_cor,
                legenda_tamanho = :legenda_tamanho,
                legenda_posicao = :legenda_posicao,
                legenda_fundo = :legenda_fundo,
                musica = :musica,
                musica_volume = :musica_volume,
                efeitos_sonoros = :efeitos_sonoros,
                efeitos_sonoros_volume = :efeitos_sonoros_volume,
                interprete = :interprete,
                interprete_expressoes_faciais = :interprete_expressoes_faciais,
                interprete_gestos = :interprete_gestos,
                interprete_audio = :interprete_audio,
                interprete_audio_velocidade = :interprete_audio_velocidade,
                interprete_audio_volume = :interprete_audio_volume
                WHERE acessibilidade_id = :acessibilidade_id");

            foreach ($input as $key => $value) {
                // Lista de campos que são VARCHAR no banco de dados
                $camposVarchar = ['legenda_cor', 'legenda_fundo'];
                // Verificar se o campo é VARCHAR
                if (in_array($key, $camposVarchar)) {
                    $stmt->bindValue(":$key", $value, PDO::PARAM_STR);
                } else {
                    $stmt->bindValue(":$key", $value, is_numeric($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
                }
            }
            //$stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->execute();
    echo json_encode(['message' => 'User updated successfully']);
}
/*
function handleDelete($pdo, $input) {
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $input['id']]);
    echo json_encode(['message' => 'User deleted successfully']);
}
    */
?>
