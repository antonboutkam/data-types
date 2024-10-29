<?php

namespace Hurah\Types\Type;

use Hurah\Types\Type\Http\Response;
use InvalidArgumentException;
use function curl_setopt;

class Url extends AbstractDataType implements IGenericDataType, IUri
{

	/**
	 * Not sure why but packagist is not updating this.
	 * @param $sValue
	 */
    public function __construct($sValue = null)
    {
        if ($sValue && $aParts = parse_url($sValue))
        {
            parent::__construct($aParts);
        }
        else
        {
            parent::__construct($sValue);
        }
    }
    public function get($aOptions = ['USER_AGENT' => 'Hurah', 'CONNECT_TIMEOUT' => 2]):Response
    {
        $curl_handle = \curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, "{$this}");
		curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, $aOptions['CONNECT_TIMEOUT']);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handle, CURLOPT_HEADER, 1);
		curl_setopt($curl_handle, CURLOPT_USERAGENT, $aOptions['USER_AGENT']);


        $headers = [];
        // this function is called by curl for each header received
		curl_setopt($curl_handle, CURLOPT_HEADERFUNCTION,
            function($curl, $header) use (&$headers)
            {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
                    return $len;

                $headers[trim($header[0])][] = trim($header[1]);

                return $len;
            }
        );

        $sData = curl_exec($curl_handle);


        $aData = explode(PHP_EOL, $sData);
        $bHeadersDone = false;
        $aBody = [];
        foreach ($aData as $i => $sRow)
        {
            if(empty(trim($sRow)))
            {
                $bHeadersDone = true;
            }
            if($bHeadersDone)
            {
                $aBody[] = $sRow;
            }
        }

        $iStatusCode = null;
        // Check HTTP status code
        if (!curl_errno($curl_handle)) {
            $iStatusCode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
        }


        return new Response([
            'body' => join(PHP_EOL, $aBody),
            'statusCode' => $iStatusCode,
            'headers' => $headers,


        ]);


    }

	/**
	 * @return PlainText
	 */
    public function toPlainText(): PlainText
    {
        return new PlainText($this);
    }
    /**
     * @param mixed $mPattern
     *
     * @return bool
     */
    public function matches(mixed $mPattern): bool
    {
        if ($mPattern instanceof self)
        {
            return "{$this}" === "{$mPattern}";
        }
        else
        {
            if (is_string($mPattern))
            {
                return "{$this}" === $mPattern;
            }
        }
        throw new InvalidArgumentException("Unexpected type passed to Url::matches");
    }

    public function addQuery(...$aParts): self
    {
        $aComponents = $this->getValue();
        $sQuery = $aComponents['query'] ?? null;
        foreach ($aParts as $mPart)
        {
            if (is_array($mPart))
            {
                $sQueryAdd = http_build_query($mPart);
            }
            else
            {
                if (is_string($mPart))
                {
                    $sQueryAdd = $mPart;
                }
                else
                {
                    throw new InvalidArgumentException("Could not turn variable into valid get string");
                }
            }

            if ($sQuery)
            {
                $sQuery = $sQuery . '&' . $sQueryAdd;
            }
            else
            {
                $sQuery = $sQueryAdd;
            }
        }

        parse_str($sQuery, $aResult);
        $sQuery = http_build_query($aResult);

        $this->setQuery($sQuery);
        return $this;
    }

    /**
     * Adds levels / directories to the path portion of the url
     *
     * @param mixed ...$aParts
     *
     * @return Url
     */
    public function addPath(...$aParts): self
    {
        foreach ($aParts as $mPart)
        {
            if (is_array($mPart))
            {
                $this->addPath($mPart);
            }
            elseif (is_string($mPart) || $mPart instanceof AbstractDataType)
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

    public function setQuery(string $sQuery = null): self
    {
        $aComponents = $this->getValue();
        if ($sQuery === null)
        {
            unset($aComponents['query']);
        }
        else
        {
            $aComponents['query'] = $sQuery;
        }

        $this->setValue($aComponents);
        return $this;
    }

    /**
     * Overwrites the path component of the url.
     *
     * @param string|null $sPath
     *
     * @return Url
     */
    public function setPath(?string $sPath = null): self
    {
        $aComponents = $this->getValue();
        if ($sPath === null)
        {
            unset($aComponents['path']);
        }
        else
        {
            $aComponents['path'] = $sPath;
        }

        $this->setValue($aComponents);
        return $this;
    }

    public function getScheme(): ?string
    {
        return $this->getValue()['scheme'] ?? null;
    }

    public function getUser(): ?string
    {
        return $this->getValue()['user'] ?? null;
    }

    public function getPass(): ?string
    {
        return $this->getValue()['pass'] ?? null;
    }

    public function getHost(): ?string
    {
        return $this->getValue()['host'] ?? null;
    }

    public function getPort(): ?string
    {
        return $this->getValue()['port'] ?? null;
    }

    public function getPath(): ?string
    {
        return $this->getValue()['path'] ?? null;
    }

    public function getQuery(): ?string
    {
        return $this->getValue()['query'] ?? null;
    }

    public function getFragment(): ?string
    {
        return $this->getValue()['fragment'] ?? null;
    }

    public function __toString(): string
    {
        // If the url is parsable in the constructor we are keeping it internally as an array of all of it's components
        // when the url is not a valid url, just the # sign for instance, it is not parsable and we will return the
        // original string, so #.

        $mValue = $this->getValue();
        if (is_array($mValue))
        {
            return $this->buildUrl();
        }
        return $mValue;
    }

    private function buildUrl(): string
    {
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
