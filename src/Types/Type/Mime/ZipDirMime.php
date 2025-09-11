<?php

namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Archive
 */
class ZipDirMime extends AbstractMime implements Mime
{

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'zip';
    }

	public function getContentTypes(): array
	{
		return [
		  'application/zip'
		];
	}
}
