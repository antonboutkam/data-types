<?php

namespace Hurah\Types\Type;

use Tidy;

/**
 * Represents a string, but string is a reserved keyword
 * Class PlainText
 * @package Hurah\Type
 */
class Html extends PlainText {

    public function __toString(): string {

        return trim((string)$this->getValue());
    }
}
