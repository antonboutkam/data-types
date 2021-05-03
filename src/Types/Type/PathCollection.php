<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Symfony\Component\Finder\Finder;

class PathCollection extends AbstractCollectionDataType implements IGenericDataType {
    protected int $position;
    protected array $array;

    /***
     * PathCollection constructor.
     *
     * @param null $mValues - An array of strings[] or DnsName[], internally will all be converted to DnsName.
     * @throws InvalidArgumentException
     */
    public function __construct($mValues = null) {
        $this->position = 0;

        parent::__construct([]);

        if (is_array($mValues)) {
            foreach ($mValues as $mValue) {
                $this->add($mValue);
            }
        }
    }

    /**
     * Returns a Symfony Finder component that as each directory in the collection as a location to look for whatever
     * you are looking for.
     * @return Finder
     */
    public function getFinder():Finder
    {
        $oFinder = new Finder();
        foreach($this as $path)
        {
            if($path->isDir())
            {
                $oFinder->in($path);
            }
        }
        return $oFinder;
    }

    /**
     * Creates a new PathCollection with the Paths in reverse order.
     * @return \Hurah\Types\Type\PathCollection
     */
    public function reverse():PathCollection
    {
        $oPathCollection = new self();
        $aReverseItems = array_reverse($this->array);
        foreach($aReverseItems as $oPath)
        {
            $oPathCollection->add($oPath);
        }
        return $oPathCollection;
    }
    /**
     * @param $mValue
     * @throws InvalidArgumentException
     */
    public function add($mValue): void {
        if (is_string($mValue)) {
            $objectItem = new Path($mValue);
        } else {
            if ($mValue instanceof Path) {
                $objectItem = $mValue;
            } else {
                throw new InvalidArgumentException("Argument must be of type string or " . DnsName::class);
            }
        }

        $this->array[] = $objectItem;
    }


    public function isLast():bool
    {
        return isset($this->array[$this->position+1]);
    }
    /**
     * @return Path[]
     */
    public function toArray(): array {
        return $this->array;
    }

    public function __toString(): string {
        $aOut = [];
        foreach ($this->array as $oPath) {
            $aOut[] = (string)$oPath;
        }
        return join(',', $aOut);
    }

    public function current(): Path {
        return $this->array[$this->position];
    }
}
