<?php

namespace Hurah\Types\Type\Php;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Exception\RuntimeException;
use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\IGenericDataType;
use Hurah\Types\Type\PlainText;
use Hurah\Types\Type\TypeType;

class Property extends AbstractDataType implements IGenericDataType
{
    private VarName $name;
    private PropertyLabel $label;
    private TypeType $type;
    private bool $nullable;
    private $default;

    public function __construct($mValue = null) {
        $this->default = new IsVoid();
        if ($mValue && (!isset($mValue['name']) || !isset($mValue['type'])))
        {
            throw new InvalidArgumentException("Constructor needs at least name and type properties");
        } else
        {
            if (isset($mValue['name']) && isset($mValue['type']))
            {
                $this->setName(new VarName("{$mValue['name']}"));
                $this->setType(new TypeType("{$mValue['type']}"));
            }
        }

        if (isset($mValue['nullable']))
        {
            $this->setNullable($mValue['nullable']);
        }
        if (isset($mValue['default']))
        {
            $this->setDefault($mValue['default']);
        }
        if (isset($mValue['label']))
        {
            $this->setDefault($mValue['label']);
        }
        parent::__construct('');
    }
    /**
     * @param mixed ...$params
     * @return static
     * @throws RuntimeException
     */
    public static function create(...$params): self {
        $oProperty = new Property();
        if (is_iterable($params))
        {
            foreach ($params as $key => $param)
            {
                if (is_string($key) && in_array($key, [
                        'name',
                        'type',
                        'nullable',
                        'default',
                    ]) && !is_object($param))
                {
                    echo "{$key} ---------------------------------> {$param}" . PHP_EOL;
                    $oProperty->setByKey($key, $param);
                } else
                {
                    if (is_array($param))
                    {
                        foreach ($param as $itemKey => $value)
                        {
                            $oProperty->setByKey($itemKey, $value);
                        }
                    } else
                    {
                        $oProperty->setByType($param);
                    }
                }
            }
        }
        return $oProperty;
    }
    /**
     * @param string $sKey
     * @param string $sValue
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function setByKey(string $sKey, string $sValue) {
        if ($sKey === 'name')
        {
            $this->name = new VarName($sValue);
        } else if ($sKey === 'type')
        {
            $this->type = new TypeType($sValue);
        } else if ($sKey === 'nullable')
        {
            $this->nullable = $sValue;
        } else if ($sKey === 'default')
        {
            $this->default = $sValue;
        } else if ($sKey === 'label')
        {
            $this->label = new PropertyLabel($sValue);
        }
    }
    /**
     * Dynamically sets any of these properties based on the type of $param
     * @param $param
     * @return $this
     */
    public function setByType($param): self {
        if ($param instanceof VarName)
        {
            $this->setName($param);
        } else if ($param instanceof TypeType)
        {
            $this->setType($param);
        } else if (is_bool($param))
        {
            $this->setNullable($param);
        } else if ($param instanceof PlainText)
        {
            $this->setDefault($param);
        } else if ($param instanceof PropertyLabel)
        {
            $this->setLabel($param);
        }
        return $this;
    }
    public function getName(): VarName {
        return $this->name;
    }
    public function setName(VarName $name) {
        $this->name = $name;
    }

    public function getLabel(): PropertyLabel {
        return $this->label ?? new PropertyLabel();
    }
    public function setLabel(PropertyLabel $name) {
        $this->label = $name;
    }
    public function getType(): TypeType {
        return $this->type;
    }
    public function setType(TypeType $type) {
        $this->type = $type;
    }
    public function isNullable(): bool {
        return $this->nullable ?? false;
    }
    public function getNullable(): bool {
        return $this->nullable;
    }
    public function setNullable(bool $nullable) {
        $this->nullable = $nullable;
    }

    public function getDefault() {
        return $this->default;
    }
    public function setDefault($default) {
        $this->default = $default;
    }

    public function toArray(): array {
        return [
            'name'     => $this->name,
            'type'     => $this->type,
            'nullable' => $this->nullable,
            'default'  => $this->default,
        ];
    }
}
