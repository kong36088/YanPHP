<?php
/**
 * User: weilongjiang(江炜隆)<willliam@jwlchina.cn>
 * Date: 2017/8/23
 * Time: 19:43
 */

namespace Yan\Core;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class Log
 * @package Yan\Core
 * @method static bool emergency($message, array $context = array())
 * @method static bool alert($message, array $context = array())
 * @method static bool critical($message, array $context = array())
 * @method static bool error($message, array $context = array())
 * @method static bool warning($message, array $context = array())
 * @method static bool notice($message, array $context = array())
 * @method static bool info($message, array $context = array())
 * @method static bool debug($message, array $context = array())
 * @method static bool log($message, array $context = array())
 */
class Log
{
    /**
     * @var Logger
     */
    private static $logger = null;

    private static $logPath = APP_PATH . "/logs";

    public static function getInstance(): Logger
    {
        if (empty(static::$logger)) {
            static::$logger = new Logger('YanLogger');
            $handler = new StreamHandler(APP_PATH . "/logs");
            static::$logger->pushHandler($handler);
        }
        return static::$logger;
    }

    public function initialize(): void
    {
        if (empty(static::$logger)) {
            static::$logger = new Logger('YanLogger');
            $handler = new StreamHandler(APP_PATH . "/logs");
            static::$logger->pushHandler($handler);
        }
    }

    /**
     * @param callable $method
     * @param array $args
     * @return bool
     */
    public static function __callStatic(callable $method, array $args): bool
    {
        if (method_exists(static::$logger, $method)) {
            return call_user_func_array([static::$logger, $method], $args);
        } else {
            //TODO 抛出异常
            return false;
        }
    }

    /**
     * @param callable $method
     * @param array $args
     * @return bool
     */
    public function __call(callable $method, array $args): bool
    {
        if (method_exists(static::$logger, $method)) {
            return call_user_func_array([static::$logger, $method], $args);
        } else {
            //TODO 抛出异常
            return false;
        }
    }
}