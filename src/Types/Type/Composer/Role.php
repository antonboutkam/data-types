<?php

namespace Hurah\Types\Type\Composer;

class Role extends \Hurah\Types\Type\Name implements IAuthorComponent, IComposerComponent {
    function toArray(): array {
        return [$this->getKey() => $this->getValue()];
    }

    function getKey(): string {
        return 'role';
    }

}
