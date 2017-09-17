<?php
/*
 * YanPHP
 * User: weilongjiang(江炜隆)<william@jwlchina.cn>
 * Date: 2017/9/10
 * Time: 17:49
 */

namespace Yan\Core;

use \Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{
    /** @var \Respect\Validation\Validator */
    protected static $validator = null;

    protected static $rules;

    public static function initialize()
    {
        //TODO test cases
        self::$rules = array(
            'required' => 'notOptional',
            'integer' => 'intType',
            'numeric' => 'numeric',
            'float' => 'floatType',
            'string' => 'stringType',
            'array' => 'arrayType',
            'valid_ip' => 'ip',
            'json' => 'json',
            'email' => 'email',
            'domain' => 'domain',
            'file' => 'file',
            'regex' => 'regex',

            // params
            //'in_list' => v::contains([1,2]),
            'starts_with' => 'startsWith',
            'ends_with' => 'endsWith',
            'min' => 'min',
            'max' => 'max',
            'length' => 'length'
        );

    }

    /**
     * 验证输入参数
     *
     * @param mixed $input
     * @param string $rules
     * @param string $resultMsg 验证结果信息
     * @return bool
     */
    public static function validate($input, string $rules, &$resultMsg): bool
    {
        $rulesArr = explode('|', $rules);
        //遍历所有用户定义的规则
        foreach ($rulesArr as $r) {
            preg_match('/(.*)(\[.*\])/', $r, $matches);
            $rule = $matches[0];
            //规则是否存在
            if (!array_key_exists($rule, self::$rules)) {
                $resultMsg = "incorrect rule '{$r}'";
                return false;
            }

            $ruleParams = explode(',', $matches[1]);
            if (!isset($rulesParams) || !isset($ruleParams[0])) {
                $ruleParams = array();
            }

            $validate = call_user_func_array([v::class, self::$rules[$rule]], $ruleParams);
            try {
                $validate->aseert($input);
            }catch (NestedValidationException $exception){
                $resultMsg = $exception->getFullMessage();
                return false;
            }
        }
        return true;
    }
}