<?php

namespace Hurah\Types\Type\Mime;


/**
 * Generic type: Markup
 */
class HtmlMime extends AbstractMime
{

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'html';
    }

	public function getContentTypes(): array
	{
		return [
		  'text/html'
		];
	}
}
