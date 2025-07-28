<?php

namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Archive
 */
class RarMime extends AbstractMime implements Mime
{

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'rar';
    }

	public function getContentTypes(): array
	{
		return [
		  'application/vnd.rar',
		];
	}
}
