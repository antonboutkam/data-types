<?php

namespace Hurah\Types\Type\PathCollection;

use Hurah\Types\Type\Path;
use Hurah\Types\Type\PathCollection;
use Hurah\Types\Util\BaseIterator;

class Iterator extends BaseIterator {

    /***
     * PathCollection constructor.
     *
     * @param PathCollection $oPathCollection
     */
    function __construct(PathCollection $oPathCollection) {
        $this->array = $oPathCollection->toArray();
        $this->position = 0;
    }

    public function current(): Path {
        return $this->array[$this->position];
    }
}
