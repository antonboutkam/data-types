<?php

namespace Hurah\Types\Util;

use Hurah\Types\Type\Path;

/**
 * Class DirectoryStructure
 * @package Hurah\Util
 */
class DirectoryStructure {

    static function getVendorDir(): Path {
        return FileSystem::makePath(self::getSysRoot(), 'vendor');
    }

    static function getSysRoot(): Path {
        return new Path(dirname(__DIR__, 3));
    }

    static function getTmpDir(): Path {
        return FileSystem::makePath(self::getSysRoot(), 'data');
    }
}
