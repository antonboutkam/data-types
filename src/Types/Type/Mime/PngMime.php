<?php

namespace Hurah\Types\Type\Mime;


/**
 * Generic type: Image
 */
class PngMime extends AbstractMime
{

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'png';
    }

    /**
     * @return string
     */
    final public function getContentTypes(): array
    {
        return ['image/png'];
    }
}
