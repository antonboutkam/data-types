<?php

namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Spreadsheet
 */
class OdsMime extends AbstractMime
{

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'ods';
    }

	public function getContentTypes(): array
	{
		return [
			// Moderne Excel formaten
		  'application/vnd.oasis.opendocument.spreadsheet'
		];
	}
}
