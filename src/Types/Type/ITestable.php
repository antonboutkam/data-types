<?php

namespace Hurah\Types\Type;

use function preg_match;

/**
 * Can be used to filter arrays or collections of items. The implementation can be a regular expression, a collection
 * of regular expressions, a callback function etc.
 */
interface ITestable
{
    public function test($sSubject): bool;
}