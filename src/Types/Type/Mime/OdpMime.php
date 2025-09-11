<?php
namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Presentation
 */
class OdpMime extends AbstractMime
{
    public function getCode(): string
    {
        return 'odp';
    }

    public function getContentTypes(): array
    {
        return ['application/vnd.oasis.opendocument.presentation'];
    }
}
