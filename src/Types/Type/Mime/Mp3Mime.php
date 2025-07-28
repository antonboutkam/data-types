<?php
namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Audio
 */
class Mp3Mime extends AbstractMime
{
    public function getCode(): string
    {
        return 'mp3';
    }

    public function getContentTypes(): array
    {
        return ['audio/mpeg'];
    }
}
