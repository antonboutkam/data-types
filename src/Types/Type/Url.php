<?php

namespace Hurah\Types\Type;

use InvalidArgumentException;

class Url extends AbstractDataType implements IGenericDataType, IUri
{

    function __construct($sValue = null)
    {
        if($aParts = parse_url($sValue))
        {
            parent::__construct($aParts);
        }
        else
        {
            parent::__construct($sValue);
        }
    }

    /**
     * Adds levels / directories to the path portion of the url
     * @param mixed ...$aParts
     * @return Url
     */
    function addPath(...$aParts):self
    {
        foreach ($aParts as $mPart)
        {
            if(is_array($mPart))
            {
                $this->addPath($mPart);
            }
            elseif(is_string($mPart) || $mPart instanceof AbstractDataType)
            {
                // Implicit cast + remove trailing slash if needed
                $sCurrentPath = preg_replace('/\/$/', '', "{$this->getPath()}");

                // Implicit cast + remove leading slash if needed
                $mPart = preg_replace('/^\//', '', "{$mPart}");

                // Create new path
                $this->setPath($sCurrentPath . '/' . $mPart);

            }
            else
            {
                throw new InvalidArgumentException("Can only create a Path from AbstractDataType objects, strings or arrays");
            }
        }
        return $this;
    }

    /**
     * Overwrites the path component of the url.
     * @param string|null $sPath
     */
    function setPath(?string $sPath = null){
        $aComponents = $this->getValue();
        if($sPath === null)
        {
            unset($aComponents['path']);
        }
        else
        {
            $aComponents['path'] = $sPath;
        }

        $this->setValue($aComponents);
    }

    function getScheme():?string
    {
        return $this->getValue()['scheme'] ?? null;
    }
    function getUser():?string
    {
        return $this->getValue()['user'] ?? null;
    }
    function getPass():?string
    {
        return $this->getValue()['pass'] ?? null;
    }
    function getHost():?string
    {
        return $this->getValue()['host'] ?? null;
    }
    function getPort():?string
    {
        return $this->getValue()['port'] ?? null;
    }
    function getPath():?string
    {
        return $this->getValue()['path'] ?? null;
    }
    function getQuery():?string
    {
        return $this->getValue()['query'] ?? null;
    }
    function getFragment():?string
    {
        return $this->getValue()['fragment'] ?? null;
    }

    function __toString(): string
    {
        // If the url is parsable in the constructor we are keeping it internally as an array of all of it's components
        // when the url is not a valid url, just the # sign for instance, it is not parsable and we will return the
        // original string, so #.

        $mValue = $this->getValue();
        if(is_array($mValue))
        {
            return $this->buildUrl();
        }
        return $mValue;
    }

    private function buildUrl():string {
        $parts = $this->getValue();
        return (isset($parts['scheme']) ? "{$parts['scheme']}:" : '') .
            ((isset($parts['user']) || isset($parts['host'])) ? '//' : '') .
            (isset($parts['user']) ? "{$parts['user']}" : '') .
            (isset($parts['pass']) ? ":{$parts['pass']}" : '') .
            (isset($parts['user']) ? '@' : '') .
            (isset($parts['host']) ? "{$parts['host']}" : '') .
            (isset($parts['port']) ? ":{$parts['port']}" : '') .
            (isset($parts['path']) ? "{$parts['path']}" : '') .
            (isset($parts['query']) ? "?{$parts['query']}" : '') .
            (isset($parts['fragment']) ? "#{$parts['fragment']}" : '');
    }

}
