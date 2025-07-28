<?php

namespace Hurah\Types\Type\Mime;


/**
 * Generic type: Markup
 */
class XmlMime extends AbstractMime implements Mime
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
    final public function getContentTypes(): array
    {
        return ['text/xml'];
    }
}
