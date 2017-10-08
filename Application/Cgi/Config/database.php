<?php
defined('BASE_PATH') OR exit('No direct script access allowed');
/**
 * YanPHP
 * User: weilongjiang(江炜隆)<willliam@jwlchina.cn>
 */


/**
 *  -------------------------------------------------------------
 * |Database config                                              |
 *  -------------------------------------------------------------
 *
 */

/** host */
$config['db_host'] = 'mysql';

/** 数据库用户名 */
$config['db_user'] = 'root';

/** 数据库密码 */
$config['db_password'] = 'root';

/** 端口 */
$config['db_port'] = 3306;

/** 数据库 */
$config['db_database'] = '';

/** 表名前缀 */
$config['db_prefix'] = '';

/**
 * 数据库驱动，可选的有： mysql、oracle等
 * @see
 */
$config['db_driver'] = 'mysql';

$config['db_charset'] = 'utf8';

$config['db_collation'] = 'utf8_unicode_ci';