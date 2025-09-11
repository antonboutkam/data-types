<?php

namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Markup
 */
class RssMime extends AbstractMime implements Mime
{
	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'rss';
    }

	/**
	 * @return string
	 */
	final public function getContentTypes(): array
	{
		return ['application/rss+xml'];
	}
}
