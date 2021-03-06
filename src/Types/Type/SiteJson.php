<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Util\FileSystem;
use Hurah\Types\Util\JsonUtils;

/**
 * Access the site.json file that can be found in each site directory in an object oriented way
 * Class SiteJson
 * @package Hurah\Types\Type
 */
class SiteJson extends AbstractDataType implements IGenericDataType
{
    /**
     * SiteJson constructor.
     * @param null $sValue
     * @throws InvalidArgumentException
     */
    public function __construct($sValue = null)
    {
        $sPath = str_replace(DIRECTORY_SEPARATOR . 'site.json', '', $sValue);
        $sPath = FileSystem::makePath($sPath, 'site.json');
        $sJson = file_get_contents($sPath);

        parent::__construct(JsonUtils::decode($sJson, true));
    }

    public function getSystemId(): SystemId
    {
        return new SystemId($this->getValue()['config_dir']);
    }

    public function getNamespace(): PhpNamespace
    {
        return new PhpNamespace($this->getValue()['namespace']);
    }

    public function getServerAdmin(): Email
    {
        return new Email($this->getValue()['server_admin']);
    }

    /**
     * @return string[]
     */
    public function getEnvironments(): array
    {
        return array_keys($this->getValue()['site']);
    }

    public function getDomain(string $sEnv = 'live'): array
    {
        return $this->getValue()['site'][$sEnv];
    }
}
