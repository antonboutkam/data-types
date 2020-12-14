<?php

namespace Hurah\Types\Type;

use DirectoryIterator;
use Hurah\Types\Exception\NullPointerException;
use Hurah\Types\Util\FileSystem;

/**
 * Points to a file or directory, may be local or remote (http, https, ftp etc)
 *
 * Class Path
 * @package Hurah\Type
 */
class Path extends AbstractDataType implements IGenericDataType, IUri
{

    public static function make(...$aParts): self
    {
        $aUseParts = [];
        foreach ($aParts as $mPart) {
            if (is_null($mPart) || empty($mPart)) {
                continue;
            }
            if (is_array($mPart)) {
                $aUseParts[] = self::make(...$mPart);
                continue;
            }
            $aUseParts[] = $mPart;
        }
        return new Path(join(DIRECTORY_SEPARATOR, $aUseParts));
    }

    /**
     * @param $contents - something "stringable"
     * @return self
     */
    public function write($contents): self
    {
        file_put_contents(trim((string)$this->getValue()), PHP_EOL . (string)$contents);
        chmod((string)$this->getValue(), 0777);
        return $this;
    }

    /**
     * Add sub directories to the current path, so make it longer.
     * @param mixed ...$aParts
     *
     */
    public function append(...$aParts)
    {
        $this->setValue($this->extend($aParts));
    }

    /**
     * Creates a new path based on this path with $aParts stitched to it.
     * @param mixed ...$aParts
     * @return Path
     */
    public function extend(...$aParts): Path
    {
        return FileSystem::makePath($this, $aParts);
    }

    /**
     *
     */
    public function getDirectoryIterator(): DirectoryIterator
    {
        return new DirectoryIterator($this);
    }

    /**
     *
     */
    public function makeDir(): self
    {
        FileSystem::makeDir($this);
        return $this;
    }

    /**
     *
     */
    public function isDir(): bool
    {
        return is_dir($this);
    }

    /**
     *
     */
    public function getFile(): File
    {
        return new File($this);
    }

    /**
     *
     * @param int $iLevels = 1
     * @return Path
     */
    public function dirname(int $iLevels = 1): Path
    {
        return new Path(dirname($this, $iLevels));
    }

    public function isFile(): bool
    {
        return file_exists($this) && is_file($this);
    }

    public function unlink(): bool
    {
        if (is_dir($this)) {
            return rmdir($this);
        } elseif (file_exists($this) || is_link($this)) {
            return unlink($this);
        }
        throw new NullPointerException("Unlinking failed, file does not exist.");
    }

    /**
     * Renames the file or directory (if it exists) and sets the internal path to the new destination. Returns the path
     * of the destination also for method chaining.
     *
     * @param Path $oDestination
     * @return $this
     */
    public function move(Path $oDestination): Path
    {
        rename($this, $oDestination);
        $this->setValue($oDestination);
        return $this;
    }

    public function contents()
    {
        return new PlainText(file_get_contents($this));
    }

    /**
     *
     * @param int $iLevels = 1
     * @return Path
     */
    public function basename(int $iLevels = 1): Path
    {
        return new Path(basename($this, $iLevels));
    }

    /**
     *
     */
    public function exists(): bool
    {
        $sValue = $this->getValue();
        if (file_exists($sValue)) {
            return true;
        } elseif (is_dir($sValue)) {
            return true;
        } elseif (is_link($sValue)) {
            return true;
        }
        return false;
    }
}
