<?php

namespace Hurah\Types\Util;

use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\Json;
use function json_encode;

/**
 * Class JsonUtils
 *
 * @package Hurah\Types\Util
 */
final class JsonUtils
{

    /**
     * Wrapper for json_decode that throws when an error occurs.
     *
     * @param string $json JSON data to parse
     * @param bool $assoc When true, returned objects will be converted
     *                        into associative arrays.
     * @param int $depth User specified recursion depth.
     * @param int $options Bitmask of JSON decode options.
     *
     * @return mixed
     * @throws InvalidArgumentException if the JSON cannot be decoded.
     * @link http://www.php.net/manual/en/function.json-decode.php
     */
    public static function decode(string $json, bool $assoc = true, $depth = 512, $options = 0): mixed
	{
		$data = json_decode($json, $assoc, $depth, $options);
        if (JSON_ERROR_NONE !== json_last_error())
        {
            throw new InvalidArgumentException('json_decode error: ' . json_last_error_msg());
        }

        return $data;
    }

    /**
     * Wrapper for JSON encoding that throws when an error occurs.
     *
     * @param mixed $value The value being encoded
     * @param int $options JSON encode option bitmask
     * @param int $depth Set the maximum depth. Must be greater than zero.
     *
     * @return string
     * @throws InvalidArgumentException if the JSON cannot be encoded.
     * @link http://www.php.net/manual/en/function.json-encode.php
     */
    public static function encode(mixed $value, int $options = 0, int $depth = 512): Json|string
	{
        $json = json_encode($value, $options, $depth);
        if (JSON_ERROR_NONE !== json_last_error())
        {
            throw new InvalidArgumentException('json_encode error: ' . json_last_error_msg());
        }

        return new Json($json);
    }

	/**
	 * @param $string
	 *
	 * @return bool
	 */
    public static function isValidJson($string): bool
    {
        return is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string)));
    }
}
