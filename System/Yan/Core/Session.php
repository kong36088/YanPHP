<?php
/*
 * YanPHP
 * User: weilongjiang(江炜隆)<william@jwlchina.cn>
 * Date: 2017/9/28
 * Time: 13:56
 */

namespace Yan\Core;


use Aura\Session\SessionFactory;

class Session
{
    /** @var \Aura\Session\SessionFactory */
    protected static $sessionFactory;
    /** @var  \Aura\Session\Session */
    protected static $session;
    /** @var  \Aura\Session\Segment */
    protected static $segment;

    public static function initialize()
    {
        static::$sessionFactory = new SessionFactory();
        static::$session = static::$sessionFactory->newInstance($_COOKIE);
        static::$segment = static::$session->getSegment('YanPHP\Core\Session');

        static::$session->setSavePath(Config::get('session_path'));
    }

    public static function start(): bool
    {
        return static::$session->start();
    }

    public static function commit()
    {
        return static::$session->commit();
    }

    public static function destroy():bool
    {
        return static::$session->destroy();
    }

    public static function __callStatic($name, $arguments)
    {
        //立即刷数据到磁盘
        static::$session->start();
        $ret = call_user_func([static::$segment, $name], $arguments);
        static::$session->commit();
        return $ret;
    }
}