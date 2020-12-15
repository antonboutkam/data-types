<?php

namespace Hurah\Types\Type;

use DOMDocument;

/**
 * Represents a string, but string is a reserved keyword
 * Class PlainText
 * @package Hurah\Type
 */
class Html extends PlainText {

    public function __toString(): string {

        $x = new DOMDocument();
        $x->loadHTML(trim((string)$this->getValue()));
        return $x->saveHTML();

    }
}
