<?php

namespace Hurah\Types\Type;

class DnsName extends AbstractDataType implements IGenericDataType {

    /**
     * Add a subdomain part to the DNS name
     * @param string $subdomain
     * @return DnsName a new DnsName object wiht the subdomain added
     */
    function createSubdomain(string $subdomain): DnsName {
        return new self("{$subdomain}." . $this->getValue());
    }
}
