<?php
/**
 * YanPHP
 * User: weilongjiang(江炜隆)<willliam@jwlchina.cn>
 */

namespace Yan\Core;


class Controller
{

    private static $_instance;
    /**
     * @var array
     */
    protected $_class = array();

    /**
     * loaded class
     * @var array
     */
    protected $_loaded = array();

    /**
     * to store the loaded models
     * @var array
     */
    protected $_models = array();

    /**
     * Library path according to configuration
     * @var string
     */
    protected $_libraryPath;

    /**
     * Model path according to configuration
     * @var string
     */
    protected $_modelPath;

    public function __construct()
    {
        self::$_instance = &$this;

        Log::debug('Init Controller ' . static::class);
    }

    public static function &getInstance()
    {
        return self::$_instance;
    }


    protected function succ(string $msg = '', array $data = [])
    {
        $result = genResult(ReturnCode::OK, $msg, $data);
        showResult($result);
    }

    protected function fail(int $code, string $msg = '', array $data = [])
    {
        $result = genResult($code, $msg, $data);
        showResult($result);
    }
}