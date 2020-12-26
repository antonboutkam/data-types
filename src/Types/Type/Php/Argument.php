<?php

namespace Hurah\Types\Type\Php;

use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\IGenericDataType;
use Hurah\Types\Type\PlainText;
use Hurah\Types\Type\TypeType;
use InvalidArgumentException;

class Argument extends AbstractDataType implements IGenericDataType
{
    private VarName $name;
    private TypeType $type;
    private bool $nullable;
    private PlainText $default;

    public function __construct($mValue = null)
    {
        if ($mValue && (!isset($mValue['name']) || !isset($mValue['type'])))
        {
            throw new InvalidArgumentException("");
        }

        $this->setName(new VarName("{$mValue['name']}"));
        $this->setType(new TypeType("{$mValue['type']}"));

        if (isset($mValue['nullable']))
        {
            $this->setNullable($mValue['nullable']);
        }
        if (isset($mValue['default']))
        {
            $this->setDefault($mValue['default']);
        }
        parent::__construct('');
    }

    /**
     * Dynamically sets any of these properties based on the type of $param
     * @param $param
     * @return $this
     */
    public function set($param): self
    {
        if ($param instanceof VarName)
        {
            $this->setName($param);
        } else
        {
            if ($param instanceof TypeType)
            {
                $this->setType($param);
            } else
            {
                if (is_bool($param))
                {
                    $this->setNullable($param);
                } else
                {
                    if ($param instanceof PlainText)
                    {
                        $this->setDefault($param);
                    }
                }
            }
        }
        return $this;
    }

    /**
     * @param string $sKey
     * @param string $sValue
     * @throws \Hurah\Types\Exception\InvalidArgumentException
     * @throws \Hurah\Types\Exception\RuntimeException
     */
    public function setByKey(string $sKey, string $sValue)
    {
        if($sKey === 'name')
        {
            $this->name = new VarName($sValue);
        }
        else if($sKey === 'type')
        {
            $this->type = new TypeType($sValue);
        }
        else if($sKey === 'nullable')
        {
            $this->nullable = $sValue;
        }
        else if($sKey === 'default')
        {
            $this->default = new PlainText($sValue);
        }
    }

    public static function create(...$params): self
    {
        $oArgument = new Argument();
        if (is_iterable($params))
        {
            foreach ($params as $key => $param)
            {
                if (is_string($key) && in_array($key, ['name', 'type', 'nullable', 'default']) && is_string($param))
                {
                    $oArgument->setByKey($key, $param);
                }
                else
                {
                    $oArgument->set($param);
                }
            }
        }
        return $oArgument;
    }

    public function getName(): VarName
    {
        return $this->name;
    }
    public function setName(VarName $name)
    {
        $this->name = $name;
    }

    public function getType(): TypeType
    {
        return $this->type;
    }
    public function setType(TypeType $type)
    {
        $this->type = $type;
    }

    public function getNullable(): bool
    {
        return $this->nullable;
    }
    public function setNullable(bool $nullable)
    {
        $this->nullable = $nullable;
    }

    public function getDefault(): PlainText
    {
        return $this->default;
    }
    public function setDefault(PlainText $default)
    {
        $this->default = $default;
    }

    public function toArray():array{
        return [
            'name' => $this->name,
            'type' => $this->type,
            'nullable' => $this->nullable,
            'default' => $this->default,
        ];
    }
}
