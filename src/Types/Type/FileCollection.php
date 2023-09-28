<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;


class FileCollection extends AbstractCollectionDataType implements IGenericDataType
{
    protected int $position;
    protected array $array;

    /***
     * PathCollection constructor.
     *
     * @param null $mValues - An array of strings[] or DnsName[], internally will all be converted to DnsName.
     *
     * @throws InvalidArgumentException
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
     * @throws InvalidArgumentException
     */
    public static function fromPaths(Path ...$paths): self
    {
        $oNewFileCollection = new self();
        foreach ($paths as $path)
        {
            $oNewFileCollection->add($path->getFile());
        }
        return $oNewFileCollection;
    }

    /**
     * Creates a new combined collection based on the collections provided as arguments
     *
     * @param FileCollection ...$fileCollections
     *
     * @return FileCollection
     * @throws InvalidArgumentException
     */
    public static function fromFileCollections(FileCollection ...$fileCollections): self
    {
        $oNewFileCollection = new self();
        foreach ($fileCollections as $fileCollection)
        {
            foreach ($fileCollection as $file)
            {
                $oNewFileCollection->add($file);
            }
        }
        return $oNewFileCollection;
    }

    /**
     * Checks if this path is already in the collection
     *
     * @param Path $path
     *
     * @return bool
     */
    public function containsFile(File $file): bool
    {
        foreach ($this as $fileComp)
        {
            if ("{$fileComp}" === "{$file}")
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Append the items to the current collection
     *
     * @param FileCollection ...$fileCollections
     *
     * @return FileCollection
     */
    public function appendCollections(FileCollection ...$fileCollections): self
    {
        foreach ($fileCollections as $fileCollection)
        {
            $this->appendCollection($fileCollection);

        }
        return $this;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function appendCollection(FileCollection $fileCollection): self
    {
        foreach ($fileCollection as $file)
        {
            $this->add($file);
        }
        return $this;
    }

    /**
     * Creates a new PathCollection based on the current PathCollection and the collections provided as arguments.
     *
     * @param FileCollection ...$fileCollections
     *
     * @return FileCollection
     */
    public function merge(FileCollection ...$fileCollections): FileCollection
    {
        return (clone $this)->appendCollections(...$fileCollections);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function filter(ITestable $oTestable): FileCollection
    {
        $oNewPathCollection = parent::filter($oTestable);
        if ($oNewPathCollection instanceof FileCollection)
        {
            return $oNewPathCollection;
        }
        throw new InvalidArgumentException("Return type issue");
    }

    /**
     * Creates a new PathCollection with the Paths in reverse order.
     *
     * @return FileCollection
     * @throws InvalidArgumentException
     */
    public function reverse(): FileCollection
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
     */
    public function add($mValue): void
    {
        if (is_string($mValue))
        {
            $objectItem = new Path($mValue);
        }
        else
        {
            if ($mValue instanceof Path)
            {
                $objectItem = $mValue;
            }
            else
            {
                throw new InvalidArgumentException("Argument must be of type string or " . DnsName::class);
            }
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
