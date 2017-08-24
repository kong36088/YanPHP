<?php
/**
 * User: weilongjiang(江炜隆)<willliam@jwlchina.cn>
 * Date: 2017/8/23
 * Time: 17:06
 */


$applicationPath = 'Application';

$systemPath = 'System';

/**
 * 视图路径
 */

$cachePath = 'cache';

defined('SELF') or define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

defined('SYS_PATH') or define('SYS_PATH', rtrim($systemPath, '/\\'));

defined('APP_PATH') or define('APP_PATH', rtrim($applicationPath, '/\\'));

defined('BASE_PATH') or define('BASE_PATH', dirname(__FILE__));

defined('CACHE_PATH') or define('CACHE_PATH',$cachePath);


require "vendor/autoload.php";

require "System/yan.php";