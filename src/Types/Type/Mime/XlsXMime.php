<?php

namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Spreadsheet
 */
class XlsXMime extends AbstractMime implements Mime
{

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'xlsx';
    }

	public function getContentTypes(): array
	{
		return [
		  'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
		];
	}
}
