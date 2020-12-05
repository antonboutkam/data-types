<?php

namespace Hurah\Types\Type;

use Hurah\Types\Util\JsonUtils;

class Json extends AbstractDataType implements IGenericDataType {
    function __construct($mValue = null) {
        if (is_array($mValue) || is_object($mValue)) {
            $mValue = JsonUtils::encode($mValue, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        parent::__construct($mValue);
    }

    public function getValue() {
        return parent::getValue();
    }
}
