<?php
namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Image
 */
class TiffMime extends AbstractMime
{
    public function getCode(): string
    {
        return 'tiff';
    }

    public function getContentTypes(): array
    {
        return ['image/tiff'];
    }
}
