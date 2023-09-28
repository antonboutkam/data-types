<?php

namespace Hurah\Types\Type;

use Hurah\Types\Type\Http\Response;
use InvalidArgumentException;
use ReturnTypeWillChange;

class UrlCollection extends AbstractCollectionDataType
{
    public function add(Url $oUrl)
    {
        $this->array[] = $oUrl;
    }

    #[ReturnTypeWillChange] public function current(): Url
    {
        return $this->array[$this->position];
    }
}
