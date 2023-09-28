<?php

namespace Hurah\Types\Type;



class PlainTextCollection extends AbstractCollectionDataType
{
    public function add(PlainText $oPlainText)
    {
        $this->array[] = $oPlainText;
    }

     public function current():PlainText
    {
        return $this->array[$this->position];
    }
}
