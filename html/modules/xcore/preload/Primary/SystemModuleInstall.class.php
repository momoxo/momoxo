<?php
/**
 *
 * @package Xcore
 * @version $Id: SystemModuleInstall.class.php,v 1.5 2008/09/25 15:12:38 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

/**
 * The action filter for the site close procedure.
 */
class Xcore_SystemModuleInstall extends XCube_ActionFilter
{
	function preBlockFilter()
	{
		if (is_array(Xcore_Utils::checkSystemModules())) {
			$this->mController->mSetupUser->add("Xcore_SystemModuleInstall::callbackSetupUser", XCUBE_DELEGATE_PRIORITY_FINAL-1);
			$this->mRoot->mDelegateManager->add("Site.CheckLogin.Success", array(&$this, "callbackCheckLoginSuccess"));
		}
	}

	/**
	 * Checks whether the site is closed now, and whether all of must modules
	 * have been installed. This function is called through delegates.
	 * @var XoopsUser &$xoopsUser
	 * @see preBlockFilter()
	 */
	function callbackSetupUser(&$principal, &$controller, &$context)
	{
		$retArray = Xcore_Utils::checkSystemModules();
		$accessAllowFlag = false;
		$xoopsConfig = $controller->mRoot->mContext->getXoopsConfig();
		
		if (!empty($_POST['xoops_login'])) {
			define('XOOPS_CPFUNC_LOADED', 1);
			$controller->checkLogin();
			return;
		} elseif (is_object($context->mXoopsUser)) {
		    if (in_array(XOOPS_GROUP_ADMIN, $context->mXoopsUser->getGroups())) {
				$accessAllowFlag = true;
			}
		}
		
		// @todo Devide following lines to another preload file
		if ($accessAllowFlag) {
			$GLOBALS['xoopsUser'] = $context->mXoopsUser;
			if (!empty($_POST['cube_module_install'])) { //@todo use Ticket
				require_once XOOPS_XCORE_PATH . "/admin/class/ModuleInstaller.class.php";
				require_once XOOPS_XCORE_PATH . "/admin/class/ModuleInstallUtils.class.php";
				if (isset($_POST['uninstalled_modules']) && is_array($_POST['uninstalled_modules'])){
					foreach ($_POST['uninstalled_modules'] as $module) {
						$module = basename($module);
						if (in_array($module, $retArray['uninstalled'])) {
							$controller->mRoot->mLanguageManager->loadModuleAdminMessageCatalog('xcore');
							
							$handler =& xoops_gethandler('module');
							$xoopsModule =& $handler->create();
							$xoopsModule->set('weight', 1);
							$xoopsModule->loadInfoAsVar($module);
							
							$installer =& Xcore_ModuleInstallUtils::createInstaller($xoopsModule->get('dirname'));
							$installer->setForceMode(true);
							$installer->setCurrentXoopsModule($xoopsModule);
							$installer->executeInstall();
						}
					}
				}
				if (isset($_POST['disabled_modules']) && is_array($_POST['disabled_modules'])){
					$moduleHandler =& xoops_gethandler('module');
					foreach ($_POST['disabled_modules'] as $module) {
						$module = basename($module);
						if (in_array($module, $retArray['disabled'])) {
							if ($moduleObject =& $moduleHandler->getByDirname($module)) {
								$moduleObject->setVar('isactive', 1);
								$moduleHandler->insert($moduleObject);
								
								$blockHandler =& xoops_gethandler('block');
								$blockHandler->syncIsActive($moduleObject->get('mid'), $moduleObject->get('isactive'));
							}
						}
					}
				}
				if (isset($_POST['option_modules']) && is_array($_POST['option_modules']) ){
					$handler =& xoops_getmodulehandler('non_installation_module', 'xcore');
					$objects = $handler->getObjects();
					$optionModules = array();
					foreach ($objects as $module) {
						if (!in_array($module->get('dirname'), $retArray['uninstalled'])) {
							$optionModules[] = $module->get('dirname');
						}
					}
					foreach ($_POST['option_modules'] as $module) {
						$module = basename($module);
						if (in_array($module, $optionModules)) {
							$controller->mRoot->mLanguageManager->loadModuleAdminMessageCatalog('xcore');
							
							$handler =& xoops_gethandler('module');
							$xoopsModule =& $handler->create();
							$xoopsModule->set('weight', 1);
							$xoopsModule->loadInfoAsVar($module);
							
							$installer =& Xcore_ModuleInstallUtils::createInstaller($xoopsModule->get('dirname'));
							$installer->setForceMode(true);
							$installer->setCurrentXoopsModule($xoopsModule);
							$installer->executeInstall();
						}
					}
				}
				$controller->executeRedirect(XOOPS_URL . '/', 1);
			}
			elseif (!empty($_GET['cube_module_uninstall'])) {
				require_once XOOPS_ROOT_PATH . '/class/template.php';
				$xoopsTpl =new XoopsTpl();
				$xoopsTpl->assign('cube_module_uninstall', htmlspecialchars($_GET['cube_module_uninstall'],ENT_QUOTES));
				$xoopsTpl->assign( array(
							   'xoops_sitename' => htmlspecialchars($xoopsConfig['sitename']),
							   'xoops_themecss' => xoops_getcss(),
							   'xoops_imageurl' => XOOPS_THEME_URL . '/' . $xoopsConfig['theme_set'] . '/',
							   ));
				///< @todo filebase template with absolute file path
				$xoopsTpl->compile_check = true;
				$xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/xcore/templates/xcore_uninstall_modules.html');
				exit();
			}
			elseif (!empty($_POST['cube_module_uninstallok'])) { //@todo use Ticket
				require_once XOOPS_XCORE_PATH . "/admin/class/ModuleUninstaller.class.php";
				require_once XOOPS_XCORE_PATH . "/admin/class/ModuleInstallUtils.class.php";
				$module = basename($_POST['cube_module_uninstallok']);
				if (in_array($module, $retArray['disabled'])) {
					$controller->mRoot->mLanguageManager->loadModuleAdminMessageCatalog('xcore');
							
					$handler =& xoops_gethandler('module');
					$xoopsModule =& $handler->getByDirname($module);
					
					$uninstaller =& Xcore_ModuleInstallUtils::createUninstaller($xoopsModule->get('dirname'));
					$uninstaller->setForceMode(true);
					$uninstaller->setCurrentXoopsModule($xoopsModule);
					$uninstaller->executeUninstall();
				}
				$controller->executeRedirect(XOOPS_URL . '/',1);
			}
			else {
				$handler =& xoops_getmodulehandler('non_installation_module','xcore');
				$objects = $handler->getObjectsFor2ndInstaller();
				$optionModules = array();
				foreach ($objects as $module) {
					$dirname = $module->getVar('dirname');
					if (!in_array($dirname, $retArray['uninstalled'])) {
						$optionModule['dirname']  = $dirname;
						if (in_array($dirname, $retArray['recommended'])) {
							$optionModule['checked']  = 'checked="checked"';
							$optionModule['desc']  = _SYS_RECOMMENDED_MODULES;
                            $optionModules[' '.$dirname] = $optionModule ;
						} else {
							$optionModule['checked']  = '';
							$optionModule['desc']  = _SYS_OPTION_MODULES;
                            $optionModules[$dirname] = $optionModule ;
						}
					}
				}
                ksort( $optionModules ) ;
                $optionModules = array_values( $optionModules ) ;
				require_once XOOPS_ROOT_PATH . '/class/template.php';
				$xoopsTpl =new XoopsTpl();
				$xoopsTpl->assign('uninstalled',$retArray['uninstalled']);
				$xoopsTpl->assign('disabled',$retArray['disabled']);
				$xoopsTpl->assign('option',$optionModules);
				$xoopsTpl->assign(array(
							   'xoops_sitename' => htmlspecialchars($xoopsConfig['sitename']),
							   'xoops_themecss' => xoops_getcss(),
							   'xoops_imageurl' => XOOPS_THEME_URL . '/' . $xoopsConfig['theme_set'] . '/'
							   ));
				///< @todo filebase template with absolute file path
				$xoopsTpl->compile_check = true;
				$xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/xcore/templates/xcore_install_modules.html');
				exit();
			}
		}

		if (!$accessAllowFlag) {
			require_once XOOPS_ROOT_PATH . '/class/template.php';
			$xoopsTpl =new XoopsTpl();
			$xoopsTpl->assign(array('xoops_sitename' => htmlspecialchars($xoopsConfig['sitename']),
									   'xoops_themecss' => xoops_getcss(),
									   'xoops_imageurl' => XOOPS_THEME_URL . '/' . $xoopsConfig['theme_set'] . '/',
									   'lang_login' => _LOGIN,
									   'lang_username' => _USERNAME,
									   'lang_password' => _PASSWORD,
									   'lang_siteclosemsg' => $xoopsConfig['closesite_text']
									   ));
									   
			$xoopsTpl->compile_check = true;
			
			// @todo filebase template with absolute file path
			$xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/xcore/templates/xcore_site_closed.html');
			exit();
		}
	}
	
	/**
	 * When the user logs in successfully, checks whether the user belongs to
	 * the special group which is allowed to login. This function is called
	 * through delegates.
	 * @var XoopsUser &$xoopsUser
	 * @see preBlockFilter
	 */
	function callbackCheckLoginSuccess(&$xoopsUser)
	{
		//
		// This check is not needed. :)
		//
		if (!is_object($xoopsUser)) {
			return;
		}
	    if (!in_array(XOOPS_GROUP_ADMIN,$xoopsUser->getGroups())) {
			$this->mController->executeRedirect(XOOPS_URL . '/', 1, _NOPERM);
		}
	}
}
?>