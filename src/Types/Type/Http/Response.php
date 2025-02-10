<?php

namespace Hurah\Types\Type\Http;

use Hurah\Types\Exception\ImplementationException;
use Hurah\Types\Type\AbstractDataType;
use Hurah\Types\Type\KeyValueCollection;
use Hurah\Types\Type\LiteralInteger;
use Hurah\Types\Type\PlainText;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response extends AbstractDataType implements ResponseInterface
{

    private PlainText $body;
    private LiteralInteger $statusCode;
    private PlainText $reason;
    private KeyValueCollection $headers;

    public function __construct($sValue = null)
    {
        $aValue = $sValue;
        $this->headers = new KeyValueCollection();

        if(isset($aValue['body']) && is_string($aValue['body']))
        {
            $this->body = new PlainText($aValue['body']);
        }
        elseif(isset($aValue['body']) && $aValue['body'] instanceof PlainText)
        {
            $this->body = $aValue['body'];
        }

        if(isset($aValue['statusCode']) && is_int($aValue['statusCode']))
        {
            $this->statusCode = new LiteralInteger($aValue['statusCode']);
        }
        elseif(isset($aValue['statusCode']) && is_string($aValue['statusCode']))
        {
            $this->statusCode = new LiteralInteger($aValue['statusCode']);
        }
        elseif(isset($aValue['statusCode']) && $aValue['statusCode'] instanceof LiteralInteger)
        {
            $this->statusCode = new LiteralInteger($aValue['statusCode']);
        }

        if(isset($aValue['headers']))
        {
            foreach ($aValue['headers'] as $sName => $Value)
            {
                $this->headers->addKeyValue($sName, $sValue);
            }
        }

        parent::__construct($sValue);
    }


    /**
     * @inheritDoc
     */
    public function getProtocolVersion()
    {
        throw new ImplementationException("Method not implemented yet");
    }

    /**
     * @inheritDoc
     */
    public function withProtocolVersion($version)
    {
        throw new ImplementationException("Method not implemented yet");
    }

    /**
     * @inheritDoc
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @inheritDoc
     */
    public function hasHeader($name)
    {
        return $this->headers->hasKeyInsensitive($name);
    }

    /**
     * @inheritDoc
     */
    public function getHeader($name)
    {
        return $this->headers->getByKeyInsensitive($name);
    }

    /**
     * @inheritDoc
     */
    public function getHeaderLine($name)
    {
        throw new ImplementationException("Method not implemented yet");
    }

    /**
     * @inheritDoc
     */
    public function withHeader($name, $value)
    {
        $this->headers->addKeyValue($name, $value);
    }

    /**
     * @inheritDoc
     */
    public function withAddedHeader($name, $value)
    {
        $this->headers->addKeyValue($name, $value);
    }

    /**
     * @inheritDoc
     */
    public function withoutHeader($name)
    {
        // TODO: Implement withoutHeader() method.
    }

    /**
     * @inheritDoc
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @inheritDoc
     */
    public function withBody(StreamInterface $body)
    {
        $this->body = new PlainText($body);
    }

    /**
     * @inheritDoc
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @inheritDoc
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        $this->statusCode = new LiteralInteger($code);
        $this->reason = $reasonPhrase;

    }

    /**
     * @inheritDoc
     */
    public function getReasonPhrase()
    {
        return $this->reason;
    }
}