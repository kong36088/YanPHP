<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * Longphp
 * Author: William Jiang
 */


if (!function_exists('isCli')) {
    /**
     * 判断是否为cli访问
     *
     * @return bool
     */
    function isCli()
    {
        return defined('STDIN') || PHP_SAPI === 'cli' ? true : false;
    }
}

if (!function_exists('setHeader')) {
    /**
     * @param int $code
     */
    function setHeader($code = 200)
    {
        if (isCli()) return;
        $code = intval($code);
        $status = array(
            100 => 'Continue',
            101 => 'Switching Protocols',

            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',

            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            307 => 'Temporary Redirect',

            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Sys',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            422 => 'Unprocessable Entity',

            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );
        if (!isset($status[$code])) {
            throwError('Invalid error code', 500);
        }

        if (strpos(PHP_SAPI, 'cgi') === 0) {
            header('Status:' . $code . ' ' . $status[$code], true);
        } else {
            $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
            header($protocol . ' ' . $code . ' ' . $status[$code], true, $code);
        }
    }
}


if (!function_exists('errorHandler')) {
    function errorHandler($severity, $errMsg, $errFile, $errLine, $errContext)
    {
        $is_error = (((E_ERROR | E_USER_ERROR | E_COMPILE_ERROR | E_CORE_ERROR | E_USER_ERROR) & $severity) === $severity);

        Long\Core\ExceptionHandle::logError($severity, $errMsg, $errFile, $errLine);

        if (($severity & error_reporting()) !== $severity) return;

        Long\Core\ExceptionHandle::showError(["Error message: $errMsg", "Error File:$errFile", "Error Line:$errLine"]);
        /**
         * 判断是否为致命错误
         */
        if ($is_error) {
            setHeader(500);
            exit(1);
        }

    }
}

if (!function_exists('exceptionHandler')) {
    /**
     * 显示处理异常
     * @param Exception $exception
     */
    function exceptionHandler($exception)
    {
        Long\Core\ExceptionHandle::logError('error', $exception->getMessage(), $exception->getFile(), $exception->getLine());

        if (str_ireplace(array('off', 'none', 'no', 'false', 'null'), '', ini_get('display_errors'))) {
            Long\Core\ExceptionHandle::showException($exception);
        }
        exit(1);
    }
}
if (!function_exists('throwError')) {
    function throwError($message = '', $status_code = 500, $isExit = true, $template = 'error_general')
    {
        Long\Library\Logger\Log::error($message);

        Long\Core\ExceptionHandle::showError($message, $status_code, $template);

        if ($isExit) {
            exit(1);
        }
    }
}

if (!function_exists('M')) {
    function &M($name)
    {
        $modelName = ucfirst($name) . 'Model';
        $modelFile = ucfirst($name) . 'Model.php';
        $filePath = APP_PATH . DIRECTORY_SEPARATOR . 'Model' . DIRECTORY_SEPARATOR . $modelFile;

        //判断文件是否存在
        if (!file_exists($filePath)) {
            throwError('Model ' . $name . 'does not exist');
        }
        $model = 'Model\\' . $modelName;
        $M = new $model();
        return $M;
    }
}


if (!function_exists('getInstance')) {
    /**
     * Reference to the Controller method.
     *
     * Returns current Long instance object
     *
     * @return \Long\Core\Controller
     */
    function &getInstance()
    {
        return \Long\Core\Controller::getInstance();
    }
}


if (!function_exists('isPHP')) {
    /**
     * Determines if the current version of PHP is equal to or greater than the supplied value
     *
     * @param    string
     * @return    bool    TRUE if the current version is $version or higher
     */
    function isPHP($version)
    {
        static $_isPHP;
        $version = (string)$version;

        if (!isset($_isPHP[$version])) {
            $_isPHP[$version] = version_compare(PHP_VERSION, $version, '>=');
        }

        return $_isPHP[$version];
    }
}


if (!function_exists('input')) {
    /**
     * get input params
     * @param string $key format:get.a(return Input::get('a')) post.b(return Input::post('b')) c(return Input::input('c'))
     * @return array|null|string
     */
    function input($key = '')
    {
        $keyArr = explode('.', $key);
        $keyArr[1] = $keyArr ?: '';
        switch (strtoupper($keyArr[0])) {
            case 'GET':
                return Long\Library\Input::get($keyArr[1]);
            case 'POST':
                return Long\Library\Input::post($keyArr[1]);
            case 'DELETE':
                return Long\Library\Input::delete($keyArr[1]);
            case 'PUT':
                return Long\Library\Input::put($keyArr[1]);
            default:
                return Long\Library\Input::input($keyArr[1]);
        }
    }
}

if (!function_exists('output')) {
    /**
     * @param string|array $data
     * @param string $type output type
     */
    function output($data, $type = 'RAW')
    {
        $type = strtoupper($type);

        switch ($type) {
            case 'JSON':
                Long\Library\Output::json($data);
                break;
            case 'HTML':
                Long\Library\Output::html($data);
                break;
            default:
                Long\Library\Output::raw($data);
        }
    }
}