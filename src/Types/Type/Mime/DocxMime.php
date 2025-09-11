<?php
namespace Hurah\Types\Type\Mime;


class DocxMime extends AbstractMime
{
    public function getCode(): string
    {
        return 'docx';
    }

    public function getContentTypes(): array
    {
        return ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    }
}
