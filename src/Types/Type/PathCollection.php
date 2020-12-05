<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\ClassNotFoundException;
use Hurah\Types\Type\PathCollection\Iterator;

class PathCollection extends AbstractDataType implements IGenericDataType {
    private int $position = 0;

    /***
     * PathCollection constructor.
     *
     * @param array $mValues - An array of strings[] or Path[], internally will all be converted to Paths.
     */
    function __construct($mValues = null) {
        $this->position = 0;

        parent::__construct([]);

        if (is_array($mValues)) {
            foreach ($mValues as $mValue) {
                $this->add($mValue);
            }
        }
    }

    function add($mValue): void {
        if (is_string($mValue)) {
            $objectItem = new Path($mValue);
        } else {
            if ($mValue instanceof Path) {
                $objectItem = $mValue;
            } else {
                throw new ClassNotFoundException("Only Paths and strings may be added.");
            }
        }

        $aValues = $this->getValue();
        $aValues[] = $objectItem;
        $this->setValue($aValues);
    }

    function toArray(): array {
        return $this->getValue();
    }

    function getIterator(): Iterator {
        return new PathCollection\Iterator($this);
    }

    public function __toString(): string {
        $aOut = [];
        foreach ($this->getValue() as $oPath) {
            $aOut[] = (string)$oPath;
        }
        return join(',', $aOut);
    }

}
