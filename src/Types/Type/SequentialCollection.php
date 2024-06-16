<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\RuntimeException;

class SequentialCollection extends AbstractCollectionDataType
{
	/**
	 * @param mixed $sValue expects null, an array, an instance of LiteralArray or an instance of  AbstractCollectionDataType
	 */
	public function __construct($sValue = null)
	{
		if (is_array($sValue)) {
			$this->addArray($sValue);
		}
		elseif ($sValue instanceof LiteralArray) {
			$this->addArray($sValue->toArray());
		}
		elseif ($sValue instanceof AbstractCollectionDataType) {
			$this->addArray($sValue->toArray());
		}
		parent::__construct($sValue);
	}

	public function toArray():array
	{
		return $this->array;
	}
	/**
	 * @throws RuntimeException
	 */
	public function current(): AbstractDataType
	{
		$item =  $this->array[$this->position];

		if ($item instanceof AbstractDataType) {
			$this->array[] = $item;
		}
		elseif (is_string($item)) {
			$result = new PlainText($item);
		}
		elseif (is_float($item)) {
			$result = new LiteralFloat($item);
		}
		elseif (is_array($item)) {
			$result = new LiteralArray($item);
		}
		elseif (is_float($item)) {
			$result = new LiteralFloat($item);
		}
		elseif (is_int($item)) {
			$result = new LiteralInteger($item);
		}
		else
		{
			throw new RuntimeException("Unable to cast SequentialCollection item to IGenericDataType");
		}

		return $result;
	}

	public function addArray(array $aItems): self
	{
		$oSelf = clone($this);
		foreach ($aItems as $mItem) {
			$oSelf->addAny($mItem);
		}

		return $oSelf;

	}

	public function addAny($item): void
	{
		$this->array[] = $item;
	}

    public function add(IGenericDataType $item): void
	{
        $this->addAny($item);
    }

    public function getUnique(): self
    {
        $aItems = array_unique($this->array);

		return (new self())->addArray($aItems);
    }

    public function splat(...$fieldOrMethod):self
    {
        $sKey = array_shift($fieldOrMethod);
        $out = [];
        foreach ($this as $item)
        {
            if(isset($item[$sKey]))
            {
                $mValue = $item[$sKey];
            }
            elseif(is_object($item) && method_exists($item, $sKey))
            {
                $mValue = $item->$sKey();
            }

            if(isset($mValue))
            {
                $out[] = $mValue;
            }
        }
        return new self($out ?? []);
    }

	public function __toString(): string
	{
		return (string) json_encode($this->getValue());
	}
}
