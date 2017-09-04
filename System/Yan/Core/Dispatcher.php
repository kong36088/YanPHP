<?php
/**
 * YanPHP
 * User: weilongjiang(江炜隆)<willliam@jwlchina.cn>
 */

namespace Yan\Core;

use FastRoute;

/**
 * Class Dispatcher
 * @package Yan\Core
 */
class Dispatcher
{
    /** @var string 匹配路径 */
    protected static $handler = '';

    public static function initialize()
    {
        $rules = static::getRules();
        $dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) use ($rules) {
            foreach ($rules as $route => $rule) {
                $handler = $rule['controller'] . '.' . ($rule['method'] ?? '');
                $r->addRoute($rule['request_method'], $route, $handler);
            }
        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        Log::debug('request uri=' . $uri . ' method=' . $httpMethod);

        $uri = substr($uri, strpos($uri, '/interface.php') + 14) ?: $uri;

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rtrim($uri, '\\/');
        $uri = empty($uri) ? '/' : $uri;

        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        $code = ReturnCode::OK;
        $msg = '';
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                // TODO 默认分发策略
                $code = ReturnCode::REQUEST_404;
                $msg = '404 Not Found';
                header("HTTP/1.1 404 Not Found");
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                header("HTTP/1.1 405 Method Not Allowed");
                $code = ReturnCode::REQUEST_METHOD_NOT_ALLOW;
                $msg = 'Method Not Allowed';
                break;
            case FastRoute\Dispatcher::FOUND:
                static::$handler = $routeInfo[1];
                $vars = $routeInfo[2];
                break;
        }

        if ($code != ReturnCode::OK) {
            $result = genResult($code, $msg, []);
            showResult($result);
        }
    }

    public static function getHandler()
    {
        return static::$handler;
    }

    public static function dispatch()
    {
        $handlerArr = explode('.', static::$handler);
        if (empty($handlerArr[0])) {
            show404();
        }
        if (!method_exists($handlerArr[0], $handlerArr[1])) {
            show404();
        }
        return $handlerArr;
    }

    public static function getRules()
    {
        return Config::get('route');
    }

}