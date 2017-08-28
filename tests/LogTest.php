<?php
/**
 * User: weilongjiang(江炜隆)<willliam@jwlchina.cn>
 * Date: 2017/8/24
 * Time: 11:22
 */

namespace TestNamespace;

use PHPUnit\Framework\TestCase;
use Yan\Core\Log;

class LogTest extends TestCase
{
    public function testLog()
    {
        Log::log('INFO', 'log test message');
        $this->assertTrue(true);
    }

    public function testDebug()
    {
        Log::debug('debug test message');
        $this->assertTrue(true);
    }

    public function testInfo()
    {
        Log::debug('info test message');
        $this->assertTrue(true);
    }

    public function testWarning()
    {
        Log::debug('warning test message');
        $this->assertTrue(true);
    }

    public function testError()
    {
        Log::debug('error test message');
        $this->assertTrue(true);
    }
}