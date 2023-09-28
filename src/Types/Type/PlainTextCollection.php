<?php

namespace Hurah\Types\Type;

use ReturnTypeWillChange;

class PlainTextCollection extends AbstractCollectionDataType
{
    public function add(PlainText $oPlainText)
    {
        $this->array[] = $oPlainText;
    }

    #[ReturnTypeWillChange] public function current():PlainText
    {
        return $this->array[$this->position];
    }
}