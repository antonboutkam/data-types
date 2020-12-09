<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\FileNotFoundException;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\Composer\Author;
use Hurah\Types\Type\Composer\AuthorList;
use Hurah\Types\Type\Composer\Dependency;
use Hurah\Types\Type\Composer\DependencyList;
use Hurah\Types\Type\Composer\License;
use Hurah\Types\Type\Composer\Name;
use Hurah\Types\Type\Composer\Repository;
use Hurah\Types\Type\Composer\RepositoryList;
use Hurah\Types\Type\Composer\RepositoryType;
use Hurah\Types\Type\Composer\ServiceName;
use Hurah\Types\Type\Composer\Stability;
use Hurah\Types\Type\Composer\Vendor;
use Hurah\Types\Util\DirectoryStructure;
use Hurah\Types\Util\JsonUtils;

class Composer extends AbstractDataType implements IGenericDataType {

    /**
     * Composer constructor.
     * @param null $sValue
     * @throws InvalidArgumentException
     */
    function __construct($sValue = null) {
        parent::__construct($sValue);
        $this->setValue(JsonUtils::decode($sValue));
    }

    /**
     * @param array $aComposer
     * @return static
     */
    static function fromArray(array $aComposer): self {
        // Empty object required for construction to work.
        $self = new self('{}');
        $self->setValue($aComposer);
        return $self;
    }

    /**
     * @param Name $oPackageName
     * @return static
     * @throws FileNotFoundException|InvalidArgumentException
     */
    static function fromPackageName(Name $oPackageName): self {

        /** Bug in phpstorm, internal but we are in the same  */
        $oDirectoryStructure = new DirectoryStructure();
        $oComposerPath = $oDirectoryStructure->getVendorDir()->extend($oPackageName->getVendor(), $oPackageName->getProjectName(), 'composer.json');

        if (!$oComposerPath->exists()) {
            throw new FileNotFoundException("No composer.json file exists at $oComposerPath");
        }
        return self::fromPath($oComposerPath);
    }

    /**
     * @param Path $oPath
     * @return static
     * @throws InvalidArgumentException
     */
    static function fromPath(Path $oPath): self {
        return self::fromFile($oPath->getFile());
    }

    /**
     * @param File $oFile
     * @return static
     * @throws InvalidArgumentException
     */
    static function fromFile(File $oFile): self {
        return new Composer($oFile->contents());
    }

    /**
     * @return Author|null
     *
     * @throws InvalidArgumentException
     */
    function getAuthor(): ?Author {
        $mValue = $this->getValue();
        if (isset($mValue['authors'])) {
            return new Author(current($mValue['authors']));
        }
        if (isset($mValue['author'])) {
            return new Author($mValue['author']);
        }
        return null;
    }

    /**
     * @return AuthorList|null
     * @throws InvalidArgumentException
     */
    function getAuthorList(): ?AuthorList {
        $mValue = $this->getValue();
        if (isset($mValue['author_list'])) {
            return new AuthorList($mValue['author_list']);
        }
        return null;
    }

    /**
     * @param bool $bIncludeRequireDev
     * @return DependencyList|null
     * @throws InvalidArgumentException
     */
    function getDependencyList(bool $bIncludeRequireDev = false): ?DependencyList {
        $mValue = $this->getValue();
        $aDependencies = [];

        $aLocations[] = 'require';
        if ($bIncludeRequireDev) {
            $aLocations[] = 'require-dev';
        }
        foreach ($aLocations as $sLocation) {
            if (isset($mValue[$sLocation])) {
                foreach ($mValue[$sLocation] as $package => $version) {
                    $aDependencies[] = new Dependency([
                        'package' => $package,
                        'version' => $version,
                    ]);
                }
                return new DependencyList($aDependencies);
            }
        }
        return null;
    }

    /**
     * @return Dependency|null
     * @throws InvalidArgumentException
     */
    function getDependency(): ?Dependency {
        $mValue = $this->getValue();
        if (isset($mValue['dependency'])) {
            return new Dependency($mValue['dependency']);
        }
        return null;
    }

    /**
     * @return array|null
     *
     */
    function getExtra(): ?array {
        $mValue = $this->getValue();

        if (isset($mValue['extra'])) {
            return $mValue['extra'];
        }
        return null;
    }

    /**
     * @return License|null
     * @throws InvalidArgumentException
     */
    function getLicense(): ?License {
        $mValue = $this->getValue();
        if (isset($mValue['license'])) {
            return new License($mValue['license']);
        }
        return null;
    }

    /**
     * @return Name|null
     * @external
     */
    function getName(): ?Name {
        $mValue = $this->getValue();
        if (isset($mValue['name'])) {
            return new Name($mValue['name']);
        }
        return null;
    }

    /**
     * @return RepositoryList|null
     * @throws InvalidArgumentException
     */
    function getRepositoryList(): ?RepositoryList {
        $aItems = [];
        $mValue = $this->getValue();
        if (isset($mValue['repositories'])) {
            foreach ($mValue['repositories'] as $aRepository) {
                $aValues = [];
                $aValues['type'] = new RepositoryType($aRepository['type']);
                if ($aRepository['url']) {
                    $aValues['url'] = new Url($aRepository['url']);
                }
                if (isset($aRepository['path'])) {
                    $aValues['path'] = new Path($aRepository['path']);
                }

                $aItems[] = new Repository($aValues);
            }
        }
        return new RepositoryList($aItems);
    }

    /**
     * @return Repository|null
     * @throws InvalidArgumentException
     */
    function getRepository(): ?Repository {
        $mValue = $this->getValue();
        if (isset($mValue['repository'])) {
            return new Repository($mValue['repository']);
        }
        return null;
    }

    /**
     * @return PluginType|null
     * @throws InvalidArgumentException
     */
    function getType(): ?PluginType {
        $mValue = $this->getValue();
        if (isset($mValue['type'])) {
            $sType = preg_replace('/^(novum|huran)-/', '', $mValue['type']);
            return new PluginType($sType);
        }
        return null;
    }

    /**
     * @return RepositoryType|null
     * @throws InvalidArgumentException
     */
    function getRepositoryType(): ?RepositoryType {
        $mValue = $this->getValue();
        if (isset($mValue['repository_type'])) {
            return new RepositoryType($mValue['repository_type']);
        }
        return null;
    }

    /**
     * @return ServiceName|null
     */
    function getServiceName(): ?ServiceName {
        $mValue = $this->getValue();
        if (isset($mValue['service_name'])) {
            return new ServiceName($mValue['service_name']);
        }
        return null;
    }

    /**
     * @return Stability|null
     * @throws InvalidArgumentException
     */
    function getStability(): ?Stability {
        $mValue = $this->getValue();
        if (isset($mValue['stability'])) {
            return new Stability($mValue['stability']);
        }
        return null;
    }

    /**
     * @return Url|null
     */
    function getUrl(): ?Url {
        $mValue = $this->getValue();
        if (isset($mValue['url'])) {
            return new Url($mValue['url']);
        }
        return null;
    }

    /**
     * @return Vendor|null
     */
    function getVendor(): ?Vendor {
        $mValue = $this->getValue();
        if (isset($mValue['vendor'])) {
            return new Vendor($mValue['vendor']);
        }
        return null;
    }
}
