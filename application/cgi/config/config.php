<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * YanPHP
 * User: weilongjiang(江炜隆)<willliam@jwlchina.cn>
 */

/**
 *  -------------------------------------------------------------
 * |System config                                                |
 *  -------------------------------------------------------------
 *
 * base_url
 * The Host of your application
 * Example: www.php.net
 */
$config['base_url'] = 'vm/';

/**
 * location of your application
 */
$config['application_path'] = 'application';


/**
 *  -------------------------------------------------------------
 * |Log config                                                   |
 *  -------------------------------------------------------------
 *
 * Logger::DEBUG => 'DEBUG',
 * Logger::INFO => 'INFO',
 * Logger::NOTICE => 'NOTICE',
 * Logger::WARNING => 'WARNING',
 * Logger::ERROR => 'ERROR',
 * Logger::CRITICAL => 'CRITICAL',
 * Logger::ALERT => 'ALERT',
 * Logger::EMERGENCY => 'EMERGENCY',
 */
$config['log_level'] = 'DEBUG';
/**
 * The log path
 */
$config['log_path'] = BASE_PATH . '/logs/cgi.log';
/**
 *  Max file num, default 0(not limited)
 */
$config['log_max_file'] = 0;


/**
 *  -------------------------------------------------------------
 * |Session config                                               |
 *  -------------------------------------------------------------
 *
 * Configuring session driver
 *
 * Alternative: file database
 */
$config['session_driver'] = 'file';

/**
 * session_path leave blank to use default
 */
$config['session_path'] = BASE_PATH . '/Framework/session';

$config['session_cookie_name'] = 'LONG_SESSION';

$config['session_expiration'] = 7200;


/**
 * --------------------------------------------------------------------------
 *| Cookie Related Variables                                                 |
 * --------------------------------------------------------------------------
 *
 * 'cookie_prefix'   = Set a cookie name prefix if you need to avoid collisions
 * 'cookie_domain'   = Set to .your-domain.com for site-wide cookies
 * 'cookie_path'     = Typically will be a forward slash
 * 'cookie_secure'   = Cookie will only be set if a secure HTTPS connection exists.
 * 'cookie_httponly' = Cookie will only be accessible via HTTP(S) (no javascript)
 *
 * Note: These settings (with the exception of 'cookie_prefix' and
 * 'cookie_httponly') will also affect sessions.
 *
 */
$config['cookie_prefix'] = 'long_';
$config['cookie_domain'] = '';
$config['cookie_path'] = '/';
$config['cookie_secure'] = FALSE;
$config['cookie_httponly'] = FALSE;