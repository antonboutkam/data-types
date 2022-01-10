<?php

namespace Hurah\Types\Type;

use function is_iterable;

class KeyValueCollection extends AbstractCollectionDataType
{
    private array $unique;

    public static function fromArray(array $items): self
    {
        $oCollection = new self();
        if (is_iterable($items))
        {
            foreach ($items as $itemIndex => $item)
            {
                if ($item instanceof KeyValue)
                {
                    $oCollection->add($item);
                }
                else
                {
                    $oCollection->addKeyValue($itemIndex, $item);
                }
            }
        }
        return $oCollection;
    }

    public function current(): KeyValue
    {
        return $this->array[$this->position];
    }

    public function add(KeyValue $oKeyValue)
    {
        $this->unique[$oKeyValue->getKey()] = $oKeyValue->getValue();
        $this->array[] = $oKeyValue;
    }

    public function addKeyValue(string $sKey, $value)
    {
        $this->add(KeyValue::create($sKey, $value));
    }

    public function getUnique(): self
    {
        return self::fromArray($this->unique);
    }
}