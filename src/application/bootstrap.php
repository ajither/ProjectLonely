<?php

/**
 * @author     Ajith E R, <ajithurulikunnam@gmail.com>
 * @date       September 11, 2017
 * @brief      All Bootstrap Activities
 * @details    
 */

session_cache_limiter(false);
session_save_path('/tmp');
session_start();
date_default_timezone_set('Asia/Kolkata');
define('INC_ROOT', dirname(__DIR__));

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require INC_ROOT . '/vendor/autoload.php';

$app = new Slim\App([
    'mode' => file_get_contents(INC_ROOT . '/mode.ini')
        ]);

$dotenv = new Dotenv\Dotenv(INC_ROOT . '/application/config', $app->getContainer()->mode . '.env');
$dotenv->load();

require INC_ROOT . '/application/config/database.php';
require INC_ROOT . '/application/controllers/ApiController.php';

$routeSource = INC_ROOT . '/application/config/routes.xml';
$routeXmlStr = file_get_contents($routeSource);
$routeXml = simplexml_load_string($routeXmlStr);
$routeJson = json_encode($routeXml);
$routeArray = json_decode($routeJson, TRUE);
$GLOBALS["routes"] = $routeArray;
$GLOBALS["v1.0"] = new \ApiController();

$app->post('/{version}/{apiname}', function (Request $request, Response $response) {
    $_SESSION['api_version'] = $request->getAttribute('version');
    $serevrParams = $request->getServerParams();
    $_SESSION['ip_address'] = $serevrParams['REMOTE_ADDR'];
    $apiname = $request->getAttribute('apiname');
    return $GLOBALS[$request->getAttribute('version')]->$apiname($request);
});

$app->get('/{version}/{apiname}', function (Request $request, Response $response) {
    $_SESSION['api_version'] = $request->getAttribute('version');
    $apiname = $request->getAttribute('apiname');
    return $GLOBALS[$request->getAttribute('version')]->$apiname($request);
});
