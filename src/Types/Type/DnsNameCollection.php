<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\DnsName\Iterator;

class DnsNameCollection extends AbstractDataType implements IComplexDataType
{

    private int $position = 0;

    /***
     * PathCollection constructor.
     *
     * @param array $mValues - An array of strings[] or Path[], internally will all be converted to Paths.
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

    public function isEmpty():bool
    {
        return count($this->getValue()) === 0;
    }

    /**
     * @param $mValue
     * @throws InvalidArgumentException
     */
    public function add($mValue): void
    {
        if (is_string($mValue)) {
            $objectItem = DnsName::fromString($mValue);
        } else {
            if ($mValue instanceof DnsName) {
                $objectItem = $mValue;
            } else {
                throw new InvalidArgumentException("Only DnsName and strings are valid arguments.");
            }
        }

        $aValues = $this->getValue();
        $aValues[] = $objectItem;
        $this->setValue($aValues);
    }

    public function toArray(): array
    {
        return $this->getValue();
    }

    public function getIterator(): Iterator
    {
        return new Iterator($this);
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
