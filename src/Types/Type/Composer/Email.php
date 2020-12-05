<?php

namespace Hurah\Types\Type\Composer;

class Email extends \Hurah\Types\Type\Email implements IAuthorComponent, IComposerComponent {

    function toArray(): array {
        return [$this->getKey() => $this->getValue()];
    }

    function getKey(): string {
        return 'email';
    }

}
