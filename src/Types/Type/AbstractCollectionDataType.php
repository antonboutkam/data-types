<?php

namespace Hurah\Types\Type;

use ArrayAccess;
use Iterator;

/**
 * Provides an easy way to handle collections of object as array's
 *
 * Class AbstractCollectionDataType
 * @package Hurah\Types\Type
 */
abstract class AbstractCollectionDataType extends AbstractDataType implements IGenericDataType, Iterator, ArrayAccess
{
    protected int $position = 0;
    protected array $array;

    abstract public function current();

    public function rewind()
    {
        $this->position = 0;
    }

    public function key():int
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid():bool
    {
        return isset($this->array[$this->position]);
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->array[] = $value;
        } else {
            $this->array[$offset] = $value;
        }
    }

    public function offsetExists($offset): bool
    {
        return isset($this->array[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->array[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->array[$offset]) ? $this->array[$offset] : null;
    }
}
