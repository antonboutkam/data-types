<?php

namespace Hurah\Types\Type\Composer;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\IGenericDataType;

class Stability extends AbstractDataType implements IGenericDataType, IComposerComponent {

    const DEV = 'dev';
    const ALPHA = 'alpha';
    const BETA = 'beta';
    const RC = 'rc';
    const STABLE = 'stable';

    /**
     * Stability constructor.
     * @param null $sValue
     * @throws InvalidArgumentException
     */
    function __construct($sValue = null) {

        if (!in_array($sValue, $this->validOptions())) {
            throw new InvalidArgumentException("Unsupported stability setting, must be one of " . join(', ', $this->validOptions()));
        }
        parent::__construct($sValue);
    }

    private function validOptions(): array {
        return [
            self::DEV,
            self::ALPHA,
            self::BETA,
            self::RC,
            self::STABLE,
        ];
    }

    function toArray(): array {
        return [$this->getValue()];
    }

}
