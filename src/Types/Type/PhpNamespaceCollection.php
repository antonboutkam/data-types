<?php

namespace Hurah\Types\Type;

use Error;
use Exception;
use Hurah\Types\Exception\InvalidArgumentException;
use ReflectionClass;
use LogicException;
use Hurah\Types\Exception\ClassNotFoundException;
use ReflectionException;

class PhpNamespaceCollection extends AbstractCollectionDataType
{
    public function add(PhpNamespace $oPhpNamespace):void
    {
        $this->array[$this->position] = $oPhpNamespace;
    }

    public function addString(string $sPhpNamespace):void
    {
        $this->add(new PhpNamespace($sPhpNamespace));
    }

    public function current():PhpNamespace
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
