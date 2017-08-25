<?php
/**
 * YanPHP
 * User: weilongjiang(江炜隆)<willliam@jwlchina.cn>
 */

namespace Yan\Core;


class Input
{
    protected static $_data = array();

    protected static $_method;

    public static function initialize()
    {
        self::$_method = strtoupper($_SERVER['REQUEST_METHOD']);
        parse_str(file_get_contents('php://input'), self::$_data);
    }

    public static function get($key = '')
    {
        if (empty($key)) return self::_clean($_GET);
        return isset($_GET[$key]) ? self::_clean($_GET[$key]) : null;
    }

    public static function post($key = '')
    {
        //print_r(self::$_data);
        if (self::$_method === 'POST') {
            return self::getRaw($key);
        } else {
            return null;
        }
    }

    public static function put($key = '')
    {
        if (self::$_method === 'PUT') {
            return self::getRaw($key);
        } else {
            return null;
        }
    }

    public static function delete($key = '')
    {
        if (self::$_method === 'DELETE') {
            return self::getRaw($key);
        } else {
            return null;
        }
    }

    public static function input($key)
    {
        return self::getRaw($key);
    }

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
        if (empty($key)) return self::_clean(self::$_data);
        return isset(self::$_data[$key]) ? self::_clean(self::$_data[$key]) : null;
    }
}