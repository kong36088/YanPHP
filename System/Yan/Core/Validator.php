<?php
/*
 * YanPHP
 * User: weilongjiang(江炜隆)<william@jwlchina.cn>
 * Date: 2017/9/10
 * Time: 17:49
 */

namespace Yan\Core;


class Validator
{
    /** @var \Respect\Validation\Validator  */
    protected static $validator = null;

    public static function initialize(){
        self::$validator = \Respect\Validation\Validator::class;
    }

    public static function validate(){

    }
}