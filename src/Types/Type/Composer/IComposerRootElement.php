<?php

namespace Hurah\Types\Type\Composer;

interface IComposerRootElement {
    function getKey(): string;

    function getValue();
}
