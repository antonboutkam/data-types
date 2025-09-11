<?php

namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Unknown
 */
class FileMime extends AbstractMime implements Mime
{

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'file';
    }

	public function getContentTypes(): array
	{
		return [];
	}
}
