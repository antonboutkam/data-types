<?php

use Hurah\Types\Util\DirectoryStructure;

require_once 'vendor/autoload.php';

$test = DirectoryStructure::getVendorDir();

var_dump($test);
exit();
