<?php

namespace Hurah\Types\Util;

class ArrayUtils
{
    public static function isAssociative(array $arrayToTest):bool
    {
        $iFirstIndex = key($arrayToTest);
        if(is_string($iFirstIndex))
        {
            return true;
        }

        if($iFirstIndex !== 0)
        {
            foreach ($arrayToTest as $iItemIndex => $data)
            {
                if(!is_int($iItemIndex))
                {
                    return true;
                }
            }
        }

        if (array() === $arrayToTest) return false;
        return array_keys($arrayToTest) !== range(0, count($arrayToTest) - 1);
    }

    public static function isSequential(array $arrayToTest):bool {
        return !self::isAssociative($arrayToTest);
    }
}