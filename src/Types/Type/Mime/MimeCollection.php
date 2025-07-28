<?php

namespace Hurah\Types\Type\Mime;

use Hurah\Types\Type\AbstractCollectionDataType;

/**
 *
 */
class MimeCollection extends AbstractCollectionDataType
{
	public function current(): Mime
	{
		return $this->array[$this->position];
	}
	public function add(Mime $mime):void
	{
		$this->array[] = $mime;
	}
}
