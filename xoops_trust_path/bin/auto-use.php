#!/usr/bin/env php
<?php

require_once __DIR__ . '/auto-use-source.php';

function help()
{
	echo '  $ aut-use.php <filename> "<old_class>" "<new_class>"', PHP_EOL;
}

if ( isset($_SERVER['argv'][1]) === false ) {
	echo 'filename missing', PHP_EOL;
	help();
	exit(1);
}

if ( isset($_SERVER['argv'][2]) === false ) {
	echo 'old class name missing', PHP_EOL;
	help();
	exit(1);
}

if ( isset($_SERVER['argv'][3]) === false ) {
	echo 'new class name missing', PHP_EOL;
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

$filename = $_SERVER['argv'][1];

$contents = file_get_contents($filename);
$useAppendedContents = auto_use($contents, $_SERVER['argv'][2], $_SERVER['argv'][3]);
file_put_contents($filename, $useAppendedContents);
