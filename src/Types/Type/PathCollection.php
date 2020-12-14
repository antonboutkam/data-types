<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\ClassNotFoundException;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\PathCollection\Iterator;

class PathCollection extends AbstractDataType implements IGenericDataType
{
    private int $position;

    /***
     * PathCollection constructor.
     *
     * @param null $mValues - An array of strings[] or DnsName[], internally will all be converted to DnsName.
     * @throws InvalidArgumentException
     * @throws ClassNotFoundException
     */
    public function __construct($mValues = null)
    {
        $this->position = 0;

        parent::__construct([]);

        if (is_array($mValues)) {
            foreach ($mValues as $mValue) {
                $this->add($mValue);
            }
        }
    }

    /**
     * @param $mValue
     * @throws InvalidArgumentException
     */
    public function add($mValue): void
    {
        if (is_string($mValue)) {
            $objectItem = new Path($mValue);
        } else {
            if ($mValue instanceof Path) {
                $objectItem = $mValue;
            } else {
                throw new InvalidArgumentException("Argument must be of type string or " . DnsName::class);
            }
        }

        $aValues = $this->getValue();
        $aValues[] = $objectItem;
        $this->setValue($aValues);
    }

    /**
     * @return DnsName[]
     */
    public function toArray(): array
    {
        return $this->getValue();
    }

    public function getIterator(): Iterator
    {
        return new PathCollection\Iterator($this);
    }

    public function __toString(): string
    {
        $aOut = [];
        foreach ($this->getValue() as $oPath) {
            $aOut[] = (string)$oPath;
        }
        return join(',', $aOut);
    }
}
