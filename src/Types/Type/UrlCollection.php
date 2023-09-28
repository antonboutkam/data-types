<?php

namespace Hurah\Types\Type;

use Hurah\Types\Type\Http\Response;
use InvalidArgumentException;


class UrlCollection extends AbstractCollectionDataType
{
    public function add(Url $oUrl)
    {
        $this->array[] = $oUrl;
    }

     public function current(): Url
    {
        return $this->array[$this->position];
    }
}
