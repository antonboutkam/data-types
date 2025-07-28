<?php
namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Document
 */
class OdtMime extends AbstractMime
{
    public function getCode(): string
    {
        return 'odt';
    }

    public function getContentTypes(): array
    {
        return ['application/vnd.oasis.opendocument.text'];
    }
}
