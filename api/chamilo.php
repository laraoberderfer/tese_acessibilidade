<?php

    //$url = 'https://chamilo.net/main/webservices/';
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
    // prepare the user details
    $params = array(
        'secret_key' => $finalKey,
        'firstname' => 'Lara',
        'lastname' => 'Popov Zambiasi',
        'status' => 1,
        'loginname' => 'lara',
        'password' => 'Paprika12',
        'encrypt_method' => 'sha1',
        'email' => 'lara.oberderfer@gmail.com',
        'language' => 'pt-br',
        'phone' => '',
        'expiration_date' => '2025-04-22',
        'original_user_id_name' => 'external_user_id',
        'original_user_id_value' => 34,
        'official_code' => 34,
        'extra' => array()
    );
   
    try {
        // call the service

        $soap->WSCreateUserPasswordCrypted($params);
        echo '<pre>'; print_r($params); echo '</pre>';
        //$soap->WSCourseDescription($params);

        if ($soap->__getLastResponse()) {
            echo '<pre>'; print_r($soap->__getLastResponse()); echo '</pre>';
        } else {
            echo 'Nenhuma resposta recebida.';
        }
    } catch (Exception $e) {
        echo 'Erro ao chamar o serviço SOAP: ' . $e->getMessage();
    }
   
?>