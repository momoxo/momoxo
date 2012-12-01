<?php

/**
 * @brief The specific FILE-TYPE render-system.
 * @todo We depends on Xcore_RenderSystem that a add-in module defines. We must stop this situation.
 */
use XCore\Kernel\Root;

class Xcore_AdminRenderSystem extends Xcore_RenderSystem
{
	var $mController;
	var $mSmarty;
	
	/**
	 * This is the buffer which stores standard output when the render-target
	 * in renderMain() doesn't use a template.
	 * 
	 * @access private
	 * @var string
	 */
	var $_mStdoutBuffer = null;
	
	function prepare(&$controller)
	{
		$this->mController =& $controller;
		
		$this->mSmarty =new Xcore_AdminSmarty();
		$this->mSmarty->register_modifier('theme', 'Xcore_modifier_theme');
		$this->mSmarty->register_function('stylesheet', 'Xcore_function_stylesheet');

		$this->mSmarty->assign(array(
			'xoops_url' 	   => XOOPS_URL,
			'xoops_rootpath'   => XOOPS_ROOT_PATH,
			'xoops_langcode'   => _LANGCODE,
			'xoops_charset'    => _CHARSET,
			'xoops_version'    => XOOPS_VERSION,
			'xoops_upload_url' => XOOPS_UPLOAD_URL)
		);

		if ($controller->mRoot->mSiteConfig['Xcore_AdminRenderSystem']['ThemeDevelopmentMode'] == true) {
			$this->mSmarty->force_compile = true;
		}
	}
	
	function renderBlock(&$target)
	{
		$this->mSmarty->template_dir = XOOPS_ROOT_PATH . '/modules/xcore/admin/templates';

		foreach ($target->getAttributes() as $key => $value) {
			$this->mSmarty->assign($key, $value);
		}
		
		$this->mSmarty->setModulePrefix($target->getAttribute('xcore_module'));
		$result = $this->mSmarty->fetch('blocks/' . $target->getTemplateName());
		$target->setResult($result);

		//
		// Reset
		//
		foreach($target->getAttributes() as $key => $value) {
			$this->mSmarty->clear_assign($key);
		}
	}
	
	function renderTheme(&$target)
	{
		//
		// Assign from attributes of the render-target.
		//
		$smarty = $this->mSmarty;
		$vars = array('stdout_buffer'=>$this->_mStdoutBuffer);
		foreach($target->getAttributes() as $key=>$value) {
			$vars[$key] = $value;
		}

		//jQuery Ready functions
		$context = $this->mController->mRoot->mContext;
		XCube_DelegateUtils::call('Site.JQuery.AddFunction', new XCube_Ref($context->mAttributes['headerScript']));
		$headerScript = $context->getAttribute('headerScript');
		$moduleHeader =  $headerScript->createLibraryTag() . $headerScript->createOnloadFunctionTag();
		$vars['xoops_module_header'] = $moduleHeader;
	
		//
		// Get a virtual current module object from the controller and assign it.
		//
		$moduleObject =& $this->mController->getVirtualCurrentModule();
		$vars['currentModule'] = $moduleObject;

		//
		// Other attributes
		//
		$vars['xcore_sitename'] = $context->getAttribute('xcore_sitename');
		$vars['xcore_pagetitle'] = $context->getAttribute('xcore_pagetitle');
		$vars['xcore_slogan'] = $context->getAttribute('xcore_slogan');
		
		//
		// Theme rendering
		//
		$blocks = array();
		foreach($context->mAttributes['xcore_BlockContents'][0] as $key => $result) {
			// $smarty->append('xoops_lblocks', $result);
			$blocks[$result['name']] = $result;
		}
		$vars['xoops_lblocks'] = $blocks;

		$smarty->assign($vars);
		
		//
		// Check Theme or Fallback
		//
		$root = Root::getSingleton();
		$theme = $root->mSiteConfig['Xcore']['Theme'];
		
		if (file_exists(XOOPS_ROOT_PATH.'/themes/'.$theme.'/admin_theme.html')) {
			$smarty->template_dir=XOOPS_THEME_PATH.'/'.$theme;
		}
		else {
			$smarty->template_dir=XCORE_ADMIN_RENDER_FALLBACK_PATH;
		}

		$smarty->setModulePrefix('');
		$result=$smarty->fetch('file:admin_theme.html');

		$target->setResult($result);
	}

	function renderMain(&$target)
	{
		//
		// Assign from attributes of the render-target.
		//
		foreach ($target->getAttributes() as $key=>$value) {
			$this->mSmarty->assign($key, $value);
		}
		
		$result = null;
		
		if ($target->getTemplateName()) {
			if ($target->getAttribute('xcore_module') != null) {
				$this->mSmarty->setModulePrefix($target->getAttribute('xcore_module'));
				$this->mSmarty->template_dir = XOOPS_MODULE_PATH . '/' . $target->getAttribute('xcore_module') . '/admin/'. XCORE_ADMIN_RENDER_TEMPLATE_DIRNAME;
			}
			
			$result=$this->mSmarty->fetch('file:'.$target->getTemplateName());
			$buffer = $target->getAttribute('stdout_buffer');
			
			$this->_mStdoutBuffer .= $buffer;
		}
		else {
			$result=$target->getAttribute('stdout_buffer');
		}
		
		$target->setResult($result);

		//
		// Clear assign.
		//
		foreach ($target->getAttributes() as $key=>$value) {
			$this->mSmarty->clear_assign($key);
		}
	}
}
