<?php

namespace Hurah\Types\Type\Mime;

/**
 * Generic type: Dataset
 */
class CsvMime extends AbstractMime
{

	/**
	 * @return string
	 */
	final public function getCode(): string
    {
        return 'csv';
    }

	public function getContentTypes(): array
	{
		return [
		  'text/csv'
		];
	}
}
