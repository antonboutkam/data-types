<?php

namespace Hurah\Types\Type;

use Error;
use Exception;
use Hurah\Types\Exception\InvalidArgumentException;
use phpDocumentor\Reflection\Types\Self_;
use ReflectionClass;
use LogicException;
use Hurah\Types\Exception\ClassNotFoundException;
use ReflectionException;
use function class_exists;

class PhpNamespace extends AbstractDataType implements IGenericDataType
{

    /**
     * @param mixed ...$allArguments
     * @return mixed
     * @throws ClassNotFoundException
     */
    public function getConstructed(...$allArguments)
    {
        $sClassName = $this->getValue();
        if (!class_exists($sClassName)) {
            throw new ClassNotFoundException("Class not found $sClassName.");
        }
        return new $sClassName(...$allArguments);
    }

    /**
     * Return the namespace part of the given class name, so like basename() in Path it will strip one level off.
     * @return $this
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function getNamespaceName():self
    {
        $aComponents = explode('\\', $this->getValue());
        array_pop($aComponents);
        return self::make($aComponents);
    }

    /**
     * @param bool $bAddLeadingSlash adds a leading slash if not already there
     *
     * @return string
     */
    public function getFqn(bool $bAddLeadingSlash = false):string
    {
        if($bAddLeadingSlash)
        {
            if(preg_match('@^\\\\@', $this->getValue()))
            {
                return $this->getValue();
            }
            return '\\' . $this->getValue();
        }
        return $this->getValue();

    }

    public function getShortName(): string
    {
        if (preg_match('@\\\\([\w]+)$@', $this->getValue(), $matches)) {
            return $matches[1];
        }

        throw new \Hurah\Types\Exception\LogicException("Could not shorten Namespace name {$this->getValue()}.");
    }

    /**
     * Creates a new PhpNamespace that does not have a leading slash.
     * @return $this
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public function removeLeadingSlash():self
    {
        $sNewValue = preg_replace('/^\\\/', '', $this->getValue());
        return self::make($sNewValue);
    }
    public function exists():bool
    {
        if(class_exists($this))
        {
            return true;
        }
        return false;
    }

    /**
     * @return PhpClassName
     * @throws InvalidArgumentException
     */
    public function toClassName():PhpClassName
    {
        return new PhpClassName($this->getShortName());
    }
    /**
     * Returns a new PhpNamespace instance with the extended part added. The current object is not touched.
     * @param mixed ...$aParts
     * @return $this
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public function extend(...$aParts):self{
        return self::make($this, $aParts);
    }

    /**
     * Removes a portion from the beginning of the namespace
     * @param mixed ...$aParts
     * @return $this
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public function shift(int $iLevels = 1):self {

        $aParts = explode('\\', $this->getValue());
        array_splice($aParts, 0, $iLevels);
        $oTmp = self::make($aParts);
        $this->setValue($oTmp->getValue());
        return $this;
    }


    /**
     * Adds something to the beginning of the namespace
     * @param mixed ...$aParts
     * @return $this
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public function prepend(...$aParts):self{

        if("{$this}")
        {
            $this->setValue((self::make($aParts, $this))->getValue());
        }
        else
        {
            $this->setValue((self::make($aParts))->getValue());
        }


        return $this;
    }


    /**
     * Adds something to the end of the namespace
     * @param mixed ...$aParts
     * @return $this
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public function append(...$aParts):self{
        $this->setValue((self::make($this, $aParts))->getValue());
        return $this;
    }

    /**
     * @param int $iLevels
     * @return $this
     */
    public function reduce(int $iLevels):self
    {
        try {
            $sCurrentNs = $this->getValue();
            $aCurrentNsComponents = explode('\\', $sCurrentNs);
            $iNewArrayLength = count($aCurrentNsComponents) - $iLevels;
            $aNewNsComponents = array_slice($aCurrentNsComponents, 0, $iNewArrayLength);
            $sNewNs = join('\\', $aNewNsComponents);
            return new PhpNamespace($sNewNs);
        }
        catch (InvalidArgumentException $e)
        {
            throw new Error("Could not reduce $sCurrentNs with $iLevels levels");
        }

    }
    public function isAbstract():bool
    {
        return $this->askReflector('isAbstract');
    }
    public function isFinal():bool
    {
        return $this->askReflector('isFinal');
    }
    public function getReflector():ReflectionClass
    {
        return new ReflectionClass("{$this}");

    }

    private function askReflector(string $sWhat):bool {
        try {
            $oReflector = new ReflectionClass("{$this}");

            if($oReflector->{$sWhat}())
            {
                return true;
            }
            return false;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

	public function isPartOf(PhpNamespace $oPhpNamespace):bool
	{
		$sHayStack = (string) $this->getValue();
		$sNeedle = (string) $oPhpNamespace;
		$sHayStack = preg_replace('/^\\\/', '', $sHayStack);
		$sNeedle = preg_replace('/^\\\/', '', $sNeedle);
		if($sHayStack === $sNeedle)
		{
			return true;
		}
		return strpos($sHayStack,$sNeedle . '\\') === 0;
	}

    public function implementsInterface($mInterfaceName):bool {
        try {
            $oReflector = new ReflectionClass("{$this}");
            if($oReflector->implementsInterface("{$mInterfaceName}"))
            {
                return true;
            }
            return false;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /**
     * @param mixed ...$aParts
     * @return static
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public static function make(...$aParts): self
    {
        $aUseParts = [];
        foreach ($aParts as $mPart) {
            if (is_null($mPart)) {
                continue;
            }
            if (is_array($mPart)) {
                $aUseParts[] =  join('\\', $mPart);
            } elseif (is_string($mPart)) {
                $aUseParts[] =  $mPart;
            } elseif (is_object($mPart) && $mPart instanceof self) {
                $aUseParts[] =  (string) $mPart;
            } elseif (is_object($mPart)) {
                $reflector = new ReflectionClass(get_class($mPart));
                $aUseParts[] = (string) $reflector->getNamespaceName();
            }
        }
        return new self(join('\\', $aUseParts));
    }
}
