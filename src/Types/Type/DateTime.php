<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;

class DateTime extends AbstractDataType implements IGenericDataType
{

    function __construct($sValue = null)
    {
        if($sValue instanceof \DateTime)
        {
            $this->setValue($sValue);
        }
        else if(is_int($sValue))
        {
            $oValue = new \DateTime();
            $oValue->setTimestamp($sValue);
            $this->setValue($oValue);
        }
        else if($sValue === null)
        {
            $this->setValue(null);
        }
        else
        {
            throw new InvalidArgumentException("Class DateTime expects a unix timestamp, a php DateTime object or null");
        }
        parent::__construct($sValue);
    }

    /**
     * Returns a Php \DateTime object
     * @return \Hurah\Types\Type\DateTime
     */
    public function toDateTime()
    {
        return $this->getValue();
    }
}
