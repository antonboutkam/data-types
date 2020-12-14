<?php

namespace Hurah\Types\Type\Composer;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Exception\NullPointerException;
use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\IComplexDataType;
use Hurah\Types\Type\IGenericDataType;
use Hurah\Types\Type\IUri;

class Repository extends AbstractDataType implements IGenericDataType, IComposerComponent, IComplexDataType
{

    /**
     * ComposerStability constructor.
     * @param null $aValue an associative array containing type => Type and (path => Path or url => Url)
     * @throws InvalidArgumentException
     */
    public function __construct($aValue = null)
    {
        if (!isset($aValue['type'])) {
            throw new InvalidArgumentException("Argument type not set.");
        }
        if (!$aValue['type'] instanceof RepositoryType) {
            throw new InvalidArgumentException("Argument type must be an instance of RepositoryType.");
        }
        if (isset($aValue['path']) && isset($aValue['url'])) {
            throw new InvalidArgumentException("A repository must contain an url or a path, not both");
        }
        if (!isset($aValue['path']) && !isset($aValue['url'])) {
            throw new InvalidArgumentException("A repository must contain an url or a path");
        }

        if (count($aValue) !== 2) {
            throw new InvalidArgumentException("A composer dependency consists of 2 parts, a type name and a version.");
        }
        parent::__construct($aValue);
    }

    public function getType(): RepositoryType
    {
        return $this->getValue()['type'];
    }

    /**
     * @return IUri
     * @throws NullPointerException
     */
    public function getLocation(): IUri
    {
        $aValue = $this->getValue();
        if (isset($aValue[$this->getSourceType()])) {
            return $aValue[$this->getSourceType()];
        }

        throw new NullPointerException("Missing property url or path");
    }

    /**
     * @return string
     * @throws NullPointerException
     */
    public function getSourceType(): string
    {
        $aValue = $this->getValue();
        if (isset($aValue['url'])) {
            return 'url';
        } else {
            if (isset($aValue['path'])) {
                return 'path';
            }
        }
        throw new NullPointerException("Missing property url or path");
    }

    public function toArray(): array
    {
        return json_decode($this->getValue(), true);
    }
}
