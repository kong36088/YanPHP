<?php
/**
 * User: weilongjiang(江炜隆)<willliam@jwlchina.cn>
 * Date: 2017/8/23
 * Time: 19:43
 */

namespace Yan\Core;


use Monolog\Handler\RotatingFileHandler;
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
    protected static $logger = null;

    protected static $logPath = APP_PATH . "/logs";

    protected static $logMaxFile = 0;

    protected static $logLevel = 'DEBUG';

    public static function getInstance(): Logger
    {
        self::$logPath = Config::get('log_path');
        self::$logMaxFile = Config::get('log_max_file');
        self::$logLevel = Config::get('log_level');
        if (empty(static::$logger)) {
            static::$logger = new Logger('YanLogger');
            $handler = new RotatingFileHandler(self::$logPath, self::$logMaxFile,self::$logLevel);
            static::$logger->pushHandler($handler);
        }
        return static::$logger;
    }

    public function initialize()
    {
        if (empty(static::$logger)) {
            static::$logger = new Logger('YanLogger');
            $handler = new StreamHandler(APP_PATH . "/logs");
            static::$logger->pushHandler($handler);
        }
    }

    /**
     * @param string $method
     * @param array $args
     * @return bool
     */
    public static function __callStatic(string $method, array $args): bool
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
    public function __call(string $method, array $args): bool
    {
        if (method_exists(static::$logger, $method)) {
            return call_user_func_array([static::$logger, $method], $args);
        } else {
            //TODO 抛出异常
            return false;
        }
    }
}