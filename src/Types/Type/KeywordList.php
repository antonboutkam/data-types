<?php

namespace Hurah\Types\Type;

use InvalidArgumentException;

class KeywordList extends AbstractDataType implements IGenericDataType, IComplexDataType
{

    /**
     * ComposerStability constructor.
     * @param null $aValues
     */
    function __construct($aValues = null)
    {

        if (is_iterable($aValues)) {
            foreach ($aValues as $oValue) {
                if (!$oValue instanceof Keyword) {
                    throw new InvalidArgumentException("Expected an array of Keyword objects.");
                }
            }
        }

        parent::__construct($aValues);
    }

    static function fromArray(array $aData)
    {

        $aKeywords = [];
        foreach ($aData as $sKeyword) {
            $aKeywords[] = new Keyword($sKeyword);
        }
        return new KeywordList($aKeywords);
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        $aKeywords = $this->getValue();
        $aOut = [];
        foreach ($aKeywords as $oKeyWord) {
            $aOut[] = $oKeyWord->getValue();
        }
        return $aOut;
    }

    /**
     * @return Keyword[]
     */
    public function getValue()
    {
        return parent::getValue();
    }

    public function __toString(): string
    {
        return join(',', $this->getValue());
    }
}
