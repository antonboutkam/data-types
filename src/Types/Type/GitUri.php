<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;

class GitUri extends AbstractDataType implements IGenericDataType, IUri {
    function __construct($sValue = null) {
        if (!preg_match('/^(([A-Za-z0-9]+@|http(|s)\:\/\/)|(http(|s)\:\/\/[A-Za-z0-9]+@))([A-Za-z0-9.]+(:\d+)?)(?::|\/)([\d\/\w.-]+?)(\.git){1}$/i', $sValue)) {
            throw new InvalidArgumentException("The passed uri does not seem to be a valid Git repostory URI.");
        }
        parent::__construct($sValue);
    }

}



