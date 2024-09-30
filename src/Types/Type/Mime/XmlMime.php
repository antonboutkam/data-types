<?php

namespace Hurah\Types\Type\Mime;

/**
 * Class doc comment
 */

/**
 * Class doc comment
 */
class XmlMime implements Mime, IContentType
{

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'xml';
    }

    /**
     * @return string
     */
    final public function getContentType(): string
    {
        return 'text/xml';
    }
}
