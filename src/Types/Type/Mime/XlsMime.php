<?php

namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Spreadsheet
 */
class XlsMime extends AbstractMime implements Mime
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
			// Moderne Excel formaten
		  'application/vnd.ms-excel'
		];
	}
}
