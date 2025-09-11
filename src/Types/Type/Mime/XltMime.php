<?php

namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Unknown
 */
class XltMime extends AbstractMime implements Mime
{

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'xlt';
    }

	public function getContentTypes(): array
	{
		return [
		  'application/vnd.ms-excel'
		];
	}
}
