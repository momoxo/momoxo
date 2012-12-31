<?php

/***
 * @internal
 * This action shows the list of selectable themes to user.
 * 
 * [Notice]
 * In XOOPS Cube Legacy which can have many themes with different render-
 * systems, that one render-system has the control to change themes is wrong,
 * because this action can't list up themes of other render-systems.
 * The action to change themes should be in Xcore. And, each render-systems
 * should send theme informations through delegate-mechanism.
 * 
 * Therefore, this class is test for that we may move this action from
 * XcoreRender module. If you want to check the concept of this strategy, see
 * ThemeSelect preload in Legacy module.
 */
use XCore\Kernel\DelegateUtils;
use XCore\Database\CriteriaCompo;
use XCore\Database\Criteria;

class Xcore_ThemeListAction extends Xcore_Action
{
	var $mThemes = null;
	var $mObjectHandler = null;
	var $mActionForm = null;
	var $mMainTheme = null;

	function prepare(&$controller, &$xoopsUser)
	{
		$this->_setupObject();
		$this->_setupActionForm();
		
		$handler =& xoops_gethandler('config');
		
		$criteria =new CriteriaCompo();
		$criteria->add(new Criteria('conf_name', 'theme_set'));
		$criteria->add(new Criteria('conf_catid', XOOPS_CONF));
		
		$configs =& $handler->getConfigs($criteria);
		$this->mMainTheme = $configs[0]->get('conf_value');
	}
	
	function _setupObject()
	{
		$handler =& xoops_getmodulehandler('theme');
		$this->mThemes =& $handler->getObjects();
	}

	function _setupActionForm()
	{
		$this->mActionForm =new Xcore_ThemeSelectForm();
		$this->mActionForm->prepare();
	}
	
	function getDefaultView(&$controller, &$xoopsUser)
	{
		$configHandler =& xoops_gethandler('config');

		$criteria =new CriteriaCompo();
		$criteria->add(new Criteria('conf_name', 'theme_set_allowed'));
		$criteria->add(new Criteria('conf_catid', XOOPS_CONF));
		
		$configs =& $configHandler->getConfigs($criteria);
		$selectedThemeArr = unserialize($configs[0]->get('conf_value'));
		
		$this->mActionForm->load($selectedThemeArr);
		
		return XCORE_FRAME_VIEW_INDEX;
	}
	
	function execute(&$controller, &$xoopsUser)
	{
		$this->mActionForm->fetch();
		$this->mActionForm->validate();
		
		if ($this->mActionForm->hasError()) {
			return $this->getDefaultView($controller, $xoopsUser);
		}

		//
		// save selectable themes.
		//
		$configHandler =& xoops_gethandler('config');

		$criteria =new CriteriaCompo();
		$criteria->add(new Criteria('conf_name', 'theme_set_allowed'));
		$criteria->add(new Criteria('conf_catid', XOOPS_CONF));
		
		$configs =& $configHandler->getConfigs($criteria);
		$t_themeArr = $this->mActionForm->getSelectableTheme();
		$configs[0]->set('conf_value', serialize($t_themeArr));
		if (!$configHandler->insertConfig($configs[0])) {
			throw new RuntimeException();
		}

		//
		// save selected theme.
		//
		$themeName = $this->mActionForm->getChooseTheme();
		
		if ($themeName != null) {
			$criteria =new CriteriaCompo();
			$criteria->add(new Criteria('conf_name', 'theme_set'));
			$criteria->add(new Criteria('conf_catid', XOOPS_CONF));
			
			$configs =& $configHandler->getConfigs($criteria);

			$configs[0]->set('conf_value', $themeName);
			if ($configHandler->insertConfig($configs[0])) {
				$controller->mRoot->mContext->setThemeName($themeName);
				$this->mMainTheme = $themeName;
			}
		}
		
		DelegateUtils::call('Xcore.Event.ThemeSettingChanged', $this->mMainTheme, $t_themeArr);

		return $this->getDefaultView($controller, $xoopsUser);
	}
	
	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("theme_list.html");
		$render->setAttribute("themes", $this->mThemes);
		$render->setAttribute("actionForm", $this->mActionForm);
		$render->setAttribute("currentThemeName", $this->mMainTheme);
	}
}

