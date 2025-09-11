<?php

namespace Hurah\Types\Util;

class ArrayUtils
{

	/**
	 * Sorts the array based on the specified keys. All remaining elements are
	 * just appended.
	 *
	 * @param array $array The array to be sorted.
	 * @param array $keys The keys in the desired order.
	 * @return array The sorted array.
	 */
	public static function sortArrayByKeys(array $array, array $keys): array
	{
		$sortedArray = [];

		// Add elements according to the specified keys
		foreach ($keys as $key) {
			if (array_key_exists($key, $array)) {
				$sortedArray[$key] = $array[$key];
				unset($array[$key]);
			}
		}

		// Add the remaining elements
		return $sortedArray + $array;
	}


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
