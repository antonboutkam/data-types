<?php

namespace Hurah\Types\Type\Html;

/**
 * When a datatype implements this interface it is directly convertible to a html element. For instance an icon
 *
 * Interface IElementizable
 * @package Hurah\Types\Type\Html
 */
interface IElementizable {

    public function toElement(): Element;
}
