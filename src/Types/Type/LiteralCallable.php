<?php

namespace Hurah\Types\Type;

use Closure;
use Hurah\Types\Exception\InvalidArgumentException;
use function is_callable;
use function is_null;

/**
 * Represents a piece of logic such as an event or a test,
 * Class LiteralCallable
 * @package Hurah\Types\Type
 */
class LiteralCallable extends AbstractDataType implements IGenericDataType, ITestable
{
    private Closure $callable;

    function __construct($sValue = null) {

        if($sValue instanceof Closure)
        {
            $this->callable = $sValue;
        }
        elseif(!is_null($sValue))
        {
            throw new InvalidArgumentException("Constructor of LiteralCallable must be of type Closure or null");
        }
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
        // $args[0] An item from the collection that we are looping over.
        // $args[1] the Loop helper.
        return $this->callable->__invoke($args[0], $args[1] ?? null);
    }
    public function test($sSubject): bool
    {
        return $this->__invoke($sSubject);
    }


}
