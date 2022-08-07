<?php

namespace Hurah\Types\Type;


use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Util\JsonUtils;

class Lookup extends AbstractDataType implements IGenericDataType
{
    public ?string $sLabel = null;
    public ?string $sValue = null;
    public ?bool $bIsSelected = null;

    /**
     * @param string $sLabel
     * @param string|null $sValue
     * @param bool $bIsSelected
     *
     * @return static
     */
    public static function create(string $sLabel, bool $bIsSelected = false, string $sValue = '@copy-label'): self
    {
        $oSelf = new self();
        $oSelf->sLabel = $sLabel;
        if ($sValue === '@copy-label')
        {
            $oSelf->sValue = $sLabel;
        }
        else
        {
            $oSelf->sValue = $sValue;
        }

        $oSelf->bIsSelected = $bIsSelected;
        return $oSelf;
    }
    public static function createFromDataType(IGenericDataType $oDataType, bool $bIsSelected = false):self
    {
        if($oDataType instanceof KeyValue)
        {
            return self::create($oDataType->getValue(), $bIsSelected, $oDataType->getKey());
        }
        else
        {
            return self::create((string) $oDataType, $bIsSelected);
        }
    }
    public function getValue():string
    {
        return $this->sValue;
    }
    public function getLabel():string
    {
        return $this->sLabel;
    }
    public function setSelected(bool $bSelected = true)
    {
        $this->bIsSelected = $bSelected;
    }

    /**
     * @param ...$aArguments []
     */
    public static function createMixed(...$aArguments): self
    {
        if (count($aArguments) === 3 && is_bool($aArguments[1]))
        {
            return self::create($aArguments[0], $aArguments[1], $aArguments[2]);
        }
        elseif (count($aArguments) === 2 && is_bool($aArguments[1]))
        {
            // Label + selected (value === label)
            return self::create($aArguments[0], $aArguments[1]);
        }
        elseif (count($aArguments) === 1 && !$aArguments[0] instanceof IGenericDataType)
        {
            // Label only
            return self::create($aArguments[0]);
        }
        elseif(count($aArguments) === 1 && $aArguments[0] instanceof IGenericDataType)
        {
            return self::createFromDataType($aArguments[0]);
        }
        elseif(!empty($aArguments))
        {
            $oSelf = new self();
            foreach ($aArguments as $mArgument)
            {
                if (is_bool($mArgument))
                {
                    $oSelf->bIsSelected = $mArgument;
                }
                elseif (is_array($mArgument))
                {
                    foreach ($mArgument as $sArgumentName => $mArgumentValue)
                    {
                        if ($sArgumentName === 'selected')
                        {
                            $oSelf->bIsSelected = (bool)$mArgumentValue;
                        }
                        elseif ($sArgumentName === 'label')
                        {
                            $oSelf->sLabel = $mArgumentValue;
                            if (!isset($mArgument['value']))
                            {
                                $oSelf->sValue = $mArgumentValue;
                            }
                        }
                        elseif ($sArgumentName === 'value')
                        {
                            $oSelf->sValue = $mArgumentValue;
                            if (!isset($mArgument['label']))
                            {
                                $oSelf->sLabel = $mArgumentValue;
                            }
                        }
                    }
                }
            }
            return $oSelf;
        }
        return new self();
    }

    public function __toString():string
    {
        $sSelected = '';
        if($this->bIsSelected)
        {
            $sSelected = 'selected="selected" ';
        }
        return "<option {$sSelected}value=\"{$this->sValue}\">{$this->sLabel}</option>";
    }

}
