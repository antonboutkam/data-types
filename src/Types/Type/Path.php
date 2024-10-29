<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Exception\NullPointerException;
use Hurah\Types\Exception\RuntimeException;
use Hurah\Types\Util\FileSystem;
use ReflectionException;
use Symfony\Component\Finder\Finder;
use function array_filter;
use function array_values;
use function file_exists;
use function in_array;
use function is_dir;
use function is_file;
use function is_link;
use function preg_match;
use function preg_replace;
use function rmdir;
use function str_replace;
use function unlink;
use function var_dump;
use const DIRECTORY_SEPARATOR;
use const PHP_EOL;

/**
 * Points to a file or directory, may be local or remote (http, https, ftp etc)
 * Class Path
 *
 * @package Hurah\Type
 */
class Path extends AbstractDataType implements IGenericDataType, IUri
{

    /**
     * @param mixed ...$aParts
     *
     * @return static
     * @throws InvalidArgumentException
     */
    public static function make(...$aParts): self
    {

        $aUseParts = [];
        foreach ($aParts as $mPart)
        {
            if (is_null($mPart) || empty($mPart))
            {
                continue;
            }
            if (is_array($mPart))
            {
                $aUseParts[] = self::make(...$mPart);
                continue;
            }

            if(DIRECTORY_SEPARATOR === '\\')
            {
                $mPart = str_replace('/', '\\', $mPart);
            }
            $aUseParts[] = $mPart;
        }
        if (count($aUseParts) === 0)
        {
            return new Path();
        }
        return new Path(join(DIRECTORY_SEPARATOR, $aUseParts));
    }

    /**
     * Returns the path as an array / explodes the path on the DIRECTORY_SEPARATOR. If the path is empty, an empty
     * array is returned.
     *
     * @return array
     */
    public function explode(): array
    {
        return array_values(array_filter(explode(DIRECTORY_SEPARATOR, "{$this}")));
    }

    public function isEmpty(): bool
    {
        $sPath = $this->getValue();
        if (!$sPath)
        {
            return true;
        }
        return false;
    }

    /**
     * Returns the number of levels this path has.
     *
     * @return int
     */
    public function depth(): int
    {
        return count($this->explode());
    }

    /**
     * Returns the sequence of elements from the path as specified by the offset and length parameters.
     *
     * @param int $iOffset  If offset is non-negative, the sequence will start at that offset in the array.
     *                      If offset is negative, the sequence will start that far from the end of the array.
     * @param int|null $iLength
     *
     * @return Path
     * @throws InvalidArgumentException
     */
    public function slice(int $iOffset, int $iLength = null): Path
    {
        $aParts = $this->explode();
        if($iOffset < 0)
        {
            $iOffset = count($aParts) + $iOffset;
        }

        $aSelectedParts = [];

        $iCurrentOffset = 0;
        $iCurrentLength = 0;

        foreach ($aParts as $sPart)
        {
            if ($iCurrentOffset >= $iOffset && ($iLength == null || $iCurrentLength < $iLength))
            {
                $aSelectedParts[] = $sPart;
                ++$iCurrentLength;
            }
            ++$iCurrentOffset;
        }
        return Path::make($aSelectedParts);

    }

    public function hasExtension(string $sExt): bool
    {
        $sPath = $this->getValue();
        if (!$sPath)
        {
            return false;
        }
        if (!preg_match("/[a-zA-Z0-9_-]\.{$sExt}$/", $sPath))
        {
            return false;
        }
        return true;
    }

    /**
     * @return bool
     * @throws NullPointerException
     */
    public function isRelative(): bool
    {
        return !$this->isAbsolute();
    }
    public function removeExtension():Path
    {
        $sPattern = new Regex('/.' . $this->getExtension() . '$/');
        return $this->remove($sPattern);
    }
    public function getExtension():string
    {
        return $this->getFile()->getExtension();
    }

    public function isAbsolute(): bool
    {
        $sPath = $this->getValue();
        if (!$sPath)
        {
            throw new NullPointerException("Path is empty");
        }
        return preg_match('/^\//', $sPath);
    }

    /**
     * @param $contents - something "string-able"
     *
     * @return self
     * @throws InvalidArgumentException
     */
    public function write($contents): self
    {
        $this->getFile()->writeContents(new PlainText($contents));
        return $this;
    }


    /**
     * Checks if the text contains the text passed as the argument.
     * @param ITestable $oRegex
     * @return bool
     */
    public function matches(ITestable $oTestable): bool
    {
        return $oTestable->test($this);
    }
    /**
     * Checks if the file permissions of the file or directory allow writing
     *
     * @return bool
     */
    public function isWritable(): bool
    {
        return is_writable("{$this->getValue()}");
    }

    /**
     *  Tells whether the filename is executable
     *
     * @return bool
     */
    public function isExecutable(): bool
    {
        return is_executable("{$this->getValue()}");
    }

    /**
     * Add sub directories to the current path, so make it longer.
     *
     * @param mixed ...$aParts
     */
    public function append(...$aParts)
    {
        $this->setValue($this->extend($aParts));
    }

    /**
     * Creates a new path based on this path with $aParts stitched to it.
     *
     * @param mixed ...$aParts
     *
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
     * Returns a path collection with each item one level  up in the tree
     *
     * @return PathCollection
     */
    public function treeUp(): PathCollection
    {
        $oCurrent = clone $this;
        $oPathCollection = new PathCollection();
        $oPathCollection->add($oCurrent);
        while (true)
        {
            if (in_array("{$oCurrent}", [
                ".",
                "/"
            ]))
            {
                return $oPathCollection;
            }
            $oCurrent = $oCurrent->dirname(1);
            $oPathCollection->add($oCurrent);
        }

    }

    /**
     * @param AbstractDataType $oPortionToReplace
     *
     * @return self
     * @throws NullPointerException
     */
    public function remove(AbstractDataType $oPortionToReplace):self
    {

        if($oPortionToReplace instanceof Regex)
        {
            return Path::make($oPortionToReplace->remove($this->getValue()));
        }
        elseif($oPortionToReplace instanceof RegexCollection)
        {
            return Path::make($oPortionToReplace->removeAll($this->getValue()));
        }
        return Path::make(str_replace("{$oPortionToReplace}", '', $this->getValue()));
    }

    /**
     * @param AbstractDataType $oSearch
     * @param AbstractDataType $oReplace
     *
     * @return self
     * @throws InvalidArgumentException
     */
    public function replace(AbstractDataType $oSearch, AbstractDataType $oReplace):self
    {
        if($oSearch instanceof Regex)
        {
            return Path::make(preg_replace($this->getValue(), "{$oSearch}", "{$oReplace}"));
        }
        $sResult = str_replace("{$oSearch}", "{$oReplace}", $this->getValue());

        return Path::make($sResult);
    }

    public function toPlainText(): PlainText
    {
        return new PlainText("{$this}");
    }

    /**
     *
     */
    public function makeDir(): self
    {
        FileSystem::makeDir($this);
        return $this;
    }

    public function getFinder(): Finder
    {
        if (!$this->isDir())
        {
            if($this->isFile())
            {
                throw new RuntimeException("Cannot provide Finder object on a file ($this)");
            }
            else
            {
                throw new RuntimeException("Cannot provide Finder object on a non existing dir ($this)");
            }

        }
        $oFinder = new Finder();
        $oFinder->in("{$this}");
        return $oFinder;
    }

    /**
     *
     */
    public function isDir(): bool
    {
        return is_dir($this);
    }

    /**
     * @return File
     * @throws InvalidArgumentException
     */
    public function getFile(): File
    {
        return new File("{$this}");
    }

    /**
     * @param Path|null $oSubtract
     *
     * @return PhpNamespace
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function toPsr4(PhpNamespace $prepend = null, Path $oSubtract = null): PhpNamespace
    {

        $sWorkPath = "{$this}";
        if ($oSubtract)
        {
            $sWorkPath = str_replace("{$oSubtract}", "", $sWorkPath);
            $sWorkPath = preg_replace('/^\\' . DIRECTORY_SEPARATOR . '/', '', $sWorkPath);
        }
        $sWorkPath = preg_replace('/\.php$/', '', $sWorkPath);
        $sNamespacePath = str_replace(DIRECTORY_SEPARATOR, '\\', $sWorkPath);
        return PhpNamespace::make($prepend, $sNamespacePath);
    }

    /**
     * @param int $iLevels = 1
     *
     * @return Path
     * @throws InvalidArgumentException
     */
    public function dirname(int $iLevels = 1): Path
    {
        return new Path(dirname($this, $iLevels));
    }

    /**
     * @return bool
     */
    public function isFile(): bool
    {
        return file_exists($this) && is_file($this);
    }

    /**
     * @return bool
     */
    public function isLink(): bool
    {
        return is_link($this);
    }

    /**
     * Recursively unlink a tree structure
     *
     * @return bool
     */
    public function unlinkRecursive(): bool
    {
        if ($this->isDir())
        {
            foreach ($this->getDirectoryIterator() as $oDirectoryIterator)
            {
                if ($oDirectoryIterator->isDot())
                {
                    continue;
                }

                $oPath = Path::make($oDirectoryIterator->getPathname());

                if ($oPath->isDir() && !$oPath->isLink())
                {
                    $oPath->unlinkRecursive();
                }
                else
                {
                    $oPath->unlink();
                }
            }
        }
        return $this->unlink();
    }

    /**
     * Unlink a file or directory if it exists
     *
     * @return bool
     */
    public function unlink(): bool
    {
        if (is_dir($this))
        {
            return rmdir($this);
        }
        elseif (file_exists($this) || is_link($this))
        {
            return @unlink($this);
        }
        return false;
    }

    /**
     * Renames the file or directory (if it exists) and sets the internal path to the new destination. Returns the path
     * of the destination also for method chaining.
     *
     * @param Path $oDestination
     *
     * @return $this
     */
    public function move(Path $oDestination): Path
    {
        if ($oDestination->isDir())
        {
            $oDestination = $oDestination->extend($this->basename());
        }
        rename($this, $oDestination);
        $this->setValue($oDestination);
        return $this;
    }

    /**
     * @return PlainText
     * @throws InvalidArgumentException
     */
    public function contents(): PlainText
    {
        return new PlainText(file_get_contents($this));
    }


    /**
     * @param int|null $time
     * @param int|null $atime
     *
     * @return $this
     */
    public function touch(int $time = null, int $atime = null): Path
    {
        if ($time === null)
        {
            $time = time();
        }
        if ($atime === null)
        {
            $atime = time();
        }
        touch("{$this}", $time, $atime);

        return $this;
    }

    /**
     * @param string $sSuffix = ''
     *
     * @return Path
     * @throws InvalidArgumentException
     */
    public function basename(string $sSuffix = ''): Path
    {
        return new Path(basename($this, $sSuffix));
    }

    /**
     *
     */
    public function exists(): bool
    {
        $sValue = $this->getValue();
        if (file_exists($sValue))
        {
            return true;
        }
        else
        {
            if (is_dir($sValue))
            {
                return true;
            }
            else
            {
                if (is_link($sValue))
                {
                    return true;
                }
            }
        }
        return false;
    }
}
