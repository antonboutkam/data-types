<?php

namespace Test\Hurah\Types\Util;

use Hurah\Types\Exception\ClassNotFoundException;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\Mime\Mime;
use Hurah\Types\Util\MimeTypeFactory;
use PHPUnit\Framework\TestCase;

class MimeTypeFactoryTest extends TestCase
{
	/**
	 * @throws InvalidArgumentException
	 * @throws ClassNotFoundException
	 */
	public function testGetAll():void
	{
		$oMimeTypeCollection = MimeTypeFactory::getAll();
		foreach ($oMimeTypeCollection as $oMime)
		{
			$this->assertInstanceOf(Mime::class, $oMime);
		}

	}
}
