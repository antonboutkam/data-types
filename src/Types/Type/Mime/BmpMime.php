<?php
namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Image
 */
class BmpMime extends AbstractMime
{
    public function getCode(): string
    {
        return 'bmp';
    }

    public function getContentTypes(): array
    {
        return ['image/bmp'];
    }
}
