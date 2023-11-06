<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;

/**
 * Represents an BIC number, use Bic::fromString to enforce validation.
 * Class Bic
 * @package Hurah\Types\Type
 */
class Bic extends AbstractDataType implements IGenericDataType, ITestable
{
    function __construct($sValue = null) {
		$sValue = preg_replace('/\s/', '', $sValue);
        parent::__construct($sValue);
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function make(string $sBic): self
    {
        return self::fromString($sBic);
    }
    /**
     * @param string $sIban
     * @return static
     * @throws InvalidArgumentException
     * @deprecated use Iban::make()
     */
    static function fromString(string $sBic) : self {

        $oBic = new self($sBic);
        if(!$oBic->isValid())
        {
            throw new InvalidArgumentException("Invalid BIC: $sBic");
        }
        return $oBic;
    }

    function isValid():bool
    {
        $bic = $this->getValue();
		return $this->test($bic);
    }

	public static function getRegex():Regex
	{
		return new Regex('/^[a-z]{6}[0-9a-z]{2}([0-9a-z]{3})?\z/i');
	}
	public function test($sSubject): bool
	{
		return self::getRegex()->test($sSubject);
	}
}
