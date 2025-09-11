<?php
namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Presentation
 */
class PptxMime extends AbstractMime
{
    public function getCode(): string
    {
        return 'pptx';
    }

    public function getContentTypes(): array
    {
        return ['application/vnd.openxmlformats-officedocument.presentationml.presentation'];
    }
}
