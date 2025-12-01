<?php
namespace Hurah\Types\Type;

class PhoneNumber extends AbstractDataType implements IGenericDataType
{
    function __construct($phoneNumber = null)
    {

        $phoneNumber = str_replace('-', '', $phoneNumber);
        $phoneNumber = preg_replace('/\s+/', '', $phoneNumber);
        parent::__construct($phoneNumber);
    }

	public static function make(?string $phoneNumber = null):self
	{
		return new self($phoneNumber);
	}
}
