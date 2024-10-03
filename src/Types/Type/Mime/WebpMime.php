<?php

namespace Hurah\Types\Type\Mime;

/**
 * Class doc comment
 */
class WebpMime implements Mime, IContentType
{

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'image';
    }

    /**
     * @return string
     */
    final public function getContentType(): string
    {
        return 'image/webp';
    }
}
