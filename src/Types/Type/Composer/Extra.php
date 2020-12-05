<?php

namespace Hurah\Types\Type\Composer;

use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\IComplexDataType;
use Hurah\Types\Type\IGenericDataType;

class Extra extends AbstractDataType implements IGenericDataType, IComplexDataType, IComposerComponent {
    /**
     * @param null $aValue
     */
    function __construct($aValue = null) {
        parent::__construct($aValue);
    }

    function toArray(): array {
        return $this->getValue();
    }

    /**
     * @return array
     */
    function getValue(): array {
        return parent::getValue();
    }

    function __toString(): string {
        $aAuthor = $this->getValue();
        return json_encode($aAuthor);
    }

}
