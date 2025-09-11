<?php

namespace Hurah\Types\Type\Mime;


/**
 * Generic type: Unknown
 */
class PlainTextMine extends AbstractMime implements Mime
{

	/**
	 * @return string
	 */
	public function getContentTypes(): array
    {
        return ['text/plain'];

    }

	/**
	 * @return string
	 */
	public function getCode(): string
    {
        return 'text';
    }
}
