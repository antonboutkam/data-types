<?php

namespace Hurah\Types\Type;

use Closure;
use Hurah\Types\Exception\InvalidArgumentException;
use function is_callable;
use function is_null;

/**
 * Represents an IBAN number, use Iban::fromString to enforce validation.
 * Class Iban
 * @package Hurah\Types\Type
 */
class LiteralCallable extends AbstractDataType implements IGenericDataType, ITestable
{
    private Closure $callable;

    function __construct($sValue = null) {
        if(!is_callable($sValue) && !is_null($sValue))
        {
            throw new InvalidArgumentException("Constructor must be null or callable");
        }
        $this->callable = $sValue;
        parent::__construct($sValue);
    }

    /**
     * Requires a callback function that accepts 1 required value, the subject and returns a boolean true when the
     * match is a success.
     *
     * @param Closure $callable
     *
     * @return LiteralCallable
     */
    public static function create(Closure $callable):self
    {
        $oSelf = new self();
        $oSelf->callable = $callable;
        return $oSelf;
    }

    public function __invoke(...$args)
    {
        return $this->callable->__invoke($args);
    }
    public function test(string $sSubject): bool
    {
        return $this->__invoke($sSubject);
    }


}
