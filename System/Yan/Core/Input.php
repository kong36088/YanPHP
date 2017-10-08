<?php
/**
 * YanPHP
 * User: weilongjiang(江炜隆)<willliam@jwlchina.cn>
 */

namespace Yan\Core;


use Yan\Core\Exception\FileNotExistException;
use Yan\Core\Exception\InvalidArgumentException;
use Yan\Core\Exception\RuntimeException;

//TODO 优化
class Input
{
    protected static $data = array();

    protected static $method;

    public static function initialize()
    {
        self::$method = strtoupper($_SERVER['REQUEST_METHOD']);
        parse_str(file_get_contents('php://input'), $input);
        $input = array_merge($input, $_GET);
        $input = array_merge($input, $_POST);

        //根据Param/xxx.ini中配置的入参进行筛选
        $paramFile = BASE_PATH . '/Param/' . Dispatcher::$controllerShortName . '.ini';
        if (!file_exists($paramFile)) {
            throwErr("file {$paramFile} does not exist", ReturnCode::SYSTEM_ERROR, FileNotExistException::class);
        }
        $paramRules = parse_ini_file($paramFile, true);
        if (!$paramRules) {
            throwErr("can not parse file {$paramFile}", ReturnCode::SYSTEM_ERROR, RuntimeException::class);
        }
        //规则验证
        foreach ($paramRules[Dispatcher::$method] ?: [] as $key => $rule) {
            $value = $input[$key] ?? null;
            $ret = Validator::validate($key, $value, $rule, $msg);
            if (!$ret) {
                throwErr($msg, ReturnCode::INVALID_ARGUMENT, InvalidArgumentException::class);
            }
            self::$data[$key] = $input[$key];
        }
    }

    public static function get($key = '')
    {
        if (empty($key)) return self::_clean(self::$data);
        return isset(self::$data[$key]) ? self::_clean(self::$data[$key]) : null;
    }

    public static function set($key,$value)
    {
        self::$data[$key] = $value;
    }

    /*
    public static function post($key = '')
    {
        if (empty($key)) return self::_clean($_POST);
        return isset($_POST[$key]) ? self::_clean($_POST[$key]) : null;
    }

    public static function put($key = '')
    {
        if (self::$method === 'PUT') {
            return self::getRaw($key);
        } else {
            return null;
        }
    }

    public static function delete($key = '')
    {
        if (self::$method === 'DELETE') {
            return self::getRaw($key);
        } else {
            return null;
        }
    }

    public static function input($key)
    {
        return self::getRaw($key);
    }
    */

    protected static function _clean($data)
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $data[$k] = self::_clean($v);
            }
            return $data;
        }

        return trim($data);
    }

    protected static function getRaw($key)
    {
        if (empty($key)) return self::_clean(self::$data);
        return isset(self::$data[$key]) ? self::_clean(self::$data[$key]) : null;
    }
}