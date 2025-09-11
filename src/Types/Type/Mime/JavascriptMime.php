<?php

namespace Hurah\Types\Type\Mime;


/**
 * Generic type: Unknown
 */
class JavascriptMime extends AbstractMime
{
	/**
	 * @return string
	 */
	final public function getCode(): string
	{
		return 'js';
	}

	/**
	 * @return array
	 */
	final public function getContentTypes(): array
    {
        return ['application/javascript'];
    }


}
