<?php

namespace Hurah\Types\Util;

use Hurah\Types\Exception\RuntimeException;
use Hurah\Types\Type\Path;
use function dirname;
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
        foreach ($aParts as $mPart) {
            if (is_null($mPart) || empty($mPart)) {
                continue;
            }
            if (is_array($mPart)) {
                $aUseParts[] = self::makePath(...$mPart);
                continue;
            }
            $aUseParts[] = $mPart;
        }
        return new Path(join(DIRECTORY_SEPARATOR, $aUseParts));
    }

    /**
     * @param string $sPath
     *
     * @return void
     * @throws RuntimeException
     */
    static function makeDir(string $sPath): void {
        $sParentDir = dirname($sPath);
        if(!is_writable(dirname($sParentDir)))
        {
            throw new RuntimeException("Cannot create {$sPath}, parent dir {$sParentDir} not writable.");
        }
        if (!file_exists($sPath)) {
            mkdir($sPath, 0777, true);
        }
    }
}
