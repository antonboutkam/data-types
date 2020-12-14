<?php

namespace Hurah\Types\Type\Composer;

class Url extends \Hurah\Types\Type\Url implements IAuthorComponent, IComposerComponent
{
    public function getKey(): string
    {
        return 'url';
    }

    public function toArray(): array
    {
        // TODO: Implement toArray() method.
    }
}
