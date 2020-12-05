<?php

namespace Hurah\Types\Type\Composer;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\IComplexDataType;
use Hurah\Types\Type\IGenericDataType;

class AuthorList extends AbstractDataType implements IGenericDataType, IComplexDataType, IComposerComponent {
    /**
     * @param null $aValues
     * @throws InvalidArgumentException
     */
    function __construct($aValues = null) {
        if (is_iterable($aValues)) {
            foreach ($aValues as $oValue) {
                if (!$oValue instanceof Author) {
                    throw new InvalidArgumentException("Expected an array of Author objects.");
                }
            }
        }
        parent::__construct($aValues);
    }

    /**
     * @param array $aData an associative array with the optional fields role, email, name, url
     * @return AuthorList
     * @throws InvalidArgumentException
     */
    static function fromArray(array $aData): self {
        $aAuthors = [];
        foreach ($aData as $aRow) {
            $aAuthors[] = Author::fromArray($aRow);
        }
        return new AuthorList($aAuthors);
    }

    function toArray(): array {
        $aAuthors = [];
        $aValues = $this->getValue();
        if (is_iterable($aValues)) {
            foreach ($aValues as $oValue) {
                if ($oValue instanceof Author) {
                    $aAuthors[] = $oValue->toArray();
                }
            }
        }
        return $aAuthors;
    }

    function __toString(): string {
        $aOut = [];
        foreach ($this->getValue() as $oAuthor) {
            $aOut[] = (string)$oAuthor;
        }
        return json_encode($aOut, JSON_PRETTY_PRINT);
    }

}
