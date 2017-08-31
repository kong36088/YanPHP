<?php
/**
 * YanPHP
 * User: weilongjiang(江炜隆)<willliam@jwlchina.cn>
 * Date: 2017/8/31
 * Time: 21:43
 */

namespace Yan\Core;

use Assert\Assertion as BaseAssertion;

class YAssert extends BaseAssertion
{
    protected static $exceptionClass = 'Yan\Core\Exception\YAssertionFailedException';
}