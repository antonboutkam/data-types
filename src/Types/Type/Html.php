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
        $oTidy = new Tidy();

        $config = [
            'indent'         => true,
            'output-html'    => true,
            'doctype'        => 'omit',
            'show-body-only' => true,
            'wrap'           => 120,
        ];

        $oTidy->parseString(trim((string)$this->getValue()), $config, 'utf8');
        $oTidy->cleanRepair();

        return "{$oTidy}";
    }
}
