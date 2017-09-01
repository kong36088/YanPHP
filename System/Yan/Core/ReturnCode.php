<?php

/**
 * User: weilongjiang(江炜隆)<willliam@jwlchina.cn>
 * Date: 2017/8/23
 * Time: 19:43
 */

namespace Yan\Core;


class ReturnCode
{
    //系统错误------------------------------------------------------------
    const OK                                    = 0;
    const SYSTEM_ERROR                          = -1; //系统错误
    const METHOD_NOT_EXIST                      = -2; //方法不存在

    //逻辑错误------------------------------------------------------------
    const INVALID_ARGUMENT                      = 5001; //参数错误

}