<?php

namespace Hurah\Types\Type\Mime;

/**
 * Class doc comment
 */

/**
 * Class doc comment
 */
class JpgMime implements Mime, IContentType
{

	/**
	 * @return string
	 */
	final public function getCode(): string
	{
		return 'image';
	}

	/**
	 * @return string
	 */
	final public function getContentType(): string
	{
		return 'image/jpeg';
	}
}
