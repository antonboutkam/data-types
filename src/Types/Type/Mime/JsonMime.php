<?php

namespace Hurah\Types\Type\Mime;


/**
 * Generic type: SourceCode
 */
class JsonMime extends AbstractMime
{
	/**
	 * @return string
	 */
	final public function getCode(): string
	{
		return 'json';
	}

	/**
	 * @return string
	 */
	final public function getContentTypes(): array
    {
        return ['application/json'];
    }

}
