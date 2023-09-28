<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Exception\RuntimeException;
use ReflectionClass;
use ReflectionException;


class TypeTypeCollection extends AbstractCollectionDataType implements IComplexDataType {
    protected int $position;
    protected array $array;

    /**
     * PathCollection constructor.
     *
     * @param null $mValues
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws RuntimeException
     */
    public function __construct($mValues = null) {

        $this->position = 0;

        parent::__construct([]);

        if (is_iterable($mValues)) {
            foreach ($mValues as $mValue) {
                $this->add($mValue);
            }
        }
    }

    /**
     * Adds an item to the stack
     * @param TypeType $item
     */
    private function addItem(TypeType $item) {
        $this->array[] = $item;
    }

    /**
     * Adds an item to the stack after checking it's type.
     * @param string $sFqClassName
     * @return TypeTypeCollection
     * @throws ReflectionException
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function addString(string $sFqClassName):self
    {
        $oReflector = new ReflectionClass($sFqClassName);
        if($oReflector->implementsInterface(IGenericDataType::class))
        {
            $this->addItem(new TypeType(new PhpNamespace($sFqClassName)));
        }
        else
        {
            $sMsg = "String {$sFqClassName} is not a reference to a class implementing " . IGenericDataType::class;
            throw new InvalidArgumentException($sMsg);
        }
        return $this;
    }

    /**
     * Adds an item to the stack after checking it's type.
     * @param PhpNamespace $oPhpNamespace
     * @return TypeTypeCollection
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function addPhpNamespace(PhpNamespace $oPhpNamespace):self
    {
        if($oPhpNamespace->implementsInterface(IGenericDataType::class))
        {
            $this->addItem(new TypeType($oPhpNamespace));
        }
        else
        {
            $sMsg = "String {$oPhpNamespace} is not a reference to a class implementing " . IGenericDataType::class;
            throw new InvalidArgumentException($sMsg);
        }
        return $this;
    }

    /**
     * @param IGenericDataType $dataType
     * @return TypeTypeCollection
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function addObject(IGenericDataType $dataType):self
    {
        $this->addItem(new TypeType(new PhpNamespace(get_class($dataType))));
        return $this;
    }

    /**
     * @param TypeTypeCollection $collection
     * @return $this
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws RuntimeException
     */
    public function addCollection(self $collection):self
    {
        foreach ($collection as $item)
        {
            $this->add($item);
        }
        return $this;
    }

    /**
     * @param mixed ...$mValues
     * @return TypeTypeCollection
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws RuntimeException
     */
    public function add(...$mValues): self {
        foreach ($mValues as $mValue)
        {
            if(is_string($mValue))
            {
                $this->addString($mValue);
            }
            elseif(is_object($mValue) && $mValue instanceof IGenericDataType)
            {
                $this->addObject($mValue);
            }
            elseif($mValue instanceof PhpNamespace)
            {
                $this->addPhpNamespace($mValue);
            }
            elseif($mValue instanceof TypeTypeCollection)
            {
                $this->addCollection($mValue);
            }
        }
        return $this;
    }

    /**
     * @return TypeType[]
     */
    public function toArray(): array {
        $aOut = [];
        foreach($this as $oTypeType)
        {
            $aOut[] = "{$oTypeType}";
        }
        return $aOut;
    }
    public function count() : int {
        return count($this->array);
    }

    public function __toString(): string {
        $aOut = [];
        foreach ($this->getValue() as $oPath) {
            $aOut[] = (string)$oPath;
        }
        return join(',', $aOut);
    }

     public function current(): TypeType {
        return $this->array[$this->position];
    }
}
