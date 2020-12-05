<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\ClassNotFoundException;

class PhpNamespace extends AbstractDataType implements IGenericDataType {

    /**
     * @param mixed ...$allArguments
     * @return mixed
     */
    function getConstructed(...$allArguments) {
        $sClassName = $this->getValue();
        if (!class_exists($sClassName)) {
            throw new ClassNotFoundException("Class not found $sClassName.");
        }
        return new $sClassName(...$allArguments);
    }

    function getShortName(): string {
        if (preg_match('@\\\\([\w]+)$@', $this->getValue(), $matches)) {
            $className = $matches[1];
        }

        return $className;
    }

}
