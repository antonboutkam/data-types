<?php

namespace Hurah\Types\Type\Mime;

/**
 * Class doc comment
 */

/**
 * Class doc comment
 */
class PdfMime implements Mime, IContentType
{

	/**
	 * @return string
	 */
	final public function getContentType(): string
    {
        return 'application/pdf"';
    }

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'pdf';
    }
}
