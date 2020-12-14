<?php

namespace Hurah\Types\Type\Composer;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\IGenericDataType;

class Stability extends AbstractDataType implements IGenericDataType, IComposerComponent
{

    public const DEV = 'dev';
    public const ALPHA = 'alpha';
    public const BETA = 'beta';
    public const RC = 'rc';
    public const STABLE = 'stable';

    /**
     * Stability constructor.
     * @param null $sValue
     * @throws InvalidArgumentException
     */
    public function __construct($sValue = null)
    {

        if (!in_array($sValue, $this->validOptions())) {
            throw new InvalidArgumentException("Unsupported stability setting, must be one of " . join(', ', $this->validOptions()));
        }
        parent::__construct($sValue);
    }

    private function validOptions(): array
    {
        return [
            self::DEV,
            self::ALPHA,
            self::BETA,
            self::RC,
            self::STABLE,
        ];
    }

    public function toArray(): array
    {
        return [$this->getValue()];
    }
}
