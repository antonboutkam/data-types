<?php

namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Unknown
 */
class XltmMime extends AbstractMime
{

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'xls';
    }

	public function getContentTypes(): array
	{
		return [
		  'application/vnd.ms-excel.template.macroEnabled.12'
		];
	}
}
