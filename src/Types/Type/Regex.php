<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;

/**
 * Represents a regular expression
 * @package Hurah\Type
 */
class Regex extends AbstractDataType implements IGenericDataType, ITestable
{

    function __construct($sValue = null)
    {
        parent::__construct($sValue);
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
    public function isValid(): bool
    {
        if (@preg_match("{$this}", '') === false && error_get_last()['line'] === __LINE__) {
            return false;
        }
        return true;
    }

    /**
     * @param string $sSubject
     * @param string $sReplacement
     * @return PlainText
     * @throws InvalidArgumentException
     */
    public function replace(string $sSubject, string $sReplacement): PlainText
    {
        $sResult = preg_replace("{$this}", $sReplacement, $sSubject);
        return new PlainText($sResult);
    }

    /**
     * @param string $sSubject
     * @return PlainText
     * @throws InvalidArgumentException
     */
    public function remove(string $sSubject): PlainText
    {
        return new PlainText(preg_replace("{$this}", $sSubject, ''));
    }

    public function test($sSubject): bool
    {
        return preg_match("{$this}", $sSubject);
    }

    public function getMatches(string $sSubject): array
    {
        $aMatches = [];
        preg_match("{$this}", $sSubject, $aMatches);
        return $aMatches;
    }

}
