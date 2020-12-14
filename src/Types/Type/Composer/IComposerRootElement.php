<?php

namespace Hurah\Types\Type\Composer;

interface IComposerRootElement
{
    public function getKey(): string;

    public function getValue();
}
