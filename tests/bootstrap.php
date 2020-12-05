<?php

declare(strict_types=1);

$sAutoLoadFile = dirname(__DIR__, 1) . '/vendor/autoload.php';
echo  $sAutoLoadFile;
require_once $sAutoLoadFile;

/*
if (@!include __DIR__ . '/../vendor/autoload.php') {
	echo 'Install Nette Tester using `composer install`';
	exit(1);
}


function same(string $expected, $actual): void
{
	$expected = str_replace(PHP_EOL, "\n", $expected);
	Tester\Assert::same($expected, $actual);
}


function sameFile(string $file, $actual): void
{
	same(file_get_contents($file), $actual);
}


Tester\Environment::setup();
date_default_timezone_set('Europe/Prague');
*/
