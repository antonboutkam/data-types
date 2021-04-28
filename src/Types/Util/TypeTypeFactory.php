<?php

namespace Hurah\Types\Util;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Exception\RuntimeException;
use Hurah\Types\Type\IGenericDataType;
use Hurah\Types\Type\Path;
use Hurah\Types\Type\PhpNamespace;
use Hurah\Types\Type\TypeTypeCollection;
use ReflectionException;
use Symfony\Component\Finder\Finder;

class TypeTypeFactory {

    /**
     * @return TypeTypeCollection
     * @throws RuntimeException
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    public static function getAll():TypeTypeCollection
    {
        $oTypeTypeCollection = new TypeTypeCollection();

        $oFinder = new Finder();
        $oTypesDir = Path::make(__DIR__)->dirname(1)->extend('Type');

        // find all files in the current directory
        $oFinder->files()->in($oTypesDir)->name('*.php');

        if (!$oFinder->hasResults()) {
            throw new RuntimeException("No data types found in {$oTypesDir}");
        }

        foreach ($oFinder as $oFile) {
            $oPath = new Path($oFile->getRealPath());
            $oPotentialType = $oPath->toPsr4(new PhpNamespace('Hurah\\Types\\Type'), $oTypesDir);

            if($oPotentialType->implementsInterface(IGenericDataType::class))
            {
                $oTypeTypeCollection->add("{$oPotentialType}");
            }
        }
        return $oTypeTypeCollection;
    }
}
