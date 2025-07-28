<?php
namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Presentation
 */
class PptMime extends AbstractMime
{
    public function getCode(): string
    {
        return 'ppt';
    }

    public function getContentTypes(): array
    {
        return ['application/vnd.ms-powerpoint'];
    }
}
