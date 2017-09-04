<?php
/**
 * User: weilongjiang(江炜隆)<willliam@jwlchina.cn>
 * Date: 2017/8/24
 * Time: 11:22
 */

namespace TestNamespace;

use PHPUnit\Framework\TestCase;
use Yan\Core\Exception\YAssertionFailedException;
use Yan\Core\YAssert;

class YAssertTest extends TestCase
{
    public function testTrue()
    {
        $this->assertTrue(YAssert::true(1 === 1));
    }

    public function testAllTrue()
    {
        $this->assertTrue(YAssert::allTrue([true, 'a' => true]));
        $this->assertTrue(YAssert::allTrue(true));
    }

    public function testEq(){
        $this->assertTrue(YAssert::eq(1,'1'));
    }

    public function testNull(){
        $this->assertTrue(YAssert::null(null));
    }

    /**
     * @expectedException YAssertionFailedException
     */
    public function testException()
    {
        $this->assertTrue(YAssert::allTrue(1 == 2));
    }
}