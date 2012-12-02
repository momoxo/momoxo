<?php

use XCore\Kernel\Root;
use XCore\Kernel\Ref;

function Xcore_modifier_theme($string)
{
	$infoArr = Xcore_get_override_file($string);
	
	if ($infoArr['theme'] != null && $infoArr['dirname'] != null) {
		return XOOPS_THEME_URL . '/' . $infoArr['theme'] . '/modules/' . $infoArr['dirname'] . '/' . $string;
	}
	elseif ($infoArr['theme'] != null) {
		return XOOPS_THEME_URL . '/' . $infoArr['theme'] . '/' . $string;
	}
	elseif ($infoArr['dirname'] != null) {
		return XOOPS_MODULE_URL . '/' . $infoArr['dirname'] . '/admin/templates/' . $string;
	}
	
	return XCORE_ADMIN_RENDER_FALLBACK_URL . '/' . $string;
}

function Xcore_function_stylesheet($params, &$smarty)
{
	if (!isset($params['file'])) {
		$smarty->trigger_error('stylesheet: missing file parameter.');
		return;
	}
	
	$file = $params['file'];
	
	if (strstr($file, '..') !== false) {
		$smarty->trigger_error('stylesheet: missing file parameter.');
		return;
	}
	
	$media = (isset($params['media'])) ? $params['media'] : 'all';

	$infoArr = Xcore_get_override_file($file, 'stylesheets/');

	// TEMP
	// TODO We must return FALLBACK_URL here.
	if ($infoArr['file'] != null) {
		if ($params['static']) {
			$theme=$infoArr['theme'];
			$dirname=$infoArr['dirname'];
			$file='stylesheets/'.$file;
			if (!empty($theme) && !empty($dirname)) {
				$url = XOOPS_THEME_URL . "/$theme/modules/$dirname/$file";
			} elseif (!empty($theme)) {
				$url = XOOPS_THEME_URL . "/$theme/$file";
			}
			elseif (!empty($infoArr['dirname'])) {
				$url = XOOPS_MODULE_URL . "/$dirname/admin/templates/$file";
			} else {
				$url = XCORE_ADMIN_RENDER_FALLBACK_URL . "/$file";
			}
		} else {
			if ($infoArr['file'] != null) {
				$request = array();
				foreach ($infoArr as $key => $value) {
					if ($value != null) {
						$request[] = "${key}=${value}";
					}
				}
			}
			$url = XOOPS_MODULE_URL . '/xcoreRender/admin/css.php?' . implode('&amp;', $request);
		}

		return '<link rel="stylesheet" type="text/css" media="'. $media .'" href="' . $url . '" />';
	}
}

function Xcore_get_override_file($file, $prefix = null, $isSpDirname = false)
{
	$root = Root::getSingleton();
	$moduleObject =& $root->mContext->mXoopsModule;

	if ($isSpDirname && is_object($moduleObject) && $moduleObject->get('dirname') == 'xcore' && isset($_REQUEST['dirname'])) {
		$dirname = xoops_getrequest('dirname');
		if (preg_match('/^[a-z0-9_]+$/i', $dirname)) {
			$handler = xoops_gethandler('module');
			$moduleObject =& $handler->getByDirname($dirname);
		}
	}

	$theme = $root->mSiteConfig['Xcore']['Theme'];

	$ret = array();
	$ret['theme'] = $theme;
	$ret['file'] = $file;
	
	$file = $prefix . $file;

	static $checkCache = array();
	if (isset($checkCache[$file])) return $checkCache[$file];
		
	$themePath = XOOPS_THEME_PATH . '/' . $theme . '/';
	if (!is_object($moduleObject)) {
		if (file_exists($themePath. $file)) {
			return $checkCache[$file] = &$ret;
		}
		
		$ret['theme'] = null;
		return $checkCache[$file] = &$ret;
	}
	else {
		$ret['dirname'] = $dirname = $moduleObject->get('dirname');

		$mfile = $dirname . '/' . $file;
		if (isset($checkCache[$mfile])) return $checkCache[$mfile];
		if (file_exists($themePath.'modules/'.$mfile)) {
			return $checkCache[$mfile] = &$ret;
		}
		
		if (file_exists($themePath. $file)) {
			$ret['dirname'] = null;
			return $checkCache[$mfile] = &$ret;
		}
		
		$ret['theme'] = null;

		if (file_exists(XOOPS_MODULE_PATH . '/' . $dirname . '/admin/templates/' . $file)) {
			return $checkCache[$mfile] = &$ret;
		}
		
		$ret['dirname'] = null;

		if (file_exists(XCORE_ADMIN_RENDER_FALLBACK_PATH . '/' . $file)) {
			return $checkCache[$mfile] = &$ret;
		}
		
		$ret['file'] =null;
		return $checkCache[$mfile] = &$ret;
	}
}

function XcoreRender_smartyfunction_notifications_select($params, &$smarty)
{
	$root = Root::getSingleton();
	$renderSystem =& $root->getRenderSystem('Xcore_RenderSystem');
	
	$renderTarget =& $renderSystem->createRenderTarget('main');
	$renderTarget->setTemplateName('xcore_notification_select_form.html');

	XCube_DelegateUtils::call('Xcorefunction.Notifications.Select', new Ref($renderTarget));

	$renderSystem->render($renderTarget);
	
	return $renderTarget->getResult();
}

/**
 *
 * @package XCube
 * @version $Id: XCube_Object.class.php,v 1.3 2008/10/12 04:30:27 minahito Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momoxo/momoxo>
 * @license https://github.com/momoxo/momoxo/blob/master/docs/bsd_licenses.txt Modified BSD license
 *
 */
function S_PUBLIC_VAR($definition)
{
	$t_str = explode(' ', trim($definition));
	return array('name' => trim($t_str[1]), 'type' => trim($t_str[0]));
}

/**
 * @internal
 * @brief This is a kind of MACRO like C for XCube_Service.
 */
function S_PUBLIC_FUNC($definition)
{
	$pos = strpos($definition, '(');
	if ($pos > 0) {
		$params = array();
		foreach (explode(',', substr($definition, $pos + 1, -1)) as $t_param) {
			if ($t_param) {
				list($k, $v) = explode(' ', trim($t_param));
				$params[$k] = $v;
			}
		}
		$ret = array('in' => $params);
		list($ret['out'], $ret['name']) = explode(' ', substr($definition, 0, $pos));
		return $ret;
	}
	return null;
}

