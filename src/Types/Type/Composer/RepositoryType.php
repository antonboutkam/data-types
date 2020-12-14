<?php

namespace Hurah\Types\Type\Composer;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\IComplexDataType;
use Hurah\Types\Type\IGenericDataType;

class RepositoryType extends AbstractDataType implements IGenericDataType, IComposerComponent, IComplexDataType
{
    public const TYPE_PATH = 'path';
    public const TYPE_COMPOSER = 'composer';
    public const TYPE_VCS = 'vcs';

    /**
     * ComposerStability constructor.
     * @param null $sValue
     * @throws InvalidArgumentException
     */
    public function __construct($sValue = null)
    {
        if (!in_array($sValue, $this->getValidTypes())) {
            throw new InvalidArgumentException("Argument type must be one of " . join(', ', $this->getValidTypes()), " got $sValue");
        }
        parent::__construct($sValue);
    }

    /**
     * @return string[]
     */
    public function getValidTypes(): array
    {
        return [
            self::TYPE_PATH,
            self::TYPE_COMPOSER,
            self::TYPE_VCS,
        ];
    }

    public function getType(): string
    {
        $aValue = $this->getValue();
        return $aValue[0];
    }

    public function getUrl(): string
    {
        $aValue = $this->getValue();
        return $aValue[1];
    }

    public function toArray(): array
    {
        return $this->getValue();
    }
}
