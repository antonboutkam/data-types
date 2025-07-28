<?php
namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Audio
 */
class WavMime extends AbstractMime
{
    public function getCode(): string
    {
        return 'wav';
    }

    public function getContentTypes(): array
    {
        return ['audio/wav'];
    }
}
