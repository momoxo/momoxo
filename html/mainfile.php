<?php

if (file_exists(__DIR__ . '/config/config.php') === false) {
    header('Location: install/index.php');
    exit;
}

if ( !defined('XOOPS_MAINFILE_INCLUDED') ) {
    define('XOOPS_MAINFILE_INCLUDED', 1);

    require_once __DIR__ . '/config/config.php';

    if (!defined('_XCORE_PREVENT_LOAD_CORE_') && XOOPS_ROOT_PATH != '') {
        include_once XOOPS_ROOT_PATH.'/modules/xcore/include/cubecore_init.php';
        if (!isset($xoopsOption['nocommon']) && !defined('_XCORE_PREVENT_EXEC_COMMON_')) {
            include XOOPS_ROOT_PATH.'/modules/xcore/include/common.php';
        }
    }
}
