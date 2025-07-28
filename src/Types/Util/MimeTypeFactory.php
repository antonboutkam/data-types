<?php

namespace Hurah\Types\Util;

use Hurah\Types\Exception\ClassNotFoundException;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\Mime\MimeCollection;
use Hurah\Types\Type\Path;
use Hurah\Types\Type\PhpNamespace;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 *
 */
class MimeTypeFactory
{
	/**
	 * @throws InvalidArgumentException
	 * @throws ClassNotFoundException
	 */
	public static function getAll():MimeCollection
	{
		$oMimeCollection = new MimeCollection();

		$oPath = Path::make(__DIR__)->dirname()->extend('Type', 'Mime');
		$oFinder = $oPath
		  ->getFinder()
		  ->files()
		  ->name('*Mime.php')
			->notName('/^Abstract/')
		  ->notName('Mime.php')
			->notName('IContentType.php');


		foreach($oFinder as $oFile)
		{
			$oBaseNamespace = new PhpNamespace('\\Hurah\\Types\\Type\\Mime');
			$oPhpNamespace  = $oBaseNamespace->extend($oFile->getBasename('.php'));
			$oMimeCollection->add($oPhpNamespace->getConstructed());
		}
		return $oMimeCollection;
	}

}
