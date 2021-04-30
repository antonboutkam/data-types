<?php

namespace Hurah\Types\Type;

use DirectoryIterator;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Util\FileSystem;

/**
 * Points to a file or directory, may be local or remote (http, https, ftp etc)
 *
 * Class Path
 * @package Hurah\Type
 */
class Path extends AbstractDataType implements IGenericDataType, IUri {

    /**
     * @param mixed ...$aParts
     * @return static
     * @throws InvalidArgumentException
     */
    public static function make(...$aParts): self {
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
     * @param $contents - something "string-able"
     * @return self
     */
    public function write($contents): self {
        file_put_contents("{$this->getValue()}", "{$contents}");
        chmod((string)$this->getValue(), 0777);
        return $this;
    }

    /**
     * Checks if the file permissions of the file or directory allow writing
     * @return bool
     */
    public function isWritable():bool {
        return is_writable("{$this->getValue()}");
    }

    /**
     *  Tells whether the filename is executable
     * @return bool
     */
    public function isExecutable():bool {
        return is_executable("{$this->getValue()}");
    }

    /**
     * Add sub directories to the current path, so make it longer.
     * @param mixed ...$aParts
     *
     */
    public function append(...$aParts) {
        $this->setValue($this->extend($aParts));
    }

    /**
     * Creates a new path based on this path with $aParts stitched to it.
     * @param mixed ...$aParts
     * @return Path
     */
    public function extend(...$aParts): Path {
        return FileSystem::makePath($this, $aParts);
    }

    /**
     *
     */
    public function getDirectoryIterator(): DirectoryIterator {
        return new DirectoryIterator($this);
    }

    /**
     *
     */
    public function makeDir(): self {
        FileSystem::makeDir($this);
        return $this;
    }

    /**
     *
     */
    public function isDir(): bool {
        return is_dir($this);
    }

    /**
     * @return File
     * @throws InvalidArgumentException
     */
    public function getFile(): File {
        return new File($this);
    }

    /**
     * @param Path|null $oSubtract
     * @return PhpNamespace
     * @throws InvalidArgumentException
     * @throws \ReflectionException
     */
    public function toPsr4(PhpNamespace $prepend = null, Path $oSubtract = null): PhpNamespace {

        $sWorkPath = "{$this}";
        if ($oSubtract) {
            $sWorkPath = str_replace("{$oSubtract}", "", $sWorkPath);
            $sWorkPath = preg_replace('/^\\' . DIRECTORY_SEPARATOR . '/', '', $sWorkPath);
        }
        $sWorkPath = preg_replace('/\.php$/', '', $sWorkPath);
        $sNamespacePath = str_replace(DIRECTORY_SEPARATOR, '\\', $sWorkPath);
        return PhpNamespace::make($prepend, $sNamespacePath);
    }

    /**
     *
     * @param int $iLevels = 1
     * @return Path
     * @throws InvalidArgumentException
     */
    public function dirname(int $iLevels = 1): Path {
        return new Path(dirname($this, $iLevels));
    }

    /**
     * @return bool
     */
    public function isFile(): bool {
        return file_exists($this) && is_file($this);
    }

    /**
     * Tries to unlink a file or directory if it exists, returns false when the file does not exist.
     * @return bool
     */
    public function unlink(): bool {
        if (is_dir($this)) {
            return rmdir($this);
        } else {
            if (file_exists($this) || is_link($this)) {
                return unlink($this);
            }
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
    public function move(Path $oDestination): Path {
        rename($this, $oDestination);
        $this->setValue($oDestination);
        return $this;
    }

    /**
     * @return PlainText
     * @throws InvalidArgumentException
     */
    public function contents():PlainText {
        return new PlainText(file_get_contents($this));
    }


    /**
     * @param int|null $time
     * @param int|null $atime
     * @return $this
     */
    public function touch(int $time = null , int $atime = null): Path {
        if($time === null)
        {
            $time = time();
        }
        if($atime === null)
        {
            $atime = time();
        }
        touch("{$this}", $time, $atime);

        return $this;
    }
    /**
     *
     * @param string $sSuffix = ''
     * @return Path
     * @throws InvalidArgumentException
     */
    public function basename(string $sSuffix = ''): Path {
        return new Path(basename($this, $sSuffix));
    }

    /**
     *
     */
    public function exists(): bool {
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
