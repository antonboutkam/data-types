<?php

namespace Hurah\Types\Type\DnsName;

use Hurah\Types\Type\DnsName;
use Hurah\Types\Type\DnsNameCollection;
use Hurah\Types\Util\BaseIterator;

class Iterator extends BaseIterator
{

    /***
     * PathCollection constructor.
     *
     * @param DnsNameCollection $oDnsNameCollection
     */
    public function __construct(DnsNameCollection $oDnsNameCollection)
    {
        $this->array = $oDnsNameCollection->toArray();
        $this->position = 0;
    }

    public function current(): DnsName
    {
        return $this->array[$this->position];
    }
}
