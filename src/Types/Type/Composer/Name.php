<?php

namespace Hurah\Types\Type\Composer;

use Hurah\Types\Type\Name as BaseName;

class Name extends BaseName implements IAuthorComponent, IComposerComponent
{
    public function getVendor(): Vendor
    {
        return new Vendor(explode('/', $this->getValue())[0]);
    }

    public function getProjectName(): string
    {
        return explode('/', $this->getValue())[1];
    }

    public function toArray(): array
    {
        return [$this->getKey() => $this->getValue()];
    }

    public function getKey(): string
    {
        return 'name';
    }
}
