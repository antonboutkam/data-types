<?php

namespace Hurah\Types\Type\Composer;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Exception\NullPointerException;
use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\IComplexDataType;
use Hurah\Types\Type\IGenericDataType;

class RepositoryList extends AbstractDataType implements IGenericDataType, IComposerComponent, IComplexDataType, IComposerRootElement {

    /**
     * RepositoryList constructor.
     * @param null $aValue
     * @throws InvalidArgumentException
     */
    function __construct($aValue = null) {
        if (!is_iterable($aValue)) {
            throw new InvalidArgumentException("Constructor argument of RepositoryList must be iterable");
        }
        foreach ($aValue as $oValue) {
            if (!$oValue instanceof Repository) {
                throw new InvalidArgumentException("Expected an instance of Repository");
            }
        }
        parent::__construct($aValue);
    }

    function getKey(): string {
        return 'repositories';
    }

    /**
     * @return array
     * @throws InvalidArgumentException
     * @throws NullPointerException
     */
    function toArray(): array {
        $aOutput = [];
        $aRepositories = $this->getValue();
        if (is_iterable($aRepositories)) {
            foreach ($aRepositories as $oRepository) {
                if (!$oRepository instanceof Repository) {
                    throw new InvalidArgumentException("Expected an instance of " . Repository::class);
                }
                $aOutput[] = [
                    "type" => (string)$oRepository->getType(),
                    "url"  => (string)$oRepository->getLocation(),
                ];
            }
        }
        return $aOutput;
    }

}
