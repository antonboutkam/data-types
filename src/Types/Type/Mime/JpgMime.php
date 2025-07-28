<?php

namespace Hurah\Types\Type\Mime;


/**
 * Generic type: Image
 */
class JpgMime extends AbstractMime implements Mime
{

	/**
	 * @return string
	 */
	final public function getCode(): string
	{
		return 'jpg';
	}

	/**
	 * @return string
	 */
	final public function getContentTypes(): array
	{
		return ['image/jpeg'];
	}
}
