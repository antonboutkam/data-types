<?php
namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Image
 */
class SvgMime extends AbstractMime
{
    public function getCode(): string
    {
        return 'svg';
    }

    public function getContentTypes(): array
    {
        return ['image/svg+xml'];
    }
}
