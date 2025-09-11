<?php
namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Video
 */
class WebmMime extends AbstractMime
{
    public function getCode(): string
    {
        return 'webm';
    }

    public function getContentTypes(): array
    {
        return ['video/webm'];
    }
}
