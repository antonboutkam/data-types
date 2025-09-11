<?php
namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Video
 */
class Mp4Mime extends AbstractMime
{
    public function getCode(): string
    {
        return 'mp4';
    }

    public function getContentTypes(): array
    {
        return ['video/mp4'];
    }
}
