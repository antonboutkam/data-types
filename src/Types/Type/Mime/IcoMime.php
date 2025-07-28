<?php
namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Image
 */
class IcoMime extends AbstractMime
{
    public function getCode(): string
    {
        return 'ico';
    }

    public function getContentTypes(): array
    {
        return ['image/vnd.microsoft.icon'];
    }
}
