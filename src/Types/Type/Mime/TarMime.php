<?php

namespace Hurah\Types\Type\Mime;


/**
 * Generic type: Archive
 */
class TarMime extends AbstractMime implements Mime
{

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'tar';
    }

	public function getContentTypes(): array
	{
		return [
		  'application/x-tar',
		];
	}
}
