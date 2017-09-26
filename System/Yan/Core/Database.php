<?php
/*
 * YanPHP
 * User: weilongjiang(江炜隆)<william@jwlchina.cn>
 * Date: 2017/9/3
 * Time: 21:38
 */

namespace Yan\Core;

use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;

//TODO multi connection
class Database
{
    public static function initialize()
    {
        $capsule = new Capsule;

        $driver = Config::get('db_driver')?:'';
        $host = Config::get('db_host')?:'';
        $user = Config::get('db_user')?:'';
        $password = Config::get('db_password')?:'';
        $database = Config::get('db_database')?:'';
        $charset = Config::get('db_charset')?:'';
        $collation = Config::get('db_collation')?:'';
        $prefix = Config::get('db_prefix')?:'';


        $capsule->addConnection([
            'driver' => $driver,
            'host' => $host,
            'database' => $database,
            'username' => $user,
            'password' => $password,
            'charset' => $charset,
            'collation' => $collation,
            'prefix' => $prefix,
        ]);

        // Set the event dispatcher used by Eloquent models... (optional)

        $capsule->setEventDispatcher(new Dispatcher(new Container));

        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();
    }
}