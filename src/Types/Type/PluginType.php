<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;

class PluginType extends AbstractDataType implements IGenericDataType
{

    const SITE = 'site';
    const API = 'api';
    const DOMAIN = 'domain';
    const MODULE = 'module';

    /**
     * PluginType constructor.
     * @param null $sValue
     * @throws InvalidArgumentException
     */
    public function __construct($sValue = null)
    {

        if (!in_array($sValue, $this->validOptions())) {
            throw new InvalidArgumentException("Unsupported plugin type, value must be one of " . join(', ', $this->validOptions()));
        }
        parent::__construct($sValue);
    }

    private function validOptions(): array
    {
        return [
            self::SITE,
            self::API,
            self::DOMAIN,
            self::MODULE,
        ];
    }

    /**
     * @return PluginType[]
     * @throws InvalidArgumentException
     */
    public static function getAll(): array
    {
        $aTypes = [
            self::SITE,
            self::API,
            self::DOMAIN,
            self::MODULE,
        ];
        $aOut = [];
        foreach ($aTypes as $sType) {
            $aOut[] = new self($sType);
        }
        return $aOut;
    }

    public static function hasDomainDependency(string $sType): bool
    {
        return in_array($sType, self::pluginsWithDomainDependency());
    }

    private static function pluginsWithDomainDependency(): array
    {
        return [
            self::API,
            self::SITE,
        ];
    }
}
