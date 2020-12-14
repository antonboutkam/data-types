<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\ClassNotFoundException;

class ObjectCollection extends AbstractDataType implements IGenericDataType
{
    /***
     * ObjectCollection constructor.
     *
     * @param null $mValues - An array of class names, PhpNamespace[], constructed objects or constructable objects.
     * @throws ClassNotFoundException
     */
    public function __construct($mValues = null)
    {
        parent::__construct([]);

        if (is_array($mValues)) {
            foreach ($mValues as $mValue) {
                $this->add($mValue);
            }
        }
    }

    /**
     * @param $mValue
     * @throws ClassNotFoundException
     */
    public function add($mValue): void
    {
        if (is_object($mValue)) {
            $objectItem = $mValue;
        } elseif (is_string($mValue)) {
            $objectItem = new PhpNamespace($mValue);
        } elseif ($mValue instanceof PhpNamespace) {
            $objectItem = $mValue;
        } else {
            throw new ClassNotFoundException("Class not found $mValue");
        }

        $aValues = $this->getValue();
        $aValues[] = $objectItem;
        $this->setValue($aValues);
    }

    /**
     * @param mixed ...$allArguments
     * @return Object[]
     * @throws ClassNotFoundException
     */
    public function getConstructed(...$allArguments): array
    {
        $aData = $this->getValue();
        $aOut = [];
        foreach ($aData as $mData) {
            if ($mData instanceof PhpNamespace)
            {
                $aOut[] = $mData->getConstructed(...$allArguments);
            } elseif (is_object($mData))
            {
                $aOut[] = $mData;
            }
        }
        return $aOut;
    }
}
