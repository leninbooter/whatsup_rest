<?php
define('SLIM_APP_ROOT', dirname(__DIR__));

require '../vendor/autoload.php';
require_once '../include/dbhandler.php';

$app = new \Slim\Slim();

// Require all paths/routes
$routesDir = SLIM_APP_ROOT . '/routes/';
require $routesDir . 'places.php';
require $routesDir . 'specials.php';

$app->view->parserOptions = array(
    'charset' => 'utf-8',
    'cache' => realpath('../templates/cache'),
    'auto_reload' => true,
    'strict_variables' => false,
    'autoescape' => true
);

/**
 * Echoing json response to client
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);
 
    // setting response content type to json
    $app->contentType('application/json');
	
    echo json_encode($response);
}

$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});




$app->run();