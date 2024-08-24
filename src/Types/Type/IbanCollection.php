<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;


class IbanCollection extends AbstractCollectionDataType implements IGenericDataType
{
    protected int $position;
    protected array $array;

    /***
     * PathCollection constructor.
     *
     * @param null $mValues - An array of strings[] or DnsName[], internally will all be converted to DnsName.
     *
     * @throws InvalidArgumentException
     */
    public function __construct($mValues = null)
    {
        $this->position = 0;

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
     * @throws InvalidArgumentException
     */
    public static function fromArray(array ...$aIbanArrays): self
    {
        $oNewIbanCollection = new self();
        foreach ($aIbanArrays as $aIbanArray)
        {
			foreach($aIbanArray as $mIban)
			{
				$oNewIbanCollection->add($mIban);
			}

        }
        return $oNewIbanCollection;
    }

    /**
     * Creates a new combined collection based on the collections provided as arguments
     *
     * @param IbanCollection ...$IbanCollections
     *
     * @return IbanCollection
     * @throws InvalidArgumentException
     */
    public static function fromIbanCollections(IbanCollection ...$IbanCollections): self
    {
        $oNewIbanCollection = new self();
        foreach ($IbanCollections as $IbanCollection)
        {
            foreach ($IbanCollection as $file)
            {
                $oNewIbanCollection->add($file);
            }
        }
        return $oNewIbanCollection;
    }

    /**
     * Checks if this path is already in the collection
     *
     * @param Iban $iban
     *
     * @return bool
     */
    public function containsIban(Iban $iban): bool
    {
        foreach ($this as $fileComp)
        {
            if ("{$fileComp}" === "{$iban}")
            {
                return true;
            }
        }
        return false;
    }

	/**
	 * Append the items to the current collection
	 *
	 * @param IbanCollection ...$IbanCollections
	 *
	 * @return IbanCollection
	 * @throws InvalidArgumentException
	 */
    public function appendCollections(self ...$IbanCollections): self
    {
        foreach ($IbanCollections as $IbanCollection)
        {
            $this->appendCollection($IbanCollection);

        }
        return $this;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function appendCollection(IbanCollection $IbanCollection): self
    {
        foreach ($IbanCollection as $file)
        {
            $this->add($file);
        }
        return $this;
    }

	/**
	 * Creates a new PathCollection based on the current PathCollection and the collections provided as arguments.
	 *
	 * @param IbanCollection ...$IbanCollections
	 *
	 * @return IbanCollection
	 * @throws InvalidArgumentException
	 */
    public function merge(IbanCollection ...$IbanCollections): IbanCollection
    {
        return (clone $this)->appendCollections(...$IbanCollections);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function filter(ITestable $oTestable): IbanCollection
    {
        $oNewIbanCollection = parent::filter($oTestable);
        if ($oNewIbanCollection instanceof IbanCollection)
        {
            return $oNewIbanCollection;
        }
        throw new InvalidArgumentException("Return type issue");
    }

    /**
     * Creates a new IbanCollection with the Iban's in reverse order.
     *
     * @return IbanCollection
     * @throws InvalidArgumentException
     */
    public function reverse(): IbanCollection
    {
        $oIbanCollection = new self();
        $aReverseItems = array_reverse($this->array);
        foreach ($aReverseItems as $oPath)
        {
            $oIbanCollection->add($oPath);
        }
        return $oIbanCollection;
    }

	/**
	 * @throws InvalidArgumentException
	 * @return IbanCollection for fluent support
	 */
	public function addString(string $iban):self
	{
		$this->addIban(Iban::make($iban));
		return $this;
	}

	/**
	 * @param Iban $iban
	 *
	 * @return $this
	 */
	public function addIban(Iban $iban):self
	{
		$this->array[] = $iban;
		return $this;
	}

    /**
     * @param $mValue
     *
     * @throws InvalidArgumentException
     */
    public function add($mValue): void
    {
        if (is_string($mValue))
        {
            $this->addString($mValue);
        }
		elseif($mValue instanceof Iban)
		{
			$this->addIban($mValue);
		}
        else
        {
			throw new InvalidArgumentException("Only objects of type Iban and strings are supported.");
        }

    }


    /**
     * @return Path[]
     */
    public function toArray(): array
    {
        return $this->array;
    }

	/**
	 * Converts the elements of the collection to a comma-separated string representation
	 *
	 * @param string $encapsulation (optional) The encapsulation character to be used for each element (default is double quotes)
	 *
	 * @return string The comma-separated string representation of the collection
	 */
	public function toCommaSeparated(string $encapsulation = '"'): string
	{
		$aOut = [];
		foreach($this as $iban)
		{
			$aOut[] =  "{$encapsulation}" . $iban . "{$encapsulation}";
		}
		return join(',', $aOut);
	}
    public function __toString(): string
    {
        $aOut = [];
        foreach ($this->array as $oPath)
        {
            $aOut[] = (string)$oPath;
        }
        return join(',', $aOut);
    }

     public function current(): Iban
    {
        return $this->array[$this->position];
    }


}
