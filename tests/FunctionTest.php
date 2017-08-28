<?php
/**
 * User: weilongjiang(江炜隆)<willliam@jwlchina.cn>
 * Date: 2017/8/24
 * Time: 11:22
 */

namespace TestNamespace;

use PHPUnit\Framework\TestCase;
use Yan\Core\Controller;

class FunctionTest extends TestCase
{
    function testIsCli(){
        $this->assertTrue(isCli());
    }

    function testGetInstance(){
        $c = getInstance();
        $this->assertNotEmpty($c);
        $this->assertTrue($c instanceof Controller);
    }
}