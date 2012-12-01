<?php

/**
 * Theme select mechanism is that base knows the method to change themes
 * without RenderSystem. So this class uses delegate to check whether the
 * specified theme is selectable. Functions should be added to this delegate in
 * constructor, because the delegate is called in preBlockFilter().
 */
class Xcore_ThemeSelect extends XCube_ActionFilter
{

	function Xcore_ThemeSelect(&$controller)
	{
		//
		// TODO remove
		//
		parent::__construct($controller);

        $controller->mRoot->mDelegateManager->add('XcoreThemeHandler.GetInstalledThemes', 'XcoreRender_DelegateFunctions::getInstalledThemes');



		$controller->mSetupUser->add(array(&$this, 'doChangeTheme'));
	}
	
	function preBlockFilter()
	{
		$this->mController->mRoot->mDelegateManager->add("Site.CheckLogin.Success", array(&$this, "callbackCheckLoginSuccess"));
	}
	
	/**
	 * Because this process needs sessions, this functions is added to
	 * SiteLogin event.
	 * 
	 * @param XoopsUser $xoopsUser Must parameter, because this is added to login event.
	 */
	function doChangeTheme(&$principal, &$controller, &$context)
	{
		if (!empty($_POST['xoops_theme_select'])) {
		    $xoops_theme_select = explode('!-!', $_POST['xoops_theme_select']);
		    if ($this->_isSelectableTheme($xoops_theme_select[0])) {
    			$this->mRoot->mContext->setThemeName($xoops_theme_select[0]);
    			$_SESSION['xoopsUserTheme'] = $xoops_theme_select[0];
    			$controller->executeForward($GLOBALS['xoopsRequestUri']);
    		}
		} elseif (!empty($_SESSION['xoopsUserTheme']) && $this->_isSelectableTheme($_SESSION['xoopsUserTheme'])) {
			$this->mRoot->mContext->setThemeName($_SESSION['xoopsUserTheme']);
		}
	}

	function callbackCheckLoginSuccess(&$xoopsUser)
	{
		//
		// Check Theme and set it to session.
		//
		$userTheme = $xoopsUser->get('theme');
		if (in_array($userTheme, $this->mRoot->mContext->getXoopsConfig('theme_set_allowed'))) {
			$_SESSION['xoopsUserTheme'] = $userTheme;
			$this->mRoot->mContext->setThemeName($userTheme);
		}
	}
	
	function _isSelectableTheme($theme_name)
	{
		return in_array($theme_name, $this->mRoot->mContext->getXoopsConfig('theme_set_allowed'));
	}


}

