<?php

/**
 * User-defined error handler (called from 'trigger_error')
 *
 * NOTE: Some recent versions of PHP have a 5th parameter, &$p_ErrContext
 * which is an associative array of all variables defined in scope in which
 * error occurred.  We cannot support this, for compatibility with older PHP.
 *
 * @access public
 * @param int $errNo Type of error
 * @param string $errStr Error message
 * @param string $errFile File in which error occurred
 * @param int $errLine Line number on which error occurred
 * @return void
 */
use XCore\Kernel\Root;
use XCore\Kernel\Ref;

function XoopsErrorHandler_HandleError($errNo, $errStr, $errFile, $errLine)
{
    // NOTE: we only store relative pathnames
    $new_error = array(
        'errno' => $errNo,
        'errstr' => $errStr,
        'errfile' => preg_replace("|^" . XOOPS_ROOT_PATH . "/|", '', $errFile),
        'errline' => $errLine
        );
    $error_handler = XoopsErrorHandler::getInstance();
    $error_handler->handleError($new_error);
}

/**
 * User-defined shutdown function (called from 'exit')
 *
 * @access public
 * @return void
 */
function XoopsErrorHandler_Shutdown()
{
    $error_handler = XoopsErrorHandler::getInstance();
    echo $error_handler->renderErrors();
}

/**
 * function to update compiled template file in templates_c folder
 * 
 * @param   string  $tpl_id
 * @param   boolean $clear_old
 * @return  boolean
 **/
function xoops_template_touch($tpl_id, $clear_old = true)
{
	$result = null;
	
    // RaiseEvent 'Xcore.XoopsTpl.TemplateTouch'
    //  Delegate may define new template touch logic (with XC21, only for clear cache & compiled template)
    //  varArgs : 
    //      'xoopsTpl'     [I/O] : $this
    //
    XCube_DelegateUtils::call('Xcore.XoopsTpl.TemplateTouch', $tpl_id, $clear_old, new Ref($result));
	
	if ($result === null) {
		$tpl = new XoopsTpl();
		$tpl->force_compile = true;
		$tplfile_handler =& xoops_gethandler('tplfile');
		$tplfile =& $tplfile_handler->get($tpl_id);
		if ( is_object($tplfile) ) {
			$file = $tplfile->getVar('tpl_file');
			if ($clear_old) {
				$tpl->clear_cache('db:'.$file);
				$tpl->clear_compiled_tpl('db:'.$file);
			}
			// $tpl->fetch('db:'.$file);
			return true;
		}
		return false;
	} else {
		return $result;
	}
}

/**
 * Smarty default template handler function
 * 
 * @deprecated
 *
 * @param $resource_type
 * @param $resource_name
 * @param $template_source
 * @param $template_timestamp
 * @param $smarty_obj
 * @return  bool
 **/
function xoops_template_create ($resource_type, $resource_name, &$template_source, &$template_timestamp, &$smarty_obj)
{
	if ( $resource_type == 'db' ) {
		$file_handler =& xoops_gethandler('tplfile');
		$tpl =& $file_handler->find('default', null, null, null, $resource_name, true);
		if (count($tpl) > 0 && is_object($tpl[0])) {
			$template_source = $tpl[0]->getSource();
			$template_timestamp = $tpl[0]->getLastModified();
			return true;
		}
	} else {
	}
	return false;
}

/**
 * Clear the module cache
 * 
 * @deprecated
 *
 * @param   int $mid    Module ID
 * @return 
 **/
function xoops_template_clear_module_cache($mid)
{
	$block_arr =& XoopsBlock::getByModule($mid);
	$count = count($block_arr);
	if ($count > 0) {
		$xoopsTpl = new XoopsTpl();	
		$xoopsTpl->xoops_setCaching(2);
		for ($i = 0; $i < $count; $i++) {
			if ($block_arr[$i]->getVar('template') != '') {
				$xoopsTpl->clear_cache('db:'.$block_arr[$i]->getVar('template'), 'blk_'.$block_arr[$i]->getVar('bid'));
			}
		}
	}
}

function head_process_xoopscomment_php()
{
	$root = Root::getSingleton();
	$root->mLanguageManager->loadPageTypeMessageCatalog('comment');
}

function head_process_xoopsmailer_php()
{
	if (isset($GLOBALS['xoopsConfig']['language']) && file_exists(XOOPS_ROOT_PATH.'/language/'.$GLOBALS['xoopsConfig']['language'].'/mail.php')) {
		include_once XOOPS_ROOT_PATH.'/language/'.$GLOBALS['xoopsConfig']['language'].'/mail.php';
	} else {
		include_once XOOPS_ROOT_PATH.'/language/english/mail.php';
	}
}

