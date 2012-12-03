<?php

namespace Vandpibe\Filtering\Exception;

/**
 * This is borrowed from:
 * https://github.com/symfony/symfony/blob/master/src/Symfony/Component/Form/Exception/FormException.php
 *
 * @package Vandpibe
 */
class UnexpectedTypeException extends \Exception
{
    /**
     * @param mixed $value
     * @param mixed $expectedType
     */
    public function __construct($value, $expectedType)
    {
        parent::__construct(sprintf('Expected argument of type "%s", "%s" given', $expectedType, is_object($value) ? get_class($value) : gettype($value)));
    }
}
