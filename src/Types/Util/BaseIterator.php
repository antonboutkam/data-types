<?php

namespace Hurah\Types\Util;

use Iterator as PhpIterator;

/**
 * Implements the php iterator except for the methods that return a type so it is easy to loop over objects in a
 * strongly typed way.
 *
 * Class BaseIterator
 */
abstract class BaseIterator implements PhpIterator {
    protected int $position;
    protected array $array;

    abstract public function current(): mixed;

    public function rewind() :void {
        $this->position = 0;
    }

    public function key() : int
	{
        return $this->position;
    }

    public function next() :void {
        ++$this->position;
    }

    public function valid() :bool {
        return isset($this->array[$this->position]);
    }
}
