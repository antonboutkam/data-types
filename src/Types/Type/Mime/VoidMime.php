<?php

namespace Hurah\Types\Type\Mime;


/**
 * Generic type: Void
 */
class VoidMime extends AbstractMime implements Mime
{

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'void';
    }

	public function getContentTypes(): array
	{
		return [];
	}
}
