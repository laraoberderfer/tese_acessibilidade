<?php
// URL base do serviço SOAP
$url = 'https://chamilo.arisa.com.br/main/webservices/';

// Obtenher o IP do servidor Chamilo
$myIp = file_get_contents($url . 'testip.php');

// Chave de segurança definida no Chamilo (app/config/configuration.php)
$key = 'e6718badccd049982169c6325d18b6bf';

// Gerar a chave final combinando o IP e a chave de segurança
$finalKey = sha1($myIp . $key);

try {
    // Inicializar o cliente SOAP
    $soap = new SoapClient($url . 'registration.soap.php?wsdl');
} catch (Exception $e) {
    die('Erro ao inicializar o cliente SOAP: ' . $e->getMessage());
}

// Parâmetros para o método WSListCourses
$params = array(
    'secret_key' => $finalKey,
    'from' => 0, // Ponto de partida para a listagem
    'to' => 10,  // Quantidade de cursos a listar
    'original_course_id_name' => 'course_code', // Nome do identificador do curso
    'original_course_id_value' => 'COURSE001'   // Valor do identificador do curso
);

try {
    // método WSListCourses - listar todos os cursos
    $response = $soap->WSListCourses($params);

    // Converter a resposta para JSON sem caracteres escapados
    $jsonResponse = json_encode($response, JSON_UNESCAPED_UNICODE);

    // Substituir aspas duplas por aspas simples
    $jsonResponse = str_replace('"', "'", $jsonResponse);

    header('Content-Type: application/json; charset=utf-8');
    echo $jsonResponse;

} catch (Exception $e) {
    // Exibir o erro caso ocorra    
    $errorResponse = json_encode(['error' => 'Erro ao chamar o serviço SOAP: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
    $errorResponse = str_replace('"', "'", $errorResponse);
    header('Content-Type: application/json');
    echo $errorResponse;
}
?>

