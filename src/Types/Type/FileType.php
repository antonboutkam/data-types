<?php /** @noinspection ALL */

namespace Hurah\Types\Type;


use SplFileInfo;
use function chmod;
use function clearstatcache;
use function file_get_contents;
use function file_put_contents;
use function fopen;
use function var_dump;
use const FILE_APPEND;

class FileType extends AbstractDataType implements IGenericDataType, ITestable
{

    private ITestable $mFileNamePatterns;

    public function __construct($sFileType = null){
        $this->mFileNamePatterns = new TestableCollection();
        $this->setValue($sFileType);
    }
    public static function fromExtension(string $sFileExtension): self
    {
        $sWithoutLeadingDot = preg_replace('/^\./', '', $sFileExtension);
        $oTest = new Regex('/^(.+)\.' . $sWithoutLeadingDot . '$/');
        return self::make($sWithoutLeadingDot, $oTest);
    }
    public function getName():string
    {
        return $this->getValue();
    }
    public static function make(string $sFileTypeName, ?ITestable $mFileNamePatterns = null): self
    {
        $result = new self($sFileTypeName);

        if($mFileNamePatterns)
        {
            $result->setFileNamePatterns($mFileNamePatterns);
        }
        return $result;
    }
    public function addFileNamePatterns(ITestable $mFileNamePatterns)
    {
        $this->mFileNamePatterns->add($mFileNamePatterns);
    }

    public function setFileNamePatterns(ITestable $mFileNamePatterns)
    {
        if($mFileNamePatterns instanceof TestableCollection)
        {
            $this->mFileNamePatterns = $mFileNamePatterns;
        }
        else
        {
            $mTestableCollection = new TestableCollection();
            $mTestableCollection->add($mFileNamePatterns);
            $this->mFileNamePatterns = $mTestableCollection;
        }
    }

    public function getFileNamePatterns():TestableCollection
    {
        return $this->mFileNamePatterns;
    }

    public function test($sSubject):bool{

        if(!isset($this->mFileNamePatterns))
        {
            return false;
        }
        return $this->mFileNamePatterns->test($sSubject);
    }

    public function __toString():string
    {
        return $this->getValue();
    }

}
