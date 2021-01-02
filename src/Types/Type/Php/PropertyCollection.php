<?php

namespace Hurah\Types\Type\Php;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\AbstractCollectionDataType;
use Hurah\Types\Type\IComplexDataType;

class PropertyCollection extends AbstractCollectionDataType implements IComplexDataType
{

    protected int $position;
    protected array $array;

    /**
     * PropertyCollection constructor.
     * @param null $mValues
     * @throws InvalidArgumentException
     */
    public function __construct($mValues = null)
    {
        parent::__construct([]);

        if(!$mValues)
        {
            return;
        }

        if (is_array($mValues))
        {
            foreach ($mValues as $mValue)
            {
                $this->add($mValue);
            }
        }
        elseif($mValues instanceof Property)
        {
            $this->add($mValues);
        }
        elseif ($mValues instanceof PropertyCollection)
        {
            foreach ($mValues as $mValue)
            {
                $this->add($mValue);
            }
        }
        else
        {
            throw new InvalidArgumentException("Variable \$mValues is of an unsupported type");
        }
    }

    /**
     * @param Property $mValue
     */
    public function add(Property $mValue): self
    {
        $this->array[] = $mValue;
        return $this;
    }

    public function current(): Property
    {
        return $this->array[$this->position];
    }

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
