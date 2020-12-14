<?php

namespace Hurah\Types\Type\Composer;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\IGenericDataType;

class License extends AbstractDataType implements IGenericDataType, IComposerComponent
{

    public const NONE = null;
    public const APACHE2_0 = 'Apache-2.0';
    public const BSD2_CLAUSE = 'BSD-2-Clause';
    public const BSD3_CLAUSE = 'BSD-3-Clause';
    public const BSD4_CLAUSE = 'BSD-4-Clause';
    public const GPL2_0_ONLY = 'GPL-2.0-only / GPL-2.0-or-later';
    public const GPL3_0_ONLY = 'GPL-3.0-only / GPL-3.0-or-later';
    public const LGPL2_1_ONLY = 'LGPL-2.1-only / LGPL-2.1-or-later';
    public const LGPL3_0_ONLY = 'LGPL-3.0-only / LGPL-3.0-or-later';
    public const MIT = 'MIT';

    /**
     * License constructor.
     * @param null $sValue
     * @throws InvalidArgumentException
     */
    public function __construct($sValue = null)
    {

        if (!in_array($sValue, self::availableLicenses())) {
            throw new InvalidArgumentException("Unsupported license value, see here for valid options: https://getcomposer.org/doc/04-schema.md#license");
        }
        parent::__construct($sValue);
    }

    public static function availableLicenses(): array
    {
        return [
            self::APACHE2_0,
            self::BSD2_CLAUSE,
            self::BSD3_CLAUSE,
            self::BSD4_CLAUSE,
            self::GPL2_0_ONLY,
            self::GPL3_0_ONLY,
            self::LGPL2_1_ONLY,
            self::LGPL3_0_ONLY,
            self::MIT,
        ];
    }
}
