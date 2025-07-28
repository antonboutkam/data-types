<?php

namespace Hurah\Types\Type\Mime;


/**
 * Generic type: Document
 */
class PdfMime extends AbstractMime
{
	final public function getCode(): string
	{
		return 'pdf';
	}
	/**
	 * @return string
	 */
	final public function getContentTypes(): array
    {
        return ['application/pdf'];
    }

	/**
	 * @return string
	 */

}
