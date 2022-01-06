<?php

namespace Hurah\Types\Util;

use Hurah\Types\Exception\RuntimeException;
use Hurah\Types\Type\Path;
use function basename;
use function dirname;
use function file_exists;
use function is_writable;

/**
 * Class FileSystem
 * @package Hurah\Types\Util
 */
final class FileSystem {

    /**
     * Tries to create a pathname / directory name by combining / joining the passed arguments.
     * @param mixed ...$aParts
     * @return Path
     */
    static function makePath(...$aParts): Path {
        $aUseParts = [];
        $i = 0;
        foreach ($aParts as $mPart) {
            ++$i;
            if (is_null($mPart) || empty($mPart)) {
                continue;
            }
            elseif (is_array($mPart)) {
                $aUseParts[] = self::makePath(...$mPart);
                continue;
            }
            elseif($mPart === '/')
            {
                $aUseParts[] = '';
                continue;
            }

            $aUseParts[] = $mPart;
        }
        return new Path(join(DIRECTORY_SEPARATOR, $aUseParts));
    }

    public static function treeIsWritable(string $sPath):bool
    {
        if(is_writable($sPath))
        {
            return true;
        }
        if(!file_exists($sPath) && $parent = dirname($sPath))
        {
            return self::treeIsWritable($parent);
        }
        return false;
    }

    /**
     * @param string $sPath
     *
     * @return void
     * @throws RuntimeException
     */
    public static function makeDir(string $sPath): void {
        $sParentDir = dirname($sPath);
        if(!self::treeIsWritable($sParentDir))
        {
            throw new RuntimeException("Cannot create {$sPath}, parent dir {$sParentDir} not writable.");
        }
        if (!file_exists($sPath)) {
            mkdir($sPath, 0777, true);
        }
    }
}
