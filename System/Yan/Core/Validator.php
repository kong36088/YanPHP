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
            'between' => 'Between',
            'min' => 'min',
            'max' => 'max',
            'length' => 'length',
            'equal' => 'Equals',
        );

    }

    /**
     * 验证输入参数
     *
     * @param string $paramName
     * @param mixed $input
     * @param string $rules
     * @param string $resultMsg 验证结果信息
     * @return bool
     */
    public static function validate($paramName, $input, string $rules, &$resultMsg): bool
    {
        $rulesArr = explode('|', $rules);
        //遍历所有用户定义的规则
        foreach ($rulesArr as $r) {
            if (empty($r)) {
                continue;
            }

            preg_match('/([a-zA-Z_]*)(\[(.*)\]){0,1}/', $r, $matches);
            $rule = $matches[1];
            //规则是否存在
            if (!array_key_exists($rule, self::$rules)) {
                $resultMsg = "incorrect rule '{$r}'";
                return false;
            }
            $ruleParams = array();
            if (isset($matches[3])) {
                $ruleParams = explode(',', $matches[3]);
            }
            //利用反射获取rule所需入参个数
            $respectRule = "\\Respect\\Validation\\Rules\\" . self::$rules[$rule];
            $ruleRef = new \ReflectionClass($respectRule);
            if ($ruleRef->hasMethod('__construct')) {
                $respectRuleParamNum = count($ruleRef->getConstructor()->getParameters());
            } else {
                $respectRuleParamNum = 0;
            }

            $ruleParams = array_slice($ruleParams, 0, $respectRuleParamNum);

            $validate = call_user_func_array([v::class, self::$rules[$rule]], $ruleParams);
            try {
                $validate->setName($paramName)->assert($input);
            } catch (NestedValidationException $exception) {
                $resultMsg = $exception->getFullMessage();
                return false;
            }
        }
        return true;
    }
}