<?php
namespace Hurah\Types\Type;

class PhoneNumber extends AbstractDataType implements IGenericDataType
{
    function __construct($sPathName = null)
    {

        $sPathName = str_replace('-', '', $sPathName);
        $sPathName = preg_replace('/\s+/', '', $sPathName);
        parent::__construct($sPathName);
    }
}
