<?php
namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;

class SmsBody extends AbstractDataType implements IGenericDataType
{
    function __construct($sPathName = null) {
        if (strlen($sPathName) > 160) {
            throw new InvalidArgumentException("Message length exeeds 160 chars, 160 is the max for SMS");
        }
        parent::__construct($sPathName);
    }
}
