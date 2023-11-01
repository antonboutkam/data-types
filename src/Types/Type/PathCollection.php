<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;

use SplFileInfo;
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
     * Checks if this path is already in the collection
     * @param Path $path
     *
     * @return bool
     */
    public function containsPath(Path $path):bool
    {
        foreach($this as $pathComp)
        {
            if("{$pathComp}" === "{$path}")
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Append the items to the current collection
     * @param PathCollection ...$pathCollection
     */
    public function appendCollections(PathCollection ...$pathCollections):self
    {
        foreach($pathCollections as $pathCollection)
        {
            $this->appendCollection($pathCollection);

        }
        return $this;
    }
    public function appendCollection(PathCollection $pathCollection):self
    {
        foreach($pathCollection as $path)
        {
            $this->add($path);
        }
        return $this;
    }

	/**
	 * @throws InvalidArgumentException
	 */
	public static function fromFinder(Finder $finder):self
	{
		$oNewPathCollection = new self();
		foreach($finder as $file)
		{
			if($file instanceof SplFileInfo)
			{
				$oNewPathCollection->add($file);
			}
		}
		return $oNewPathCollection;
	}

    public static function fromPaths(Path ...$paths):self
    {
        $oNewPathCollection = new self();
        foreach($paths as $path)
        {
            $oNewPathCollection->add($path);
        }
        return $oNewPathCollection;
    }

    /**
     * Creates a new combined collection based on the collections provided as arguments
     * @param PathCollection ...$pathCollections
     *
     * @return PathCollection
     * @throws InvalidArgumentException
     */
    public static function fromPathCollections(PathCollection ...$pathCollections):self
    {
        $oNewPathCollection = new self();
        foreach($pathCollections as $pathCollection)
        {
            foreach($pathCollection as $path)
            {
                $oNewPathCollection->add($path);
            }
        }
        return $oNewPathCollection;
    }

    /**
     * Creates a new PathCollection based on the current PathCollection and the collections provided as arguments.
     * @param PathCollection ...$pathCollections
     *
     * @return PathCollection
     * @throws InvalidArgumentException
     */
    public function merge(PathCollection ...$pathCollections):PathCollection
    {
        return (clone $this)->appendCollections(...$pathCollections);
    }

    public function filter(ITestable $oTestable): PathCollection
    {
        $oNewPathCollection = parent::filter($oTestable);
        if($oNewPathCollection instanceof PathCollection)
        {
            return $oNewPathCollection;
        }
        throw new InvalidArgumentException("Return type issue");
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
     *
     * @return \Hurah\Types\Type\PathCollection
     * @throws InvalidArgumentException
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
        }
		elseif ($mValue instanceof Path)
		{
			$objectItem = $mValue;
		}
		elseif ($mValue instanceof IGenericDataType)
		{
			$objectItem = Path::make((string) $mValue);
		}
		elseif ($mValue instanceof SplFileInfo)
		{
			$objectItem = Path::make((string) $mValue);
		}
		else
		{
			throw new InvalidArgumentException("Argument must be of type string or " . Path::class);
        }

        $this->array[] = $objectItem;
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
