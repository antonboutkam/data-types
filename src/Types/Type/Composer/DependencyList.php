<?php

namespace Hurah\Types\Type\Composer;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\IComplexDataType;
use Hurah\Types\Type\IGenericDataType;

class DependencyList extends AbstractDataType implements IGenericDataType, IComplexDataType, IComposerComponent {

    /**
     * ComposerStability constructor.
     * @param null $aValues
     * @throws InvalidArgumentException
     */
    function __construct($aValues = null) {

        if (is_iterable($aValues)) {
            foreach ($aValues as $oValue) {
                if (!$oValue instanceof Dependency) {
                    throw new InvalidArgumentException("Expected an array of ComposerDependency objects.");
                }
            }
        }

        parent::__construct($aValues);
    }

    function toArray(): array {
        $aOutput = [];
        $aDependencies = $this->getValue();
        if (is_iterable($aDependencies)) {
            foreach ($aDependencies as $oDependency) {
                $aOutput[$oDependency->getPackageName()] = $oDependency->getVersionName();
            }
        }
        return $aOutput;
    }

    /**
     * @return Dependency[]
     */
    function getValue(): array {
        return parent::getValue();
    }

    function findOne($sPackageName): ?Dependency {
        foreach ($this->getValue() as $dependency) {
            if ($dependency->getPackageName() === $sPackageName) {
                return $dependency;
            }
        }
        return null;
    }

    function hasDependency($sPackageName): bool {
        foreach ($this->getValue() as $dependency) {
            if ($dependency->getPackageName() === $sPackageName) {
                return true;
            }
        }
        return false;
    }

    function __toString(): string {
        return json_encode($this->getValue(), JSON_PRETTY_PRINT);
    }

}
