<?php

namespace Hurah\Types\Type\Mime;


/**
 * Generic type: Text
 */
class PlainTextMime extends AbstractMime implements Mime
{

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'txt';
    }

	public function getContentTypes(): array
	{
		return [
		  'text/plain'
		];
	}
}
