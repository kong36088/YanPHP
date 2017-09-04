<?php
/**
 * User: weilongjiang(江炜隆)<willliam@jwlchina.cn>
 * Date: 2017/8/23
 * Time: 17:54
 */
defined('YAN_VERSION') or define('YAN_VERSION', '0.1');


require_once "Yan/Common/Functions.php";

Yan\Core\Config::initialize();

Yan\Core\Log::initialize();

set_exception_handler('exceptionHandler');
set_error_handler('errorHandler');


/**
 * database
 */
\Yan\Core\Database::initialize();

/**
 * router
 */
\Yan\Core\Dispatcher::initialize();
$dispatch = \Yan\Core\Dispatcher::dispatch();

$controller = new $dispatch[0];
$controller->$dispatch[1];
//TODO 入参校验、层级调用