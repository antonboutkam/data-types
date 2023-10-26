<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;


class FileTypeCollection extends AbstractCollectionDataType implements IGenericDataType, ITestable
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
    public static function fromFileTypes(FileType ...$types): self
    {
        $oNewFileTypeCollection = new self();
        foreach ($types as $type)
        {
            $oNewFileTypeCollection->add($type);
        }
        return $oNewFileTypeCollection;
    }

    /**
     * Creates a new combined collection based on the collections provided as arguments
     *
     * @param FileTypeCollection ...$fileCollections
     *
     * @return FileTypeCollection
     * @throws InvalidArgumentException
     */
    public static function fromFileTypeCollections(FileTypeCollection ...$fileCollections): self
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
     * Append the items to the current collection
     *
     * @param FileTypeCollection ...$fileTypeCollections
     * @return FileTypeCollection
     * @throws InvalidArgumentException
     */
    public function appendCollections(FileTypeCollection ...$fileTypeCollections): self
    {
        foreach ($fileTypeCollections as $fileTypeCollection)
        {
            $this->addCollection($fileTypeCollection);

        }
        return $this;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function addCollection(FileTypeCollection $fileCollection): self
    {
        foreach ($fileCollection as $file)
        {
            $this->add($file);
        }
        return $this;
    }

    /**
     * Creates a new FileCollection based on the current FileCollection and the collections provided as arguments.
     *
     * @param FileTypeCollection ...$fileTypeCollection
     * @return self
     * @throws InvalidArgumentException
     */
    public function merge(FileTypeCollection ...$fileTypeCollection): FileTypeCollection
    {
        return (clone $this)->appendCollections(...$fileTypeCollection);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function filter(ITestable $oTestable): FileTypeCollection
    {
        $oNewFileTypeCollection = parent::filter($oTestable);
        if ($oNewFileTypeCollection instanceof FileTypeCollection)
        {
            return $oNewFileTypeCollection;
        }
        throw new InvalidArgumentException("Return type issue");
    }

    /**
     * Creates a new FileCollection with the Paths in reverse order.
     *
     * @return FileTypeCollection
     * @throws InvalidArgumentException
     */
    public function reverse(): FileTypeCollection
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
            $objectItem = new FileType($mValue);
        }
        elseif ($mValue instanceof FileType)
        {
            $objectItem = $mValue;
        }
        else
        {
            throw new InvalidArgumentException("Argument must be of type string or " . DnsName::class);
        }

        foreach($this as $item)
        {
            if($item->getName() === $objectItem->getName())
            {
                $item->addFileNamePatterns($objectItem->getFileNamePatterns());
                return;
            }
        }
        $this->array[] = $objectItem;
    }


    /**
     * @return FileType[]
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

     public function current(): FileType
    {
        return $this->array[$this->position];
    }


    public function test($sSubject): bool
    {
        foreach($this as $fileType)
        {
            if($fileType->test($sSubject))
            {
                return true;
            }
        }
        return false;
    }
}
