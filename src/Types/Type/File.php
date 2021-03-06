<?php

namespace Hurah\Types\Type;

use SplFileInfo;

class File extends AbstractDataType implements IGenericDataType
{

    private SplFileInfo $oFile;

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
    static function fromPath(Path $oPath):self
    {
        return new self($oPath->getValue());
    }

    function asJson():Json
    {
        return new Json($this->getContents());
    }
    function getContents():PlainText
    {
        return new PlainText(file_get_contents($this->getValue()));
    }

    public function basename():string
    {
        return new Path($this->oFile->getBasename());
    }
    public function getExtension():string
    {
        return new Path($this->oFile->getExtension());
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
