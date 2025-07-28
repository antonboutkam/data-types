<?php

namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Unknown
 */
class XltxMime extends AbstractMime
{

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'xltx';
    }

	public function getContentTypes(): array
	{
		return [
			// Moderne Excel formaten
		  'application/vnd.openxmlformats-officedocument.spreadsheetml.template'
		];
	}
}
