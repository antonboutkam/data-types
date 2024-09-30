<?php

namespace Hurah\Types\Type\Mime;

/**
 * Class doc comment
 */

/**
 * Class doc comment
 */
class JavascriptMime implements Mime, IContentType
{

	/**
	 * @return string
	 */
	final public function getContentType(): string
    {
        return 'application/javascript';
    }

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'js';
    }
}
