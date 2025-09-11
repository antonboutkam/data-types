<?php

namespace Hurah\Types\Type\Mime;


/**
 * Generic type: SourceCode
 * Represents a json file
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
