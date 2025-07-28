<?php

namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Image
 */
class WebpMime extends AbstractMime
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
    final public function getContentTypes(): array
    {
        return ['image/webp'];
    }
}
