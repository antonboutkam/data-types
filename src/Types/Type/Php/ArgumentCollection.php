<?php

namespace Hurah\Types\Type\Php;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\AbstractCollectionDataType;
use Hurah\Types\Type\IComplexDataType;

class ArgumentCollection extends AbstractCollectionDataType implements IComplexDataType
{

    protected int $position;
    protected array $array;

    /**
     * ArgumentCollection constructor.
     * @param null $mValues
     * @throws InvalidArgumentException
     */
    public function __construct($mValues = null)
    {
        parent::__construct([]);

        if (is_array($mValues))
        {
            foreach ($mValues as $mValue)
            {
                $this->add($mValue);
            }
        }
    }

    /**
     * @param Argument $mValue
     * @return self
     */
    public function add(Argument $mValue): self
    {
        $this->array[] = $mValue;
        return $this;
    }

    /**
     * @return Argument
     */
    public function current(): Argument
    {
        return $this->array[$this->position];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $aOut = [];
        foreach ($this as $item)
        {
            $aOut[] = $item->toArray();
        }
        return $aOut;
    }
}
