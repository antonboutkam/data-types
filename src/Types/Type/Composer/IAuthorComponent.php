<?php

namespace Hurah\Types\Type\Composer;

use Hurah\Types\Type\IComplexDataType;

interface IAuthorComponent extends IComplexDataType
{
    public function getKey(): string;

    public function getValue();
}
