<?php

namespace Hurah\Types\Type;


use function is_iterable;

class KeyValueCollection extends AbstractCollectionDataType
{
    private array $unique;


    public static function fromArray(array $items): self
    {
        $oCollection = new self();

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

        return $oCollection;
    }

     public function current(): KeyValue
    {
        return $this->array[$this->position];
    }
    public function getOrCreate(string $sKey, ?string $sValue = null):?KeyValue
    {
        if(!$oKeyValue = $this->getByKey($sKey))
        {
            $oKeyValue = new KeyValue();
            $oKeyValue->setKey($sKey);
            $oKeyValue->setValue($sValue);
            $this->add($oKeyValue);
        }
        return $oKeyValue;
    }
    public function hasKey(string $sKey):bool
    {
        return $this->unique[$sKey];
    }
    public function hasKeyInsensitive(string $sKey):bool
    {
        return $this->getByKeyInsensitive($sKey) instanceof KeyValue;
    }

    public function getByKeyInsensitive(string $sKey):?KeyValue
    {
        $sKeyLc = strtolower($sKey);

        foreach($this->unique as $sItemKey => $sValue)
        {
            if(strtolower($sItemKey) == $sKeyLc)
            {
                return $sValue;
            }
        }

        return  null;
    }
    public function removeByKey(string $sKey):void
    {
        foreach ($this->unique as $itemKey => $value)
        {
            if($itemKey === $sKey)
            {
                unset($this->unique[$itemKey]);
            }
        }

        foreach ($this as $index => $keyValue)
        {
            if($sKey == $keyValue->getKey())
            {
                unset($this->array[$index]);
            }
        }

    }
    public function removeByKeyCaseInsensitive(string $sKey):void
    {
        $sKeyLc = strtolower($sKey);
        foreach ($this->unique as $sItemKey => $value)
        {
            if(strtolower($sItemKey) === $sKeyLc)
            {
                unset($this->unique);
            }
        }
        foreach ($this->array as $iIndex => $oItem)
        {
            if(!$oItem instanceof KeyValue)
            {
                continue;
            }
            if(strtolower($sKeyLc) === $oItem->getKey())
            {
                unset($this->array[$iIndex]);
            }
        }
    }
    public function getByKey(string $sKey, array $aOptions = []):?KeyValue
    {
        if(isset($aOptions['case_insensitive']))
        {
            return $this->getByKeyInsensitive($sKey);
        }
        return $this->unique[$sKey] ?? null;
    }
    public function add(KeyValue $oKeyValue)
    {
        $this->unique[$oKeyValue->getKey()] = $oKeyValue;
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
