<?php

namespace Hurah\Types\Type;

use Exception;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Util\JsonUtils;
use PhpParser\Node\Scalar\MagicConst\Namespace_;
use function str_replace;


/**
 * Represents a string, but string is a reserved keyword
 * Class PlainText
 * @package Hurah\Type
 */
class PlainText extends AbstractDataType implements IGenericDataType
{
    /**
     * @return Json
     * @throws InvalidArgumentException
     */
    public function toJson(): Json
    {
        try
        {
            $aJsonData = JsonUtils::decode($this->getValue(), true);
            return new Json($aJsonData);
        }
        catch (Exception $e)
        {
            throw new InvalidArgumentException("PlainText does not contain a valid JSON string");
        }
    }

    public function addLn(string $data): self
    {
        $this->setValue($this->getValue() . $data . PHP_EOL);
        return $this;
    }

    /**
     * Creates a new PlainText object with the strin in uppercase, this object is not changed.
     *
     * @return PlainText
     * @throws InvalidArgumentException
     */
    public function uppercase(): PlainText
    {
        return new PlainText(strtoupper($this->getValue()));
    }

    public function equals(string $string): bool
    {
        return $this->getValue() === $string;
    }

    public function equalsIgnoreCase(string $string): bool
    {
        return "{$this->lowercase()}" === strtolower($string);
    }

    /**
     * Creates a new PlainText object with the string in lowercase, this object is not changed.
     *
     * @return PlainText
     * @throws InvalidArgumentException
     */
    public function lowercase(): PlainText
    {
        return new PlainText(strtolower($this->getValue()));
    }

    public function asInt(): int
    {
        return (int)"{$this}";
    }

    public function asPhpNamespace():PhpNamespace
    {
        return PhpNamespace::make($this->getValue());
    }
    public function asPath():Path
    {
        return Path::make($this->getValue());
    }

    public function toCameCase(): self
    {
        $string = "{$this}";
        $string = str_replace('-', ' ', $string);
        $string = str_replace('_', ' ', $string);
        $string = ucwords($string);
        $string = str_replace(' ', '', $string);

        return new PlainText($string);
    }

    public function prepend(...$data)
    {
        foreach ($data as $part)
        {
            if (is_array($part))
            {
                $this->append(...$part);
            }
            else
            {
                $this->setValue($part . $this->getValue());
            }
        }
    }


    public function trim(string $characters = " \t\n\r\0\x0B"): self
    {
        return new self(trim($this, $characters));
    }

    public function append(...$data): self
    {
        foreach ($data as $part) {
            if (is_array($part)) {
                $this->append(...$part);
            } else {
                $this->setValue($this->getValue() . $part);
            }
        }
        return $this;
    }

    /**
     * Checks if the text contains the text passed as the argument.
     * @param Regex|Tag|RegexCollection|TagCollection|ITestable $oRegex
     * @return bool
     */
    public function matches(ITestable $oTestable): bool
    {
        return $oTestable->test("{$this}");
    }

    /**
     * Checks if the text contains the text passed as the argument.
     * @param AbstractDataType $oSearch can be any of the datatype objects, if $oSearch is a Regex type it will be
     * applied
     * @param PlainText $oReplacement
     * @return PlainText
     * @throws InvalidArgumentException
     */
    public function replace(AbstractDataType $oSearch, PlainText $oReplacement): PlainText
    {
        if($oSearch instanceof AbstractCollectionDataType)
        {
            $mCurrentValue = $this->getValue();
            $oSearchCollection = $oSearch;
            foreach($oSearchCollection as $oSearchItem)
            {
                if ($oSearchItem instanceof Regex) {
                    $mCurrentValue = preg_replace("{$oSearchItem}", "{$oReplacement}", $mCurrentValue);
                }
                else
                {
                    $mCurrentValue = str_replace("{$oSearchItem}", "{$oReplacement}", $mCurrentValue);
                }
            }
            return new self($mCurrentValue);
        }
        else
        {
            if ($oSearch instanceof Regex) {
                return new self(preg_replace("{$oSearch}", "{$oReplacement}", $this->getValue()));
            }
            return new self(str_replace("{$oSearch}", "{$oReplacement}", $this->getValue()));
        }
    }

    /**
     * Checks if the text contains the text passed as the argument.
     * @param AbstractDataType $oSearch
     * @return PlainText
     * @throws InvalidArgumentException
     */
    public function remove(AbstractDataType $oSearch): PlainText
    {
        if ($oSearch instanceof Regex) {
            return new self(preg_replace("{$oSearch}", '', $this->getValue()));
        }
        return new self(str_replace("{$oSearch}", '', $this->getValue()));
    }


    /**
     * Checks if the text contains the text passed as the argument.
     * @param string $sString
     * @return bool
     */
    public function contains(string $sString): bool
    {
        return strpos($sString, $this->getValue()) !== false;
    }

    public function __toString(): string
    {
        return trim((string)$this->getValue());
    }
}
