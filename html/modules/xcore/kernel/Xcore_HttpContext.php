<?php

/**
 * @public
 * @brief [Secret Agreement] The context class for Legacy which extends to keep
 *        Xcore-module-specific informations.
 * @attention
 *     Only Xcore_Controller or its sub-classes calls this constructor.
 */
use XCore\Kernel\Root;
use XCore\Kernel\HttpContext;
use XCore\Entity\User;

class Xcore_HttpContext extends HttpContext
{
	/**
	 * @public
	 * @brief [READ ONLY] User - The current user profile object.
	 */
	var $mXoopsUser = null;

	/**
	 * @public
	 * @brief [READ ONLY] Xcore_AbstractModule - The current module instance.
	 */	
	var $mModule = null;
	
	/**
	 * @public
	 * @brief [READ ONLY] XoopsModule - The current Xoops Module object.
	 * @remarks
	 *     This is a shortcut to mModule->mXoopsModule.
	 */
	var $mXoopsModule = null;
	
	/**
	 * @public
	 * @brief [READ ONLY] Map Array - std::map<string, mixed>
	 *
	 *     This is string collection which indicates site configurations by a site owner.
	 *     Those configuration informations are loaded by the controller, and set. This
	 *     configuration and the site configuration of Root are different.
	 * 
	 *     The array for Xoops, which is configured in the preference of the base. This
	 *     property and $xoopsConfig (X2) is the same.
	 */
	var $mXoopsConfig = array();
	
	/**
	 * @public
	 * @var [READ ONLY] Map Array - std::map<string, mixed> - The array for Xoops Module Config.
	 * @remarks
	 *     This is a short cut to mModule->mConfig.
	 */
	var $mModuleConfig = array();
	
	/**
	 * @public
	 * @internal
	 * @brief [Secret Agreement] A name of the render system used by the controller strategy.
	 * @attention
	 *     This member is used for only Xcore_Controller.
	 */
	var $mBaseRenderSystemName = "";
	
	/**
	 * @public
	 * @brief Gets a value of XoopsConfig by $id.
	 * @param $id string
	 * @return mixed
	 */
	function getXoopsConfig($id = null)
	{
		if ($id != null) {
			return isset($this->mXoopsConfig[$id]) ? $this->mXoopsConfig[$id] : null;
		}

		return $this->mXoopsConfig;
	}
	
	/**
	 * @public
	 * @brief Sets the name of the current theme.
	 * @param $name string
	 * @return void
	 * @attention
	 *     This method is for the theme changer feature. However, this API will be
	 *     changed.
	 */
	function setThemeName($name)
	{
		parent::setThemeName($name);
		$this->mXoopsConfig['theme_set'] = $name;
		$GLOBALS['xoopsConfig']['theme_set'] = $name;
	}
}
