<?php

namespace Hurah\Types\Type\Composer;

class Email extends \Hurah\Types\Type\Email implements IAuthorComponent, IComposerComponent
{

    public function toArray(): array
    {
        return [$this->getKey() => $this->getValue()];
    }

    public function getKey(): string
    {
        return 'email';
    }
}
