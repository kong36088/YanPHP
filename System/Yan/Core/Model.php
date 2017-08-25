<?php
/**
 * YanPHP
 * User: weilongjiang(江炜隆)<willliam@jwlchina.cn>
 */

namespace Yan\Core;


class Model
{
    /**
     * Driver instance
     *
     * @var DBDriver
     */
    protected static $_db;
    protected $db;

    protected $_tableName = '';

    public function __construct()
    {
        Log::debug('Init Model' . __CLASS__);

        $dbDriver = 'Long\\Database\\' . ucfirst(Config::get('db_driver')) . 'Driver';
        $dbDriverFile = SYS_PATH . DIRECTORY_SEPARATOR . 'Long/Database/' . ucfirst(Config::get('db_driver')) . 'Driver.php';

        if (!file_exists($dbDriverFile)) {
            throwError('Db driver type error', 500, true);
        }

        //singleton
        if (empty($_db)) {
            self::$_db = new $dbDriver();
        }
        $this->db = & self::$_db;
    }
}