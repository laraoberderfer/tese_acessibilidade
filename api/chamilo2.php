<?php
// URL base do serviço SOAP
$url = 'https://chamilo.arisa.com.br/main/webservices/';

// Obtenha o IP do servidor Chamilo
$myIp = file_get_contents($url . 'testip.php');

// Chave de segurança definida no Chamilo (app/config/configuration.php)
$key = 'e6718badccd049982169c6325d18b6bf';

// Gere a chave final combinando o IP e a chave de segurança
$finalKey = sha1($myIp . $key);

try {
    // Inicialize o cliente SOAP
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
    // Chame o método WSListCourses
    $response = $soap->WSListCourses($params);
    //  resposta do servidor
    //print_r($response);
    header('Content-Type: application/json');
    echo json_encode($response);
} catch (Exception $e) {
    // Exiba o erro caso ocorra
    //echo 'Erro ao chamar o serviço SOAP: ' . $e->getMessage();
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erro ao chamar o serviço SOAP: ' . $e->getMessage()]);
}
?>

