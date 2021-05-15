<?php
namespace Hurah\Types\Type;

use Hurah\Types\Type\Contracts\IScalarValue;

class LiteralFloat extends AbstractDataType implements IGenericDataType, IScalarValue
{
    public function asFloat():float
    {
        return (float) $this->getValue();
    }
}
