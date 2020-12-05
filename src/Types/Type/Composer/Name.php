<?php

namespace Hurah\Types\Type\Composer;

use Hurah\Types\Type\Name as BaseName;

class Name extends BaseName implements IAuthorComponent, IComposerComponent {
    function getVendor(): Vendor {
        return new Vendor(explode('/', $this->getValue())[0]);
    }

    function getProjectName(): string {
        return explode('/', $this->getValue())[1];
    }

    function toArray(): array {
        return [$this->getKey() => $this->getValue()];
    }

    function getKey(): string {
        return 'name';
    }
}
