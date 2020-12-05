<?php

namespace Hurah\Types\Type;

use Hurah\Types\Type\Composer\ServiceName;
use Hurah\Types\Type\Composer\Vendor;
use LogicException;

class SystemId extends AbstractDataType implements IGenericDataType {

    /**
     * SystemId constructor.
     * @param null $mValue
     */
    function __construct($mValue = null) {
        if (is_string($mValue)) {
            parent::__construct($mValue);
        } else {
            if (!isset($mValue[0]) || !$mValue[0] instanceof Vendor) {
                throw new LogicException("A System id must be made up out of a Vendor and a ServiceName");
            }
            if (!isset($mValue[1]) || !$mValue[1] instanceof ServiceName) {
                throw new LogicException("A System id must be made up out of a Vendor and a service_name");
            }
            parent::__construct(join('.', $mValue));
        }
    }

    static function make(Vendor $vendor, ServiceName $serviceName): self {
        return new SystemId([
            $vendor,
            $serviceName,
        ]);
    }

    function __toString(): string {
        $sValue = $this->getValue();
        return "{$sValue}";
    }

}
