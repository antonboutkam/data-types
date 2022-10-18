<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\Contracts\IScalarValue;

class LiteralArray extends AbstractDataType implements IComplexDataType, IScalarValue
{
    public static function create(array $aInput):self
    {
        $oSelf = new self();
        $oSelf->setValue($aInput);
        return $oSelf;
    }

    public function toArray(): array
    {
        return $this->getValue();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function toJson():Json
    {
        return new Json($this->getValue());
    }
    public function toCollection():SequentialCollection
    {
        return new SequentialCollection($this->getValue());
    }
    public function splat(...$fieldOrMethod):LiteralArray
    {
        return new LiteralArray($this->toCollection()->splat(...$fieldOrMethod)->toArray());
    }

}
