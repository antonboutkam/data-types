<?php

namespace Hurah\Types\Type;

use Error;
use Exception;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Util\JsonUtils;
use ReflectionClass;
use LogicException;
use Hurah\Types\Exception\ClassNotFoundException;
use ReflectionException;
use ReturnTypeWillChange;

class PhpNamespaceCollection extends AbstractCollectionDataType
{
    public function asJson()
    {
        return JsonUtils::encode($this->array);
    }
    public function toArray():array
    {
        return $this->array;
    }
    public function __toString():string
    {
        return JsonUtils::encode($this->array);
    }

    public function add(PhpNamespace $oPhpNamespace):void
    {
        $this->array[] = $oPhpNamespace;
    }
    public function addString(string $sPhpNamespace):void
    {
        $this->add(new PhpNamespace($sPhpNamespace));
    }
    #[ReturnTypeWillChange] public function current():PhpNamespace
    {
        return $this->array[$this->position];
    }

    /**
     * Creates a new collection
     * @param PhpNamespaceCollection $namespaceCollection
     */
    public function merge(PhpNamespaceCollection ...$aNamespaceCollections)
    {
        $oNewCollection = clone $this;
        foreach ($aNamespaceCollections as $oNamespaceCollection)
        {
            foreach($oNamespaceCollection as $oPhpNamespace)
            {
                $oNewCollection->add($oPhpNamespace);
            }
        }
        return $oNewCollection;
    }

    /**
     * Returns the first class in the collection that actually exists.
     * @return PhpNamespace
     * @throws ClassNotFoundException
     */
    public function getFirstExisting():PhpNamespace
    {
        foreach($this as $phpNamespace)
        {
            if($phpNamespace->exists())
            {
                return $phpNamespace;
            }
        }
        throw new ClassNotFoundException("None of the PhpNamespaces in the collection exists");
    }
}
