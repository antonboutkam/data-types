<?php
namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Video
 */
class MovMime extends AbstractMime
{
    public function getCode(): string
    {
        return 'mov';
    }

    public function getContentTypes(): array
    {
        return ['video/quicktime'];
    }
}
