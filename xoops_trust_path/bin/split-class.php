#!/usr/bin/env php
<?php
/**
 * 複数クラスが入ってるファイルを、ワンクラス・ワンファイルに分割するスクリプト
 */

require_once __DIR__.'/../vendor/autoload.php';

function get_classes($filename)
{
	$classes  = array();
	$contents = file_get_contents($filename);

	$tokens = token_get_all($contents);

	foreach ( $tokens as $key => $token ) {
		if ( is_array($token) ) {
			switch ( $token[0] ) {
				case T_CLASS:
				case T_INTERFACE:
				case T_TRAIT:
					$class = $tokens[$key + 2][1];
					$classes[$class] = $filename;
			}
		}
	}

	return $classes;
}

function get_functions($filename)
{
	$functions  = array();
	$contents = file_get_contents($filename);

	$tokens = token_get_all($contents);

	for ( $i = 0; $i < count($tokens); $i += 1 ) {

		$token = $tokens[$i];

		if ( is_array($token) and $token[0] === T_FUNCTION ) {

			$functionName = null;

			while ( true ) {
				$i += 1;
				$token = $tokens[$i];

				if ( is_array($token) === false ) {
					continue;
				}

				if ( $token[0] === T_STRING ) {
					$functionName = $token[1];
					break;
				}
			}

			$functions[] = $functionName;
		}
	}

	return $functions;
}

function get_constants($filename)
{
	$contents = file_get_contents($filename);
	$tokens = token_get_all($contents);
	$constants = array();

	for ( $i = 0, $end = count($tokens); $i < $end; $i += 1 ) {
		$token = $tokens[$i];
		if ( is_array($token) and $token[0] === T_STRING and $token[1] == 'define' ) {
			$declaration = 'define';
			$constant = null;
			while ( true ) {
				$i += 1;
				$token = $tokens[$i];
				$declaration .= is_array($token) ? $token[1] : $token;

				if ( is_array($token) and $token[0] === T_CONSTANT_ENCAPSED_STRING and $constant === null ) {
					$constant = trim($token[1], '"\'');
				}

				if ( $token === ';' ) {
					break;
				}
			}

			$constants[$constant] = array(
				'file' => $filename,
				'declaration' => $declaration,
			);
		}
	}

	return $constants;
}

function file_get_contents_line_by_line($filename, $start, $end)
{
	$contents = file_get_contents($filename);
	$lines = preg_split("/(\r\n|\n|\r)/", $contents);
	$lines = array_slice($lines, $start - 1, $end - $start + 1);
	return implode("\n", $lines);
}

$dir = isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : getcwd();
$buildDir = rtrim($dir, '/').'/_build';

if ( file_exists($buildDir) ) {
	echo "$buildDir is already exists.", PHP_EOL;
	exit(1);
}

mkdir($buildDir);

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::CHILD_FIRST);
$classes = array();
$constants = array();
$functions = array();

// Scan files
foreach ($files as $file) {
	/** @var $file SplFileInfo */
	if ( $file->isFile() === false ) {
		continue;
	}

	if ( $file->getExtension() !== 'php' ) {
		continue;
	}

	echo "Found: ", $file->getPathname(), PHP_EOL;

	$classes = array_merge($classes, get_classes($file->getPathname()));
	$constants = array_merge($constants, get_constants($file->getPathname()));
	$functions = array_merge($functions, get_functions($file->getPathname()));
}

// Load all files
foreach ( $classes as $class => $file ) {
	require_once $file;
}

// Omit not declared constants
foreach ( $constants as $constant => $declaration ) {
	if ( defined($constant) === false ) {
		unset($constants[$constant]);
	}
}

// Omit not declared functions
foreach ( $functions as $index => $function ) {
	if ( function_exists($function) === false ) {
		unset($functions[$index]);
		continue;
	}

	$reflect = new ReflectionFunction($function);

	if ( $reflect->isUserDefined() === false ) {
		unset($functions[$index]);
	}
}

// Organize constants
$organizedConstants = array();

foreach ( $constants as $content => $declaration ) {
	$filename = $declaration['file'];
	$organizedConstants[$filename][] = $declaration['declaration'];
}

$newClassFiles = array();

// Reflect all classes
foreach ( $classes as $class => $file ) {
	$reflect = new ReflectionClass($class);

	ob_start();
	echo '<?php',PHP_EOL,PHP_EOL;
	echo ( $reflect->getDocComment() ) ? $reflect->getDocComment(). PHP_EOL : '';
	echo file_get_contents_line_by_line($file, $reflect->getStartLine(), $reflect->getEndLine()), PHP_EOL;
	$contents = ob_get_clean();

	$newClassFiles[$reflect->getName().'.php'] = $contents;
}

// Create files
foreach ( $newClassFiles as $newClassFile => $classContent ) {
	file_put_contents($buildDir.'/'.$newClassFile, $classContent);
	echo "Create $buildDir/$newClassFile", PHP_EOL;
}

// Reflect all functions
ob_start();
echo '<?php',PHP_EOL,PHP_EOL;

foreach ( $functions as $function ) {
	$reflect = new ReflectionFunction($function);
	echo ( $reflect->getDocComment() ) ? $reflect->getDocComment(). PHP_EOL : '';
	echo file_get_contents_line_by_line($reflect->getFileName(), $reflect->getStartLine(), $reflect->getEndLine()), PHP_EOL;
	echo PHP_EOL;
}
$contents = ob_get_clean();

file_put_contents($buildDir.'/_functions.php', $contents);
echo "Create $buildDir/_functions.php", PHP_EOL;

// Create constants file
$constantFileContents = '<?php'.PHP_EOL.PHP_EOL;

foreach ( $organizedConstants as $filename => $constants ) {
	$constantFileContents .= '// From '.$filename.PHP_EOL;
	$constantFileContents .= implode(PHP_EOL, $constants).PHP_EOL.PHP_EOL;
}

file_put_contents($buildDir.'/_constants.php', $constantFileContents);
echo "Create $buildDir/_constants.php", PHP_EOL;
