<?php

// From ../../html/modules/xcore/kernel/block.php
use XCore\FormFile\FormFile;

define ('SHOW_SIDEBLOCK_LEFT',     1);
define ('SHOW_SIDEBLOCK_RIGHT',    2);
define ('SHOW_CENTERBLOCK_LEFT',   4);
define ('SHOW_CENTERBLOCK_RIGHT',  8);
define ('SHOW_CENTERBLOCK_CENTER', 16);
define ('SHOW_BLOCK_ALL',          31);

// From ../../html/modules/xcore/kernel/configitem.php
define('XOOPS_CONF', 1);
define('XOOPS_CONF_USER', 2);
define('XOOPS_CONF_METAFOOTER', 3);
define('XOOPS_CONF_CENSOR', 4);
define('XOOPS_CONF_SEARCH', 5);
define('XOOPS_CONF_MAILER', 6);

// From ../../html/modules/xcore/kernel/criteria.class.php
define("XCORE_EXPRESSION_EQ", "=");
define("XCORE_EXPRESSION_NE", "<>");
define("XCORE_EXPRESSION_LT", "<");
define("XCORE_EXPRESSION_LE", "<=");
define("XCORE_EXPRESSION_GT", ">");
define("XCORE_EXPRESSION_GE", ">=");
define("XCORE_EXPRESSION_LIKE", "like");
define("XCORE_EXPRESSION_IN", "in");
define("XCORE_EXPRESSION_AND", "and");
define("XCORE_EXPRESSION_OR", "or");

// From ../../html/modules/xcore/kernel/groupperm.php
define("GROUPPERM_VAL_MODREAD",   "module_read");
define("GROUPPERM_VAL_MODADMIN",  "module_admin");
define("GROUPPERM_VAL_BLOCKREAD", "block_read");

// From ../../html/modules/xcore/kernel/object.php
define('XOBJ_DTYPE_STRING', 1);
define('XOBJ_DTYPE_TXTBOX', 1);
define('XOBJ_DTYPE_TEXT', 2);
define('XOBJ_DTYPE_TXTAREA', 2);
define('XOBJ_DTYPE_INT', 3);
define('XOBJ_DTYPE_URL', 4);
define('XOBJ_DTYPE_EMAIL', 5);
define('XOBJ_DTYPE_ARRAY', 6);
define('XOBJ_DTYPE_OTHER', 7);
define('XOBJ_DTYPE_SOURCE', 8);
define('XOBJ_DTYPE_STIME', 9);
define('XOBJ_DTYPE_MTIME', 10);
define('XOBJ_DTYPE_LTIME', 11);
define('XOBJ_DTYPE_FLOAT', 12);
define('XOBJ_DTYPE_BOOL', 13);

// From ../../html/modules/xcore/kernel/Xcore_AdminRenderSystem.class.php
define('XCORE_ADMIN_RENDER_TEMPLATE_DIRNAME', 'templates');
define('XCORE_ADMIN_RENDER_FALLBACK_PATH', XOOPS_MODULE_PATH . '/xcore/admin/theme');
define('XCORE_ADMIN_RENDER_FALLBACK_URL', XOOPS_MODULE_URL . '/xcore/admin/theme');

// From ../../html/modules/xcore/kernel/Xcore_Controller.class.php
define('XCORE_MODULE_VERSION', '2.2');
define('XCORE_CONTROLLER_STATE_PUBLIC', 1);
define('XCORE_CONTROLLER_STATE_ADMIN', 2);
/** @deprecated */
define('XCORE_XOOPS_MODULE_MANIFESTO_FILENAME', \XCore\Kernel\Controller::MODULE_MANIFESTO_FILENAME);

// From ../../html/modules/xcore/kernel/Xcore_RenderSystem.class.php
define('XCORE_RENDERSYSTEM_BANNERSETUP_BEFORE', false);

// From ../../html/modules/xcore/kernel/Xcore_RenderTarget.class.php
define("XCORE_RENDER_TARGET_TYPE_BUFFER", null);
define("XCORE_RENDER_TARGET_TYPE_THEME", 'theme');
define("XCORE_RENDER_TARGET_TYPE_BLOCK", 'block');
define("XCORE_RENDER_TARGET_TYPE_MAIN", 'main');

// From XCore\Kernel\Delegate
define("XCUBE_DELEGATE_PRIORITY_1", 10);
define("XCUBE_DELEGATE_PRIORITY_2", 20);
define("XCUBE_DELEGATE_PRIORITY_3", 30);
define("XCUBE_DELEGATE_PRIORITY_4", 40);
define("XCUBE_DELEGATE_PRIORITY_5", 50);
define("XCUBE_DELEGATE_PRIORITY_6", 60);
define("XCUBE_DELEGATE_PRIORITY_7", 70);
define("XCUBE_DELEGATE_PRIORITY_8", 80);
define("XCUBE_DELEGATE_PRIORITY_9", 90);
define("XCUBE_DELEGATE_PRIORITY_10", 100);
define("XCUBE_DELEGATE_PRIORITY_FIRST", XCUBE_DELEGATE_PRIORITY_1);
define("XCUBE_DELEGATE_PRIORITY_NORMAL", XCUBE_DELEGATE_PRIORITY_5);
define("XCUBE_DELEGATE_PRIORITY_FINAL", XCUBE_DELEGATE_PRIORITY_10);

// From ../../html/modules/xcore/kernel/FormFile.class.php
define("XCUBE_FORMFILE_CHMOD", 0644);

/** @deprecated */
define("XCUBE_CONTEXT_TYPE_DEFAULT", \XCore\Kernel\HttpContext::TYPE_DEFAULT);
/** @deprecated */
define("XCUBE_CONTEXT_TYPE_WEB_SERVICE", \XCore\Kernel\HttpContext::TYPE_WEB_SERVICE);

// From ../../html/modules/xcore/kernel/XCube_PageNavigator.class.php
define('XCUBE_PAGENAVI_START', 1);
define('XCUBE_PAGENAVI_PERPAGE', 2);
define('XCUBE_PAGENAVI_SORT', 1);
define('XCUBE_PAGENAVI_PAGE', 4);
define('XCUBE_PAGENAVI_DEFAULT_PERPAGE', 20);

// From XCore\Kernel\RenderSystem
define("XCUBE_RENDER_MODE_NORMAL",1);
define("XCUBE_RENDER_MODE_DIALOG",2);
define("XCUBE_RENDER_TARGET_TYPE_BUFFER", null);
define("XCUBE_RENDER_TARGET_TYPE_THEME", 'theme');
define("XCUBE_RENDER_TARGET_TYPE_BLOCK", 'block');
define("XCUBE_RENDER_TARGET_TYPE_MAIN", 'main');

