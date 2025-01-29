<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\ImplementationException;
use Hurah\Types\Exception\InvalidArgumentException;


class FileExtensionCollection extends AbstractCollectionDataType implements IGenericDataType
{
    protected int $position;
    protected array $array;

    /***
     * PathCollection constructor.
     *
     * @param null $mValues - An array of strings[] or DnsName[], internally will all be converted to DnsName.
     *
     * @throws InvalidArgumentException|ImplementationException
     */
    public function __construct($mValues = null)
    {
        $this->position = 0;

        parent::__construct([]);

        if (is_array($mValues))
        {
            foreach ($mValues as $mValue)
            {
                $this->add($mValue);
            }
        }
    }

    /**
     * @throws InvalidArgumentException|ImplementationException
     */
    public static function fromPaths(Path ...$paths): self
    {
        $oNewFileExtensionCollection = new self();
        foreach ($paths as $path)
        {
            $oNewFileExtensionCollection->add($path->getFileExtension());
        }
        return $oNewFileExtensionCollection;
    }


    /**
     * Checks if this path is already in the collection
     *
     * @param FileExtension $FileExtension
     * @return bool
     */
    public function containsFileExtension(FileExtension $FileExtension): bool
    {
        foreach ($this as $fileComp)
        {
            if ("{$fileComp}" === "{$FileExtension}")
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Append the items to the current collection
     *
     * @param FileExtensionCollection ...$fileCollections
     *
     * @return FileExtensionCollection
     * @throws InvalidArgumentException
     * @throws ImplementationException
     */
    public function appendCollections(FileExtensionCollection ...$fileCollections): self
    {
        foreach ($fileCollections as $fileCollection)
        {
            $this->appendCollection($fileCollection);

        }
        return $this;
    }

    /**
     * @throws InvalidArgumentException|ImplementationException
     */
    public function appendCollection(FileExtensionCollection $fileFileExtensionCollection): self
    {
        foreach ($fileFileExtensionCollection as $fileExtension)
        {
            $this->add($fileExtension);
        }
        return $this;
    }


    /**
     * Creates a new PathCollection with the Paths in reverse order.
     *
     * @return FileExtensionCollection
     * @throws ImplementationException
     * @throws InvalidArgumentException
     */
    public function reverse(): FileExtensionCollection
    {
        $oFileCollection = new self();
        $aReverseItems = array_reverse($this->array);
        foreach ($aReverseItems as $oPath)
        {
            $oFileCollection->add($oPath);
        }
        return $oFileCollection;
    }

    /**
     * @param $mValue
     *
     * @throws InvalidArgumentException
     * @throws ImplementationException
     */
    public function add($mValue): void
    {
        if (is_string($mValue))
        {
            $objectItem = FileExtension::fromString($mValue);
        }
        elseif ($mValue instanceof Path)
        {
            $objectItem = $mValue->getFileExtension();
        }
        elseif($mValue instanceof File)
        {
            $objectItem = $mValue->getExtensionType();

        }
        elseif(is_object($mValue))
        {
            throw new ImplementationException("Method not implemented for object of type " . get_class($mValue));
        }
        else
        {
            throw new ImplementationException("Method not implemented for object of type " . gettype($mValue));
        }

        $this->array[] = $objectItem;
    }


    /**
     * @return Path[]
     */
    public function toArray(): array
    {
        return $this->array;
    }

    public function __toString(): string
    {
        $aOut = [];
        foreach ($this->array as $oPath)
        {
            $aOut[] = (string)$oPath;
        }
        return join(',', $aOut);
    }

     public function current(): File
    {
        return $this->array[$this->position];
    }


}
