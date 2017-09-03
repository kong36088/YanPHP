<?php
/**
 * User: weilongjiang(江炜隆)<willliam@jwlchina.cn>
 * Date: 2017/8/24
 * Time: 11:22
 */

namespace TestNamespace;

use PHPUnit\Framework\TestCase;
use Yan\Core\YAssert;

class YAssertTest extends TestCase
{
    /**
     * @Expect
     */
    public function testAssertTrue(){
        YAssert::allTue(1==2);
    }
}