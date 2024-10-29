<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\Helper\Loop;
use Hurah\Types\Util\JsonUtils;
use function is_iterable;
use function is_null;

class ControlForeach extends AbstractDataType implements IGenericDataType
{

    private $mValue;

    public function __construct($sValue = null)
    {
        if(!is_iterable($sValue) && !is_null($sValue))
        {
            throw new InvalidArgumentException("Value must be iterable or null");
        }
        $this->mValue  = $sValue;

        parent::__construct($sValue);
    }

    public static function fromCollection(AbstractCollectionDataType $oCollection):self
    {
        return new self($oCollection);
    }
    public static function fromArray(array $aData):self
    {
        return new self($aData);
    }

    /**
     * Callback should have 2 params, one for the key and the other for the value of the loopt. Probably the passed
     * arguments should be by reference.
     *
     * @param LiteralCallable $closure
     */
    public function loop(LiteralCallable $closure)
    {
        $oLoop = new Loop($this->mValue);

        // print_r($this->mValue);
        foreach($this->mValue as $item)
        {
            $closure($item, $oLoop->next());
        }
    }

	/**
	 * @throws InvalidArgumentException
	 */
	public function __toString(): string
    {
        return JsonUtils::encode($this->mValue);
    }

    public function setValue($sValue): AbstractDataType
	{
        $this->mValue = $sValue;
		return $this;
    }

    public function getValue()
    {
        return $this->mValue;
    }
}
