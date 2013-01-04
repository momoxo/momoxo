<?php

// For composer
require_once 'vendor/autoload.php';

// For Momoxo\Installer\*
spl_autoload_register(function($c) { @include_once strtr($c, '\\_', '//').'.php'; });

/**
 * You can overwrite XOOPS_TEST_DB_* by `export` command.
 * @see http://manpages.ubuntu.com/manpages/hardy/man5/exports.5.html
 *
 * Example:
 *
 * ```
 * export XOOPS_TEST_DB_USER=alice
 * export XOOPS_TEST_DB_PASS=passwd
 * phpunit
 * ```
 */
if ( isset($_SERVER['XOOPS_TEST_DB_HOST']) === false ) {
	$_SERVER['XOOPS_TEST_DB_HOST'] = $_SERVER['XOOPS_TEST_DB_HOST_DEFAULT'];
}
if ( isset($_SERVER['XOOPS_TEST_DB_NAME']) === false ) {
	$_SERVER['XOOPS_TEST_DB_NAME'] = $_SERVER['XOOPS_TEST_DB_NAME_DEFAULT'];
}
if ( isset($_SERVER['XOOPS_TEST_DB_USER']) === false ) {
	$_SERVER['XOOPS_TEST_DB_USER'] = $_SERVER['XOOPS_TEST_DB_USER_DEFAULT'];
}
if ( isset($_SERVER['XOOPS_TEST_DB_PASS']) === false ) {
	$_SERVER['XOOPS_TEST_DB_PASS'] = $_SERVER['XOOPS_TEST_DB_PASS_DEFAULT'];
}
if ( isset($_SERVER['XOOPS_TEST_DB_PREFIX']) === false ) {
    $_SERVER['XOOPS_TEST_DB_PREFIX'] = $_SERVER['XOOPS_TEST_DB_PREFIX_DEFAULT'];
}
