<?php

namespace Hurah\Types\Type;

class DirectoryIterator extends \DirectoryIterator
{

    const FILE_ONLY = 1;
    const DIR_ONLY = 2;

    public function toPathCollection(int $iType = null, ITestable $oTestable): PathCollection
    {
        $oPathCollection = new PathCollection();

        foreach ($this as $item)
        {
            if (!$item instanceof \DirectoryIterator)
            {
                continue;
            }
            if($item->isDot())
            {
                continue;
            }
            if($iType == null)
            {
                $oPathCollection->add($item->getPathname());
            }
            elseif($item->isDir() && $iType == self::DIR_ONLY)
            {
                $oPathCollection->add($item->getPathname());
            }
            elseif($item->isFile() && $iType == self::FILE_ONLY)
            {
                $oPathCollection->add($item->getPathname());
            }
        }
        return $oPathCollection;
    }
}