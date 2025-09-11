<?php

namespace Hurah\Types\Type\Mime;

use Hurah\Types\Type\ITestable;

/**
 *
 */

/**
 *
 */
interface Mime extends ITestable, IContentType
{

	/**
	 * @return string
	 */
	public function getCode(): string;
}
