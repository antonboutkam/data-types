<?php

namespace Hurah\Types\Util;

use Hurah\Types\Exception\RuntimeException;
use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\TypeType;
use Hurah\Types\Type\Unknown;

class Detector
{

    /**
     * @throws RuntimeException
     */
    public function getType($mVariable): TypeType
    {
        if ($mVariable instanceof AbstractDataType)
        {
            return new TypeType(get_class($mVariable));
        }
        return new TypeType(Unknown::class);

    }
}