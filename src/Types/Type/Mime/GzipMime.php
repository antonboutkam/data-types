<?php

namespace Hurah\Types\Type\Mime;

use Hurah\Types\Type\ITestable;

/**
 * Generic type: Archive
 */
class GzipMime extends AbstractMime
{

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'gz';
    }

	public function getContentTypes(): array
	{
		return [
		  'application/gzip'
		];
	}
}
