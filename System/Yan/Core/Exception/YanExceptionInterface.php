<?php
/**
 * LongPHP
 * Author: William Jiang <william@jwlchian.cn>
 * Date: 2017/5/3
 * Time: 下午12:25
 */

namespace Long\Core\Exception;


interface YanExceptionInterface
{
    public function getPropertyPath(): string;

    public function getValue(): mixed;
}