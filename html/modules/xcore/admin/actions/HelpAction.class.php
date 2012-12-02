<?php

/***
 * @internal
 * 
 * The sub-class of smarty for help viewer, make it possible to use smarty in
 * help html file. This class extends Smarty to mediate the collision compiled
 * file name.
 * 
 * To support help view, there are some original modifiers.
 * 
 * 'helpurl' modify a relativity URL for connecting the dynamic page link.
 * 'helpimage' modify a image URL. These modifiers consider the existence of
 * language files.
 */
use XCore\Kernel\Root;
use XCore\Kernel\Ref;

class Xcore_HelpSmarty extends Smarty
{
	/**
	 * @var string
	 */
	var $mDirname = null;
	
	/**
	 * @var XoopsModule
	 */
	var $mModuleObject = null;
	
	/**
	 * @var string
	 */
	var $mFilename = null;

	function Xcore_HelpSmarty()
	{
		parent::Smarty();

		$this->compile_id = null;
		$this->_canUpdateFromFile = true;
		$this->compile_check = true;
		$this->compile_dir = XOOPS_COMPILE_PATH;
		$this->left_delimiter = "<{";
		$this->right_delimiter = "}>";
		
		$this->force_compile = true;

		$this->register_modifier("helpurl", "Xcore_modifier_helpurl");
		$this->register_modifier("helpimage", "Xcore_modifier_helpimage");
	}
	
	function setDirname($dirname)
	{
		$this->mDirname = $dirname;
	}

	function _get_auto_filename($autoBase, $autoSource = null, $auotId = null)
	{
		$autoSource = $this->mDirname . "_help_" . $autoSource;
		return parent::_get_auto_filename($autoBase, $autoSource, $auotId);
	}
}

function Xcore_modifier_helpurl($file, $dirname = null )
{
	$root = Root::getSingleton();
	
	$language = $root->mContext->getXoopsConfig('language');
	$dirname = $root->mContext->getAttribute('xcore_help_dirname');

	if ( $dirname == null ) {
		$moduleObject =& $root->mContext->mXoopsModule;
		$dirname = $moduleObject->get('dirname');
	}

	//
	// TODO We should check file_exists.
	//

	$url = XOOPS_MODULE_URL . "/xcore/admin/index.php?action=Help&amp;dirname=${dirname}&amp;file=${file}";

	return $url;
}

function Xcore_modifier_helpimage($file)
{
	$root = Root::getSingleton();
	
	$language = $root->mContext->getXoopsConfig('language');
	$dirname = $root->mContext->getAttribute('xcore_help_dirname');

	$path = "/${dirname}/language/${language}/help/images/${file}";
	if (!file_exists(XOOPS_MODULE_PATH . $path) && $language != "english") {
		$path = "/${dirname}/language/english/help/images/${file}";
	}

	return XOOPS_MODULE_URL . $path;
}

/***
 * @internal
 * This action will show the information of a module specified to user.
 */
class Xcore_HelpAction extends Xcore_Action
{
	var $mModuleObject = null;
	var $mContents = null;

	var $mErrorMessage = null;
	
	/**
	 * @access private
	 */
	var $_mDirname = null;
	
	/**
	 * @var XCube_Delegate
	 */
	var $mCreateHelpSmarty = null;
	
	function Xcore_HelpAction($flag)
	{
		parent::Xcore_Action($flag);
		
		$this->mCreateHelpSmarty =new XCube_Delegate();
		$this->mCreateHelpSmarty->add(array(&$this, '_createHelpSmarty'));
		$this->mCreateHelpSmarty->register('Xcore_HelpAction.CreateHelpSmarty');
	}
	
	function prepare(&$controller, &$xoopsUser)
	{
		parent::prepare($controller, $xoopsUser);
		$this->_mDirname = xoops_getrequest('dirname');
	}
	
	function hasPermission(&$controller, &$xoopsUser)
	{
		$dirname = xoops_getrequest('dirname');
		$controller->mRoot->mRoleManager->loadRolesByDirname($this->_mDirname);
		return $controller->mRoot->mContext->mUser->isInRole('Module.' . $dirname . '.Admin');
	}
	
	function getDefaultView(&$controller, &$xoopsUser)
	{
		$moduleHandler =& xoops_gethandler('module');
		$this->mModuleObject =& $moduleHandler->getByDirname($this->_mDirname);
		
		$language = $controller->mRoot->mContext->getXoopsConfig('language');

		//
		// TODO We must change the following lines to ActionForm.
		//
		$helpfile = xoops_getrequest('file') ? xoops_getrequest('file') : $this->mModuleObject->getHelp();

		//
		// Smarty
		//
		$smarty = null;
		$this->mCreateHelpSmarty->call(new Ref($smarty));
		$smarty->setDirname($this->_mDirname);

		//
		// file check
		//
		// TODO We should not access files in language directory directly.
		//
		$template_dir = XOOPS_MODULE_PATH . "/" . $this->_mDirname . "/language/${language}/help";
		if (!file_exists($template_dir . "/" . $helpfile)) {
			$template_dir = XOOPS_MODULE_PATH . "/" . $this->_mDirname . "/language/english/help";
			if (!file_exists($template_dir . "/" . $helpfile)) {
				$this->mErrorMessage = _AD_XCORE_ERROR_NO_HELP_FILE;
				return XCORE_FRAME_VIEW_ERROR;
			}
		}
		
		$controller->mRoot->mContext->setAttribute('xcore_help_dirname', $this->_mDirname);

		$smarty->template_dir = $template_dir;
		$this->mContents = $smarty->fetch("file:" . $helpfile);

		return XCORE_FRAME_VIEW_SUCCESS;
	}

	function _createHelpSmarty(&$smarty)
	{
		if (!is_object($smarty)) {
			$smarty = new Xcore_HelpSmarty();
		}
	}
	
	function executeViewSuccess(&$controller, &$xoopsUser, &$renderer)
	{
		$renderer->setTemplateName("help.html");
		
		$module =& Xcore_Utils::createModule($this->mModuleObject);
		
		$renderer->setAttribute('module', $module);
		$renderer->setAttribute('contents', $this->mContents);
	}

	function executeViewError(&$controller, &$xoopsUser, &$renderer)
	{
		$controller->executeRedirect('./index.php?action=ModuleList', 1, $this->mErrorMessage);
	}
}

