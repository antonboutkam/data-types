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
        $x->preserveWhiteSpace = true;
        $x->formatOutput = true;

        $x->loadXML(trim((string)$this->getValue()), LIBXML_NOXMLDECL | LIBXML_HTML_NODEFDTD | LIBXML_NOEMPTYTAG);
        $sHtml = $x->saveXML($x);
        // dirty way to remove the first xml line and get formatted html, fix this in the future / when it becomes
        // problemistic
        $sHtml = preg_replace('/^.+\n/', '', $sHtml);
        return $sHtml;

    }
}
