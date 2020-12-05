<?php

namespace Hurah\Types\Type\Composer;

use Hurah\Types\Type\PlainText;
use Hurah\Types\Type\SystemId;

class ServiceName extends PlainText implements IComposerComponent {

    static function fromSystemId(SystemId $oSystemId) {
        return new self(explode('.', (string)$oSystemId)[1]);
    }

}
