<?php
namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Document
 */
class RtfMime extends AbstractMime
{
    public function getCode(): string
    {
        return 'rtf';
    }

    public function getContentTypes(): array
    {
        return ['application/rtf'];
    }
}
