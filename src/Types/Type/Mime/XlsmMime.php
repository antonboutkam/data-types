<?php

namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Spreadsheet
 */
class XlsmMime extends AbstractMime implements Mime
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
		  'application/vnd.ms-excel.sheet.macroEnabled.12'
		];
	}
}
