<?php

namespace Hurah\Types\Type;

use Iterator;

abstract class AbstractCollectionDataType extends AbstractDataType implements IGenericDataType, Iterator
{
    protected int $position = 0;
    protected array $array;

    abstract public function current();

    public function rewind() {
        $this->position = 0;
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        ++$this->position;
    }

    public function valid() {
        return isset($this->array[$this->position]);
    }
}
