<?php

if ( file_exists(__DIR__.'/config/config.php') === false ) {
	header('Location: install/index.php');
	exit;
}

if ( !defined('XOOPS_MAINFILE_INCLUDED') ) {
	define('XOOPS_MAINFILE_INCLUDED', 1);

	require_once __DIR__.'/config/config.php';
	require_once XOOPS_TRUST_PATH.'/vendor/autoload.php';
	require_once __DIR__.'/_momoxo_old_classes.php'; // TODO >> 削除する

	if ( !defined('_XCORE_PREVENT_LOAD_CORE_') && XOOPS_ROOT_PATH != '' ) {
		include_once XOOPS_ROOT_PATH.'/modules/xcore/include/cubecore_init.php';
		if ( !isset($xoopsOption['nocommon']) && !defined('_XCORE_PREVENT_EXEC_COMMON_') ) {
			include XOOPS_ROOT_PATH.'/modules/xcore/include/common.php';
		}
	}
}
