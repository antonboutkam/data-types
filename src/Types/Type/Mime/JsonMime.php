<?php

namespace Hurah\Types\Type\Mime;

/**
 * Class doc comment
 */

/**
 * Class doc comment
 */
class JsonMime implements Mime, IContentType
{

	/**
	 * @return string
	 */
	final public function getContentType(): string
    {
        return 'application/json';
    }

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'json';
    }
}
