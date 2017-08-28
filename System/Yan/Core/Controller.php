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
        $this->_libraryPath = Config::get('application_path') . '\\Library';
        $this->_modelPath = Config::get('application_path') . '\\Model';

        Log::debug('Init Controller ' . __CLASS__);
    }

    public static function &getInstance()
    {
        return self::$_instance;
    }


    /**
     * To load model
     * @param string $className model class name
     * @param array $args
     * @param string $namespace the namespace of model
     * @return object
     */
    protected function &model($className, $args = array(), $namespace = '')
    {
        if (empty($namespace)) {
            $namespace = $this->_modelPath;
        }

        $className = ucfirst($className);

        $namespace = trim($namespace, '\\\/');
        $fullClassName = $namespace . '\\' . $className;

        if (isset($this->_models[$fullClassName])) {
            return $this->_models[$fullClassName];
        }

        $ReflectionClass = new \ReflectionClass($fullClassName);
        $this->_models[$fullClassName] = $ReflectionClass->newInstance($args);
        return $this->_models[$fullClassName];
    }
}