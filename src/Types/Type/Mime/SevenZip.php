<?php

namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Archive
 */
class SevenZip extends AbstractMime
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
		  'application/x-7z-compressed',
		];
	}
}
