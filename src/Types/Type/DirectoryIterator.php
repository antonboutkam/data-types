<?php

namespace Hurah\Types\Type;

class DirectoryIterator extends \DirectoryIterator implements IGenericDataType
{

    const FILE_ONLY = 1;
    const DIR_ONLY = 2;
    private string $sValue;

    public function __construct($sValue = null)
    {
        $this->sValue = $sValue;
        parent::__construct($sValue);
    }

    public function __toString(): string
    {
        return $this->getPathname();
    }

    public function toPathCollection(int $iType = null, ITestable $oTestable = null): PathCollection
    {
        $oPathCollection = new PathCollection();

        foreach ($this as $item)
        {
            if (!$item instanceof \DirectoryIterator)
            {
                continue;
            }
            if ($item->isDot())
            {
                continue;
            }
            if ($oTestable && !$oTestable->test($item->getPathname()))
            {
                continue;
            }
            if ($iType == null)
            {
                $oPathCollection->add($item->getPathname());
            }
            elseif ($item->isDir() && $iType == self::DIR_ONLY)
            {
                $oPathCollection->add($item->getPathname());
            }
            elseif ($item->isFile() && $iType == self::FILE_ONLY)
            {
                $oPathCollection->add($item->getPathname());
            }
        }
        return $oPathCollection;
    }

    public function setValue($sValue)
    {
        $this->sValue = $sValue;
    }

    public function getValue()
    {
        return $this->sValue;
    }
}