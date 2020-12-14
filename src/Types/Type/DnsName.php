<?php

namespace Hurah\Types\Type;

use Hurah\Types\Exception\InvalidArgumentException;

class DnsName extends AbstractDataType implements IGenericDataType
{

    /**
     * Add a subdomain part to the DNS name
     * @param string $subdomain
     * @return DnsName a new DnsName object wiht the subdomain added
     */
    public function createSubdomain(string $subdomain): DnsName
    {
        return new self("{$subdomain}." . $this->getValue());
    }

    /**
     * @param string $sDnsName
     * @return static
     * @throws InvalidArgumentException
     */
    public static function fromString(string $sDnsName): self
    {
        if (!self::validate($sDnsName)) {
            throw new InvalidArgumentException("$sDnsName is not a valid DNS name");
        }
        return new self($sDnsName);
    }

    public static function validate(string $sDnsName): bool
    {
        return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $sDnsName) //valid chars check
            && preg_match("/^.{1,253}$/", $sDnsName) //overall length check
            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $sDnsName)); //length of each label
    }
}
