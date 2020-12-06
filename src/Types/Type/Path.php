<?php

namespace Hurah\Types\Type;

use DirectoryIterator;
use Hurah\Types\Util\FileSystem;

/**
 * Points to a file or directory, may be local or remote (http, https, ftp etc)
 *
 * Class Path
 * @package Hurah\Type
 */
class Path extends AbstractDataType implements IGenericDataType, IUri {

    /**
     * @param $contents - something "stringable"
     *
     */
    function write($contents): self {
        file_put_contents(trim((string)$this->getValue()), PHP_EOL . (string)$contents);
        chmod((string)$this->getValue(), 0777);
        return $this;
    }

    /**
     * Add sub directories to the current path, so make it longer.
     * @param mixed ...$aParts
     *
     */
    function append(...$aParts) {
        $this->setValue($this->extend($aParts));
    }

    /**
     * Creates a new path based on this path with $aParts stitched to it.
     * @param mixed ...$aParts
     * @return Path
     */
    function extend(...$aParts): Path {
        return FileSystem::makePath($this, $aParts);
    }

    /**
     *
     */
    function getDirectoryIterator(): DirectoryIterator {
        return new DirectoryIterator($this);
    }

    /**
     *
     */
    function makeDir(): self {
        FileSystem::makeDir($this);
        return $this;
    }

    /**
     *
     */
    function isDir(): bool {
        return is_dir($this);
    }

    /**
     *
     */
    function getFile(): File {
        return new File($this);
    }

    /**
     *
     * @param int $iLevels = 1
     * @return Path
     */
    function dirname(int $iLevels = 1): Path {
        return new Path(dirname($this, $iLevels));
    }

    function isFile(): bool {
        return file_exists($this) && is_file($this);
    }

    function unlink(): bool {
        if (is_dir($this)) {
            return rmdir($this);
        } else if (file_exists($this) || is_link($this)) {
            return unlink($this);
        }
        return false;

    }



/**
 * Renames the file or directory (if it exists) and sets the internal path to the new destination. Returns the path
 * of the destination also for method chaining.
 *
 * @param Path $oDestination
 * @return $this
 */
function move(Path $oDestination): Path {
    rename($this, $oDestination);
    $this->setValue($oDestination);
    return $this;
}

function contents() {
    return trim(file_get_contents((string)$this));
}

/**
 *
 * @param int $iLevels = 1
 * @return Path
 */
function basename(int $iLevels = 1): Path {
    return new Path(basename($this, $iLevels));
}

/**
 *
 */
function exists(): bool {
    $sValue = $this->getValue();
    if (file_exists($sValue)) {
        return true;
    } else {
        if (is_dir($sValue)) {
            return true;
        } else {
            if (is_link($sValue)) {
                return true;
            }
        }
    }
    return false;
}
}
