<?php

namespace Hurah\Types\Type\Composer;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\IComplexDataType;
use Hurah\Types\Type\IGenericDataType;

class RepositoryType extends AbstractDataType implements IGenericDataType, IComposerComponent, IComplexDataType {
    const TYPE_PATH = 'path';
    const TYPE_COMPOSER = 'composer';
    const TYPE_VCS = 'vcs';

    /**
     * ComposerStability constructor.
     * @param null $sValue
     * @throws InvalidArgumentException
     */
    function __construct($sValue = null) {
        if (!in_array($sValue, $this->getValidTypes())) {
            throw new InvalidArgumentException("Argument type must be one of " . join(', ', $this->getValidTypes()), " got $sValue");
        }
        parent::__construct($sValue);
    }

    /**
     * @return string[]
     */
    function getValidTypes(): array {
        return [
            self::TYPE_PATH,
            self::TYPE_COMPOSER,
            self::TYPE_VCS,
        ];
    }

    function getType(): string {
        $aValue = $this->getValue();
        return $aValue[0];
    }

    function getUrl(): string {
        $aValue = $this->getValue();
        return $aValue[1];
    }

    function toArray(): array {
        return $this->getValue();
    }
}
