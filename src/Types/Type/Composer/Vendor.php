<?php

namespace Hurah\Types\Type\Composer;

use Hurah\Types\Type\PlainText;
use Hurah\Types\Type\SystemId;

class Vendor extends PlainText implements IComposerComponent
{

    public static function fromSystemId(SystemId $oSystemId)
    {
        return new self(explode('.', (string)$oSystemId)[0]);
    }
}
