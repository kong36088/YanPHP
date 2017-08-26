<?php
/**
 * User: weilongjiang(江炜隆)<willliam@jwlchina.cn>
 * Date: 2017/8/23
 * Time: 17:54
 */
require_once "Yan/Common/Functions.php";

Yan\Core\Config::initialize();

Yan\Core\Log::initialize();


$test = new Yan\Core\Log();
$test->debug('debug log', ['a', 'b' => BASE_PATH]);
$test->info('info log');
try {
    Yan\Core\Log::notthing(123);
} catch (Exception $e) {
    print_r($e->getMessage());
    print_r($e->getCode());
}

$routeCollector = new \FastRoute\RouteCollector(new FastRoute\RouteParser\Std(), new FastRoute\DataGenerator\GroupCountBased());

$routeCollector->addRoute('GET', '/', 'test_handler');
$routeCollector->addRoute('GET', '/interface.php', 'test_handler');

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
}, ['routeCollector' => $routeCollector]);

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        header("HTTP/1.1 404 Not Found");
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        header("HTTP/1.1 405 Method Not Allowed");
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        // ... call $handler with $vars
        break;
}

var_dump($routeInfo);