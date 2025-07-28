<?php
namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Video
 */
class AviMime extends AbstractMime
{
    public function getCode(): string
    {
        return 'avi';
    }

    public function getContentTypes(): array
    {
        return ['video/x-msvideo'];
    }
}
