#!/usr/bin/env php
<?php

require_once __DIR__ . '/auto-use-source.php';

function help()
{
	echo '  $ aut-use.php <filename> "<class_name>"', PHP_EOL;
}

if ( isset($_SERVER['argv'][1]) === false ) {
	echo 'filename missing', PHP_EOL;
	help();
	exit(1);
}

if ( isset($_SERVER['argv'][2]) === false ) {
	echo 'class name missing', PHP_EOL;
	help();
	exit(1);
}

if ( is_file($_SERVER['argv'][1]) === false ) {
	echo 'file not found: '. $_SERVER['argv'][1], PHP_EOL;
	exit(1);
}

if ( is_readable($_SERVER['argv'][1]) === false ) {
	echo 'file is not readable: ', $_SERVER['argv'][1], PHP_EOL;
	exit(1);
}

if ( is_writable($_SERVER['argv'][1]) === false ) {
	echo 'file is not writable: ', $_SERVER['argv'][1], PHP_EOL;
	exit(1);
}

$contents = file_get_contents($_SERVER['argv'][1]);
$useAppendedContents = auto_use($contents, $_SERVER['argv'][2]);

echo $useAppendedContents;