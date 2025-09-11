<?php
namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Image
 */
class GifMime extends AbstractMime
{
    public function getCode(): string
    {
        return 'gif';
    }

    public function getContentTypes(): array
    {
        return ['image/gif'];
    }
}
