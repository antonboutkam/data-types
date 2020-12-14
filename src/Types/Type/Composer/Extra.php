<?php

namespace Hurah\Types\Type\Composer;

use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\IComplexDataType;
use Hurah\Types\Type\IGenericDataType;

class Extra extends AbstractDataType implements IGenericDataType, IComplexDataType, IComposerComponent
{
    /**
     * @param null $aValue
     */
    public function __construct($aValue = null)
    {
        parent::__construct($aValue);
    }

    public function toArray(): array
    {
        return $this->getValue();
    }

    /**
     * @return array
     */
    public function getValue(): array
    {
        return parent::getValue();
    }

    public function __toString(): string
    {
        $aAuthor = $this->getValue();
        return json_encode($aAuthor);
    }
}
