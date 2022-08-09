<?php

namespace Hurah\Types\Type;


use SplFileInfo;
use function chmod;
use function clearstatcache;
use function file_get_contents;
use function file_put_contents;
use function fopen;
use function var_dump;
use const FILE_APPEND;

class File extends AbstractDataType implements IGenericDataType
{

    private SplFileInfo $oFile;
    private $fopenHandle = null;

    public function __construct($sFileName = null)
    {
        if ($sFileName) {
            $this->oFile = new SplFileInfo($sFileName);
        }
        parent::__construct('');
    }

    public static function fromSplFileInfo(SplFileInfo $oFile): self
    {
        $oResponse = new File();
        $oResponse->oFile = $oFile;
        return $oResponse;
    }
    public static function fromPath(Path $oPath):self
    {
        return new self($oPath->getValue());
    }

    public function asJson():Json
    {
        return new Json($this->getContents());
    }
    public function getContents():PlainText
    {
        return new PlainText(file_get_contents($this->oFile));
    }
    public function writeContents(AbstractDataType $oContents):File
    {
        file_put_contents("{$this}", "{$oContents}");
        clearstatcache();
        @chmod((string)"{$this}", 0777);
        return $this;
    }
    public function appendContents(AbstractDataType $oContents):File
    {
        file_put_contents("{$this}", "{$oContents}", FILE_APPEND);
        clearstatcache();
        @chmod((string)"{$this}", 0777);
        return $this;
    }

    public function fclose():void
    {
        if($this->fopenHandle)
        {
            fclose($this->fopenHandle);
        }
    }
    /**
     * Return the contents line by line
     * @return string|null
     */
    public function fgets():?string
    {
        if(!$this->fopenHandle)
        {
            $this->fopenHandle = fopen($this->oFile, 'r');
        }
        $sBuffer = fgets($this->fopenHandle, 4096);

        if($sBuffer === false)
        {
            fclose($this->fopenHandle);
        }
        return $sBuffer;
    }
    public function basename():string
    {
        return new Path($this->oFile->getBasename());
    }
    public function removeExtension():string
    {
        return $this->oFile->getBasename('.' . $this->oFile->getExtension());
    }
    public function getExtension():string
    {
        return $this->oFile->getExtension();
    }
    public function getType():string
    {
        return new Path($this->oFile->getType());
    }
    public function getATime():int
    {
        return $this->oFile->getATime();
    }
    public function getCTime():int
    {
        return $this->oFile->getCTime();
    }
    public function contents(): PlainText
    {
        return new PlainText(file_get_contents($this));
    }


    /**
     * Does a str_replace on the contents of the file
     * @param string $sSearch
     * @param string $sReplace
     * @return $this
     */
    public function replaceInContent(string $sSearch, string $sReplace): self
    {
        $sNewFileContents = str_replace($sSearch, $sReplace, $this->contents());
        file_put_contents($this->oFile->getPathname(), $sNewFileContents);
        return $this;
    }
    public function __toString(): string
    {
        return $this->oFile->getPathname();
    }
    public function exists():bool
    {
        if(file_exists("{$this}"))
        {
            return true;
        }
        return false;
    }
    public function create():File
    {
        if(!$this->exists())
        {
            touch($this);
            chmod($this, 0777);
        }
        return $this;
    }
}
