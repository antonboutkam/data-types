<?php

namespace Hurah\Types\Type\Composer;

class Url extends \Hurah\Types\Type\Url implements IAuthorComponent, IComposerComponent {
    function getKey(): string {
        return 'url';
    }

    function toArray(): array {
        // TODO: Implement toArray() method.
    }
}
