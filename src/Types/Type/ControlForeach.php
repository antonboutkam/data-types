<?php

namespace Hurah\Types\Type;

use Closure;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Util\JsonUtils;
use function is_iterable;
use function is_null;

class ControlForeach extends AbstractDataType implements IGenericDataType
{

    private $mValue;

    public function __construct($sValue = null)
    {
        if(!is_iterable($sValue) && !is_null($sValue))
        {
            throw new InvalidArgumentException("Value must be iterable or null");
        }
        $this->mValue  = $sValue;

        parent::__construct($sValue);
    }

    public static function fromCollection(AbstractCollectionDataType $oCollection):self
    {
        return new self($oCollection);
    }
    public static function fromArray(array $aData):self
    {
        return new self($aData);
    }

    /**
     * Callback should have 2 params, one for the key and the other for the value of the loopt. Probably the passed
     * arguments should be by reference.
     *
     * @param LiteralCallable $closure
     */
    public function loop(LiteralCallable $closure)
    {
        foreach($this as $id => $that)
        {
            $closure($id, $that);
        }
    }
    public function __toString(): string
    {
        return JsonUtils::encode($this->mValue);
    }

    public function setValue($sValue)
    {
        $this->mValue = $sValue;
    }

    public function getValue()
    {
        return $this->mValue;
    }
}