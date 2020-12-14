<?php

namespace Hurah\Types\Type\Composer;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\IComplexDataType;
use Hurah\Types\Type\IGenericDataType;

class Dependency extends AbstractDataType implements IGenericDataType, IComposerComponent, IComplexDataType
{

    /**
     * ComposerStability constructor.
     * @param null $aValue a tuple containing package => version
     * @throws InvalidArgumentException
     */
    public function __construct($aValue = null)
    {
        if (count($aValue) !== 2) {
            throw new InvalidArgumentException("A composer dependency consists of 2 parts, a package name and a version.");
        }
        if (isset($aValue[0])) {
            $aValue['package'] = $aValue[0];
            unset($aValue[0]);
        }
        if (isset($aValue[1])) {
            $aValue['version'] = $aValue[1];
            unset($aValue[1]);
        }
        parent::__construct($aValue);
    }

    public function getPackageName(): string
    {
        $aValue = $this->getValue();
        return $aValue['package'];
    }

    public function getVersionName(): string
    {
        $aValue = $this->getValue();
        return $aValue['version'];
    }

    public function toArray(): array
    {
        return $this->getValue();
    }
}
