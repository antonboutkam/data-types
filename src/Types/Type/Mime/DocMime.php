<?php
namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Document
 */
class DocMime extends AbstractMime
{
    public function getCode(): string
    {
        return 'doc';
    }

    public function getContentTypes(): array
    {
        return ['application/msword'];
    }
}
