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
    protected array $array = [];

     abstract public function current(): mixed;

	 /**
	  * Reset the internal pointer
	  */
    public function rewind():void
    {
        $this->position = 0;
    }


    /**
     * Returns a new collection containing the filtered results
     *
     * @param ITestable $oTestable
     *
     * @return $this
     */
    public function filter(ITestable $oTestable):AbstractCollectionDataType
    {
        $oFilteredInstance = new static;

        foreach ($this as $item)
        {
            if($oTestable->test($item))
            {
                $oFilteredInstance->add($item);
            }
        }
        return $oFilteredInstance;
    }


	/**
	 * @param LiteralCallable $oCallback
	 *
	 * @return void
	 */
    public function doForeach(LiteralCallable $oCallback): void
    {
        $oForeach = ControlForeach::fromCollection($this);
        $oForeach->loop($oCallback);
    }

    public function key():int
    {
        return $this->position;
    }

    public function next():void
    {
        ++$this->position;
    }
    public function toArray():array
    {
        return $this->array;
    }

    public function toLiteralArray():LiteralArray
    {
        return LiteralArray::create($this->array);
    }

    public function toSequentialCollection():SequentialCollection
    {
        return new SequentialCollection($this);
    }

    public function valid():bool
    {
        return isset($this->array[$this->position]);
    }

    public function offsetSet($offset, $value):void
    {
        if (is_null($offset)) {
            $this->array[] = $value;
        } else {
            $this->array[$offset] = $value;
        }
    }

    public function isEmpty():bool
    {
        return empty($this->array);
    }
    public function isFirst():bool
    {
        return $this->position === 0;
    }

    public function isLast():bool
    {
        return isset($this->array[$this->position+1]);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->array[$offset]);
    }

    public function offsetUnset($offset):void
    {
        unset($this->array[$offset]);
    }

    public function offsetGet($offset):mixed
    {
        return $this->array[$offset] ?? null;
    }
    public function length():int
    {
        return count($this->array);
    }

}
