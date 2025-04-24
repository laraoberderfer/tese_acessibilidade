<?php
    //https://github.com/chamilo/prestashopchamilo/blob/master/prestashopchamilo.php
    $url = 'https://chamilo.arisa.com.br/main/webservices/'; 
    $soap = new SoapClient($url . 'registration.soap.php?wsdl');

    // get your own IP as seen by the Chamilo server (helps building the key)
    $myIp = file_get_contents($url . 'testip.php') ;

    // use the security_key as defined in your app/config/configuration.php
    //$key = '23534f3223a3cb234234324208';
    $key = 'e6718badccd049982169c6325d18b6bf'; 

    // now we can build the key we need
    $finalKey = sha1($myIp.$key) ;

    try {
        $soap = new SoapClient($url . 'registration.soap.php?wsdl');
    } catch (Exception $e) {
        die('Erro ao inicializar o cliente SOAP: ' . $e->getMessage());
    }
  
    $params = array(
        'secret_key' => $finalKey,
        'from' => 0,
        'to' => 10
    );
    echo '<pre>'; print_r($params); echo '</pre>';
    try {
        // Chame o método ListCourses
        $response = $soap->WSListCourses($params);
        echo '<pre>'; print_r($response); echo '</pre>';
        // Exiba a resposta
        echo '<h3>Lista de Cursos:</h3>';
        echo '<pre>'; print_r($response); echo '</pre>';
    } catch (Exception $e) {
        echo 'Erro ao chamar o serviço SOAP: ' . $e->getMessage();
    }
?>