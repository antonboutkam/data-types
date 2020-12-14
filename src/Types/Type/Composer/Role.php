<?php

namespace Hurah\Types\Type\Composer;

class Role extends \Hurah\Types\Type\Name implements IAuthorComponent, IComposerComponent
{
    public function toArray(): array
    {
        return [$this->getKey() => $this->getValue()];
    }

    public function getKey(): string
    {
        return 'role';
    }
}
