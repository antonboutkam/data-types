<?php

namespace Hurah\Types\Type\Mime;

/**
 * Class doc comment
 */

/**
 * Class doc comment
 */
class PlainTextMine implements Mime, IContentType
{

	/**
	 * @return string
	 */
	public function getContentType(): string
    {
        return 'text/plain';

    }

	/**
	 * @return string
	 */
	public function getCode(): string
    {
        return 'text';
    }
}
