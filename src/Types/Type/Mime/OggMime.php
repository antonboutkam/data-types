<?php
namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Audio
 */
class OggMime extends AbstractMime
{
    public function getCode(): string
    {
        return 'ogg';
    }

    public function getContentTypes(): array
    {
        return ['audio/ogg'];
    }
}
