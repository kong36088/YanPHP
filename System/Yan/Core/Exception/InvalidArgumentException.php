<?php
/**
 * YanPHP
 * User: weilongjiang(江炜隆)<willliam@jwlchina.cn>
 * Date: 2017/8/25
 * Time: 19:40
 */

namespace Long\Core\Exception;


class InvalidArgumentException extends \InvalidArgumentException implements YanExceptionInterface
{

    private $propertyPath;
    private $value;

    public function __construct($message, $code, $propertyPath, $value)
    {
        parent::__construct($message, $code);

        $this->propertyPath = $propertyPath;
        $this->value = $value;
    }

    /**
     * User controlled way to define a sub-property causing
     * the failure of a currently asserted objects.
     *
     * Useful to transport information about the nature of the error
     * back to higher layers.
     *
     * @return string
     */
    public function getPropertyPath(): string
    {
        return $this->propertyPath;
    }

    /**
     * Get the value that caused the assertion to fail.
     *
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }
}