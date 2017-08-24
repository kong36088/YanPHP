<?php
/**
 * Longphp
 * Author: William Jiang
 */

namespace Long\Core;

use Long\Library\Logger\Log;

/**
 * Class Dispatcher
 * @package Long\Core
 */
class Dispatcher
{
    /**
     * factory instance
     * @var
     */
    private static $_instance;

    protected $_defaultController;

    protected $_defaultMethod;

    protected $_controllerPath;

	public static function initialize()
	{
	    $instance = self::getInstance();
		if (isCli()) {
            $instance->_commandLine();
		}
		Log::debug('Router init, request URI ' . $_SERVER['REQUEST_URI']);

		//init vars
        $instance->_defaultController = Config::get('default_controller');
        $instance->_defaultMethod = Config::get('default_method');
        $instance->_controllerPath = Config::get('application_path') . '\\Controller\\';


		$appRequest = $instance->_router();
		//call controller
        $instance->_handler($appRequest);
	}

	protected function _commandLine()
	{
		$_SERVER['REQUEST_URI'] = "";
		foreach ($_SERVER['argv'] as $k => $v) {
			if ($k == 0) continue;
			$_SERVER['REQUEST_URI'] .= "/" . $v;
		}
	}

	/**
	 * handle uri
     *
	 * @return array
	 */
	protected function _router()
	{
		$urlPath = $_SERVER['REQUEST_URI'];
		$filePath = $_SERVER['PHP_SELF'];
		$documentPath = $_SERVER['DOCUMENT_ROOT'];

		$appPath = str_replace($documentPath, '', $filePath);

		$appPathArr = explode(DIRECTORY_SEPARATOR, $appPath);

		//get the real controller and method
		foreach ($appPathArr as $k => $v) {
			if ($v) {
				$urlPath = preg_replace('/^\/' . $v . '\/?/', '/', $urlPath, 1);
			}
		}
		$urlPath = preg_replace('/^\//', '', $urlPath, 1); //ltrim($urlPath,'/')

		$appPathArr = explode('/', $urlPath);

		//trim the parameters
        if(!empty($appPathArr[0])){
            $appPathArr[0] = preg_replace('/(\?.*)$/', '', $appPathArr[0]);
        }
		if (!empty($appPathArr[1])) {
			$appPathArr[1] = preg_replace('/(\?.*)$/', '', $appPathArr[1]);
		}
		$appRequest = array(
			'controller' => empty($appPathArr[0]) ? $this->_defaultController : $appPathArr[0],
			'method' => empty($appPathArr[1]) ? $this->_defaultMethod : $appPathArr[1],
		);

		return $appRequest;
	}


	protected function _handler(Array $appRequest)
	{
		if (empty($appRequest['controller']) || empty($appRequest['method'])) {
			ExceptionHandle::show404();
			exit(1);
		}

        $controllerName = ucfirst($appRequest['controller']) . 'Controller';
		$controllerFile = ucfirst($appRequest['controller']) . 'Controller.php';
		$filePath = APP_PATH . DIRECTORY_SEPARATOR . 'Controller' . DIRECTORY_SEPARATOR . $controllerFile;

		$callMethod = $appRequest['method'];

		//判断文件是否存在
		if (!file_exists($filePath)) {
			ExceptionHandle::show404();
			exit(1);
		}

		$controller = $this->_controllerPath . $controllerName;
		$C = new $controller();

		//invoke constructor
        if(method_exists($C,'initialize') && is_callable($C,'initialize')){
            $C->initialize();
        }

		//method invoke
		if (!method_exists($C, $callMethod) || !is_callable(array($C, $callMethod))) {
			ExceptionHandle::show404();
			exit(1);
		}
		$C->$callMethod();
	}

    /**
     * @return object
     */
    public static function getInstance()
    {
        return empty(self::$_instance)?(self::$_instance = new self()):self::$_instance;
    }

}