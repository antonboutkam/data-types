<?php

namespace Hurah\Types\Type\Mime;

use Hurah\Types\Type\ITestable;
use Hurah\Types\Util\MimeTypeFactory;

/**
 *
 */
abstract class AbstractMime implements Mime
{
	function test($sSubject):bool
	{
		$fileInfo = finfo_open(FILEINFO_MIME_TYPE); // Return mime type ala mimetype extension
		$mimeType = finfo_file($fileInfo, $sSubject);
		finfo_close($fileInfo);
		$extension = pathinfo($sSubject, PATHINFO_EXTENSION);

		// Speciale case: text/plain wordt soms gebruikt voor csv, md, log, etc.
		if(is_dir($sSubject) && $this->getCode() === '')
		{
			return true;
		}
		if ($mimeType === 'text/plain') {
			return $extension === $this->getCode();
		}

		if(in_array($mimeType, $this->getContentTypes()))
		{

			return true;
		}
		return false;
	}
}
