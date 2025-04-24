<?php

$db = "pgsql";
$dbname = "lara";
$username = "lara";
$pass = "1234";
$API_KEY = "lkawjflkajsl";
$_LOG_PATH = "/home/lara/public_html/logs/";

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$obj = new stdClass();
/*
$obj->result = $_SERVER['HTTP_ACCEPT'];
if (strpos($_SERVER['HTTP_ACCEPT'], 'json') !== false) {
    $obj->error = "format of request is not JSON.";
    echo json_encode($obj);
    return;
}
*/
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);

if ($data['API_KEY'] != $API_KEY) {
    $obj->error = "You are not allowed!";
} else {
    switch ($method) {
        case 'GET':
            get();
            break;
        case 'POST':
            post();
            break;
        default:
            $obj->error = "Method $method not allowed.";
    }
}
echo json_encode($obj);

/*** IMPLEMENTAÇÃO DOS MÉTODOS *****************************************/

/** 
 * Função para retornar um objeto ou lista de objetos
 */
function get()
{
    global $obj;
    $obj->result = "Logs API";
}

function post()
{
    global $obj, $data, $_LOG_PATH;
    try 
    {
        $out = "{$data['date']} {$data['user']}@{$data['app']}: {$data['text']}\n";
        $obj->result = $out;
        $file = fopen($_LOG_PATH . $data['app'] . ".log", "a+");
        fwrite($file, $out);
        fclose($file);
        $obj->result = "OK";
    } catch (Exception $e) {
        $obj->error = $e->getMessage();
    }
}

/*
{
    "API_KEY": "lkawjflkajsl",
    "app": "godot",
    "date": "",
    "user": "user",
    "text": "Exemplo de informacao",
}

date = DD/MM/AA HH:MM:SS
*/
