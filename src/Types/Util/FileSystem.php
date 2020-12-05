<?php

namespace Hurah\Types\Util;

use Hurah\Types\Type\Path;

/**
 * Class FileSystem
 * @package Hurah\Types\Util
 * @internal
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
     * Recursively creates a directory if it did not exist. If it does just doen't do anything.
     * @param string $sPath
     */
    static function makeDir(string $sPath): void {
        if (!file_exists($sPath)) {
            mkdir($sPath, 0777, true);
        }
    }
}
