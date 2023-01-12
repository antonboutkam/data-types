<?php

namespace Hurah\Types\Type;

use DOMDocument;

/**
 * Represents a string, but string is a reserved keyword
 * Class Html
 * @package Hurah\Type
 */
class Html extends PlainText {

    public function asPlainText():PlainText
    {
        return new PlainText($this->stripTags()->getValue());
    }
    public function stripTags():self
    {
        return new self(strip_tags($this->getValue()));
    }
    public function __toString(): string {

        $x = new DOMDocument();
        $x->preserveWhiteSpace = true;
        $x->formatOutput = true;

        $x->loadXML(trim((string)$this->getValue()), LIBXML_NOXMLDECL | LIBXML_HTML_NODEFDTD | LIBXML_NOEMPTYTAG);
        $sHtml = $x->saveXML($x->documentElement, LIBXML_NOEMPTYTAG | LIBXML_HTML_NODEFDTD | LIBXML_NOEMPTYTAG);
        return $sHtml;

    }
}
