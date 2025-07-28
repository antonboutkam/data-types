<?php
namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Email
 */
class EmlMime extends AbstractMime
{
    public function getCode(): string
    {
        return 'eml';
    }

    public function getContentTypes(): array
    {
        return ['message/rfc822'];
    }
}
