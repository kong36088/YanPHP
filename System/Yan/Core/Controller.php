<?php
/**
 * Longphp
 * Author: William Jiang
 */

namespace Long\Core;

use Long\Library\Logger\Log;
use Philo\Blade\Blade;


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
     * render templates using blade
     * @param string $bladeFile blade directory
     * @param array $params the data being assigned
     */
    function render($bladeFile, $params = array())
    {
        $blade = new Blade(VIEW_PATH, CACHE_PATH);
        $html = $blade->view()->make($bladeFile, $params)->render();
        output($html, 'html');
    }

    /**
     * To load model
     * @param string $className model class name
     * @param array $args
     * @param string $namespace the namespace of model
     * @return object
     */
    protected function &model($className, $args = array(), $namespace = ''){
        if(empty($namespace)){
            $namespace = $this->_modelPath;
        }

        $className = ucfirst($className);
        
        $namespace = trim($namespace,'\\\/');
        $fullClassName = $namespace . '\\' . $className;

        if(isset($this->_models[$fullClassName])){
            return $this->_models[$fullClassName];
        }

        $ReflectionClass = new \ReflectionClass($fullClassName);
        $this->_models[$fullClassName] = $ReflectionClass->newInstance($args);
        return $this->_models[$fullClassName];
    }
}