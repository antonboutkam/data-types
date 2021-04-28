<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;

/**
 * Represents a regular expression
 * @package Hurah\Type
 */
class Regex extends AbstractDataType implements IGenericDataType
{

    function __construct($sValue = null)
    {
        parent::__construct($sValue);
    }

    /**
     * @param string $sRegex
     * @return $this
     * @throws InvalidArgumentException
     */
    public static function fromString(string $sRegex): self
    {
        return new self($sRegex);
    }

    /**
     * Checks of the regular expression is valid / not broken.
     * @return bool
     */
    public function isValid():bool
    {
        if(@preg_match("{$this}", '') === false && error_get_last()['line'] === __LINE__)
        {
            return false;
        }
        return true;
    }

    /**
     * @param PlainText $oRegex
     * @return static
     * @throws InvalidArgumentException
     */
    public static function fromPlainText(PlainText $oRegex): self
    {
        return self::fromString("{$oRegex}");
    }

    public function test(string $sSubject)
    {
        return preg_match("{$this}", $sSubject);
    }
    public function getMatches(string $sSubject):array
    {
        $aMatches = [];
        preg_match("{$this}", $sSubject, $aMatches);
        return $aMatches;
    }

}
