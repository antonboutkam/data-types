<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;

class GitUri extends AbstractDataType implements IGenericDataType, IUri {
    function __construct($sValue = null) {
        if (!preg_match('#((git|ssh|http(s)?)|(git@[\w\.]+))(:(//)?)([\w\.@\:/\-~]+)(\.git)(/)?#', $sValue)) {
            throw new InvalidArgumentException("The passed uri does not seem to be a valid Git repostory URI.");
        }
        parent::__construct($sValue);
    }

}



