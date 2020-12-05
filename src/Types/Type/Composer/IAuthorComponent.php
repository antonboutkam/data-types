<?php

namespace Hurah\Types\Type\Composer;

use Hurah\Types\Type\IComplexDataType;

interface IAuthorComponent extends IComplexDataType {
    function getKey(): string;

    public function getValue();
}
