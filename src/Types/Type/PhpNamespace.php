<?php

namespace Hurah\Types\Type;

use Error;
use Exception;
use Hurah\Types\Exception\InvalidArgumentException;
use ReflectionClass;
use LogicException;
use Hurah\Types\Exception\ClassNotFoundException;
use ReflectionException;

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

    public function getShortName(): string
    {
        if (preg_match('@\\\\([\w]+)$@', $this->getValue(), $matches)) {
            return $matches[1];
        }

echo __METHOD__ . ':' . __LINE__ . PHP_EOL;
$aBacktrace = debug_backtrace();
foreach($aBacktrace as $aLine)
{
    echo $aLine['file'] . '::' . $aLine['line'] . PHP_EOL;
}
        throw new LogicException("Could not shorten Namespace name");

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
