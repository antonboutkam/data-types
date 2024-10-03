<?php

namespace Hurah\Types\Type\Mime;

/**
 * Class doc comment
 */

/**
 * Class doc comment
 */
class RssMime implements Mime, IContentType
{

	/**
	 * @return string
	 */
	final public function getContentType(): string
    {
        return 'application/rss+xml';
    }

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'rss';
    }
}
