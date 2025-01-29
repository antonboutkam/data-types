<?php /** @noinspection ALL */

namespace Hurah\Types\Type;


use Hurah\Types\Exception\ImplementationException;

class FileExtension extends AbstractDataType implements IGenericDataType, ITestable
{
    public function __construct($sFileType = null){
        $this->setValue($sFileType);
    }
    public static function fromString(string $sFileName): self
    {
        if(strpos($sFileName, '.'))
        {
            $ext = pathinfo($sFileName, PATHINFO_EXTENSION);
        }
        else
        {
            $ext = $sFileName;
        }

        return self::make($ext);
    }
    public static function fromFile(File $oFile):self
    {
        return self::fromString($oFile->getExtension());
    }

    public function getName():string
    {
        return $this->getValue();
    }
    public static function make(string $sFileTypeName): self
    {
        $result = new self($sFileTypeName);


        return $result;
    }




    public function test($sSubject):bool{
        if($sSubject instanceof AbstractDataType)
        {
            return (string) $this === (string) $sSubject;
        }
        elseif(is_string($sSubject))
        {
            return (string) $this === $sSubject;
        }
        if(is_object($sSubject))
        {
            throw new ImplementationException("Method not imlpemented for type: " . get_class($sSubject));
        }
        else
        {
            throw new ImplementationException("Method not imlpemented for type: " . gettype($sSubject));
        }
    }

    public function __toString():string
    {
        return '.' . $this->getValue();
    }

}
