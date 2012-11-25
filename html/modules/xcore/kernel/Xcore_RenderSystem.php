<?php

/**
 * Compatible render system with XOOPS 2 Themes & Templates.
 *
 * This manages theme and main render-target directly. And, this realizes
 * variable-sharing-mechanism with using smarty.
 */
class Xcore_RenderSystem extends XCube_RenderSystem
{
	var $mXoopsTpl;

	/**
	 * Temporary
	 */
	var $mThemeRenderTarget;
	
	/**
	 * Temporary
	 */
	var $mMainRenderTarget;
	
	var $_mContentsData = null;

	/**
	 * @type XCube_Delegate
	 */
	var $mSetupXoopsTpl = null;
	
	/**
	 * @private
	 */
	var $_mIsActiveBanner = false;

	var $mBeginRender = null;
	
	function Xcore_RenderSystem()
	{
		parent::XCube_RenderSystem();
		$this->mSetupXoopsTpl =new XCube_Delegate();
		$this->mSetupXoopsTpl->register('Xcore_RenderSystem.SetupXoopsTpl');

		$this->mBeginRender =new XCube_Delegate();
		$this->mBeginRender->register('Xcore_RenderSystem.BeginRender');
	}
	
	function prepare(&$controller)
	{
		parent::prepare($controller);
		
		$root =& $this->mController->mRoot;
		$context =& $root->getContext();
		$textFilter =& $root->getTextFilter();
		
		// XoopsTpl default setup
		if ( isset($GLOBALS['xoopsTpl']) ) {
			$this->mXoopsTpl =& $GLOBALS['xoopsTpl'];
		} else {
			$this->mXoopsTpl =new Xcore_XoopsTpl();
		}
		$mTpl = $this->mXoopsTpl;
		$mTpl->register_function('xcore_notifications_select', 'XcoreRender_smartyfunction_notifications_select');
		$this->mSetupXoopsTpl->call(new XCube_Ref($mTpl));

		// compatible
		$GLOBALS['xoopsTpl'] =& $mTpl;
		
		$mTpl->xoops_setCaching(0);

		// If debugger request debugging to me, send debug mode signal by any methods.
		if ($controller->mDebugger->isDebugRenderSystem()) {
			$mTpl->xoops_setDebugging(true);
		}
		
   		$mTpl->assign(array('xoops_requesturi' => htmlspecialchars($GLOBALS['xoopsRequestUri'], ENT_QUOTES),	//@todo ?????????????
							// set JavaScript/Weird, but need extra <script> tags for 2.0.x themes
							'xoops_js' => '//--></script><script type="text/javascript" src="'.XOOPS_URL.'/js/xoops.js"></script><script type="text/javascript"><!--'
						));
	
		$mTpl->assign('xoops_sitename', $textFilter->toShow($context->getAttribute('xcore_sitename')));
		$mTpl->assign('xoops_pagetitle', $textFilter->toShow($context->getAttribute('xcore_pagetitle')));
		$mTpl->assign('xoops_slogan', $textFilter->toShow($context->getAttribute('xcore_slogan')));

		// --------------------------------------
		// Meta tags
		// --------------------------------------
		$moduleHandler = xoops_gethandler('module');
		$xcoreRender =& $moduleHandler->getByDirname('xcoreRender');
		
		if (is_object($xcoreRender)) {
			$configHandler = xoops_gethandler('config');
			$configs =& $configHandler->getConfigsByCat(XOOPS_CONF_METAFOOTER);
			
			//
			// If this site has the setting of banner.
			// TODO this process depends on XOOPS 2.0.x.
			//
			$this->_mIsActiveBanner = $configs['banners'];
			if (XCORE_RENDERSYSTEM_BANNERSETUP_BEFORE == true) {
				if ($configs['banners'] == 1) {
					$mTpl->assign('xoops_banner',xoops_getbanner());
				}
				else {
					$mTpl->assign('xoops_banner','&nbsp;');
				}
			}
		}
		else {
			$mTpl->assign('xoops_banner','&nbsp;');
		}
		
		// --------------------------------------
		// Add User
		// --------------------------------------
		$arr = null;
		if (is_object($context->mXoopsUser)) {
			$arr = array(
				'xoops_isuser' => true,
				'xoops_userid' => $context->mXoopsUser->getVar('uid', 'n'),
				'xoops_uname' => $context->mXoopsUser->getVar('uname')
			);
		}
		else {
			$arr = array(
				'xoops_isuser' => false
			);
		}
		
		$mTpl->assign($arr);
	}

	function setAttribute($key,$value)
	{
		$this->mRenderTarget->setAttribute($key,$value);
	}
	
	function getAttribute($key)
	{
		$this->mRenderTarget->getAttribute($key);
	}

	/**
	 * @protected
	 * Assign common variables for the compatibility with X2.
	 */
	function _commonPrepareRender()
	{
		$root =& $this->mController->mRoot;
		$context =& $root->getContext();
		$textFilter =& $root->getTextFilter();

		$themeName = $context->getThemeName();
   		$vars = array('xoops_theme'=>$themeName,
					  'xoops_imageurl'=>XOOPS_THEME_URL . "/${themeName}/",
					  'xoops_themecss'=>xoops_getcss($themeName),
					  'xoops_sitename'=>$textFilter->toShow($context->getAttribute('xcore_sitename')),
					  'xoops_pagetitle'=>$textFilter->toShow($context->getAttribute('xcore_pagetitle')),
					  'xoops_slogan'=>$textFilter->toShow($context->getAttribute('xcore_slogan')));

		//
		// Assign module informations.
		//
		if($context->mModule != null) {	// The process of module
			$xoopsModule =& $context->mXoopsModule;
			$vars['xoops_modulename'] = $xoopsModule->getVar('name');
			$vars['xoops_dirname'] = $xoopsModule->getVar('dirname');
		}
		
		if (isset($GLOBALS['xoopsUserIsAdmin'])) {
			$vars['xoops_isadmin']=$GLOBALS['xoopsUserIsAdmin'];
		}
		$this->mXoopsTpl->assign($vars);
	}
	
	function renderBlock(&$target)
	{
		$this->_commonPrepareRender();
		
		//
		// Temporary
		//
		$mTpl = $this->mXoopsTpl;
		$mTpl->xoops_setCaching(0);

		$vars = $target->getAttributes();
		$mTpl->assign($vars);

		$this->mBeginRender->call(new XCube_Ref($mTpl));
		$result=&$mTpl->fetchBlock($target->getTemplateName(),$target->getAttribute('bid'));
		$target->setResult($result);
		
		//
		// Reset
		//
		$mTpl->clear_assign(array_keys($vars));
	}
	
	function _render(&$target)
	{
		foreach($target->getAttributes() as $key=>$value) {
			$this->mXoopsTpl->assign($key,$value);
		}

		$this->mBeginRender->call(new XCube_Ref($this->mXoopsTpl), $target->getAttribute('xcore_buffertype'));
		$result=$this->mXoopsTpl->fetch('db:'.$target->getTemplateName());
		$target->setResult($result);

		foreach ($target->getAttributes() as $key => $value) {
			$this->mXoopsTpl->clear_assign($key);
		}
	}
	
	function render(&$target)
	{
		//
		// The following lines are temporary until we will finish changing the style!
		//
		switch ($target->getAttribute('xcore_buffertype')) {
			case XCUBE_RENDER_TARGET_TYPE_BLOCK:
				$this->renderBlock($target);
				break;

			case XCUBE_RENDER_TARGET_TYPE_MAIN:
				$this->renderMain($target);
				break;

			case XCUBE_RENDER_TARGET_TYPE_THEME:
				$this->renderTheme($target);
				break;

			case XCUBE_RENDER_TARGET_TYPE_BUFFER:
			default:
				break;
		}
	}

	function renderMain(&$target)
	{
		$this->_commonPrepareRender();
		
		$cachedTemplateId = isset($GLOBLAS['xoopsCachedTemplateId']) ? $GLOBLAS['xoopsCachedTemplateId'] : null;

		foreach($target->getAttributes() as $key=>$value) {
			$this->mXoopsTpl->assign($key,$value);
		}

		if ($target->getTemplateName()) {
			if ($cachedTemplateId!==null) {
				$contents=$this->mXoopsTpl->fetch('db:'.$target->getTemplateName(), $xoopsCachedTemplateId);
			} else {
				$contents=$this->mXoopsTpl->fetch('db:'.$target->getTemplateName());
			}
		} else {
			if ($cachedTemplateId!==null) {
				$this->mXoopsTpl->assign('dummy_content', $target->getAttribute('stdout_buffer'));
				$contents=$this->mXoopsTpl->fetch($GLOBALS['xoopsCachedTemplate'], $xoopsCachedTemplateId);
			} else {
				$contents=$target->getAttribute('stdout_buffer');
			}
		}
		
		$target->setResult($contents);
	}

	function renderTheme(&$target)
	{
		$this->_commonPrepareRender();
	
		//jQuery Ready functions
		$mRoot = $this->mController->mRoot;
		$mContext = $mRoot->mContext;
		XCube_DelegateUtils::call('Site.JQuery.AddFunction', new XCube_Ref($mContext->mAttributes['headerScript']));
		$headerScript = $mContext->getAttribute('headerScript');
		$mTpl = $this->mXoopsTpl;
		$moduleHeader = $mTpl->get_template_vars('xoops_module_header');
		$moduleHeader =  $headerScript->createLibraryTag() . $moduleHeader . $headerScript->createOnloadFunctionTag();

		//
		// Assign from attributes of the render-target.
		//
		$vars = $target->getAttributes();
		$vars['xoops_module_header'] = $moduleHeader;
		
		$moduleHandler = xoops_gethandler('module');
		$xcoreRender =& $moduleHandler->getByDirname('xcoreRender');
		$configHandler = xoops_gethandler('config');
		$configs =& $configHandler->getConfigsByCat(XOOPS_CONF_METAFOOTER);
	
		$textFilter =& $mRoot->getTextFilter();
		$headerScript = $mContext->getAttribute('headerScript');
		$vars['xoops_meta_keywords'] = $textFilter->toShow($headerScript->getMeta('keywords') ? $headerScript->getMeta('keywords') : $configs['meta_keywords']);
		$vars['xoops_meta_description'] = $textFilter->toShow($headerScript->getMeta('description') ? $headerScript->getMeta('description') : $configs['meta_description']);
		$vars['xoops_meta_robots'] = $textFilter->toShow($headerScript->getMeta('robots') ? $headerScript->getMeta('robots') : $configs['meta_robots']);
		$vars['xoops_meta_rating'] = $textFilter->toShow($headerScript->getMeta('rating') ? $headerScript->getMeta('rating') : $configs['meta_rating']);
		$vars['xoops_meta_author'] = $textFilter->toShow($headerScript->getMeta('author') ? $headerScript->getMeta('author') : $configs['meta_author']);
		$vars['xoops_meta_copyright'] = $textFilter->toShow($headerScript->getMeta('copyright') ? $headerScript->getMeta('copyright') : $configs['meta_copyright']);
		$vars['xoops_footer'] = $configs['footer']; // footer may be raw HTML text.
	
		//
		// If this site has the setting of banner.
		// TODO this process depends on XOOPS 2.0.x.
		//
		if (XCORE_RENDERSYSTEM_BANNERSETUP_BEFORE == false) {
			$vars['xoops_banner'] = ($this->_mIsActiveBanner == 1)?xoops_getbanner():'&nbsp;';
		}

		$mTpl->assign($vars);

		//
		// [TODO]
		// We must implement with a render-target.
		//
		// $this->_processXcoreTemplate();

		// assing
		/// @todo I must move these to somewhere.
		$assignNameMap = array(
				XOOPS_SIDEBLOCK_LEFT=>array('showflag'=>'xoops_showlblock','block'=>'xoops_lblocks'),
				XOOPS_CENTERBLOCK_LEFT=>array('showflag'=>'xoops_showcblock','block'=>'xoops_clblocks'),
				XOOPS_CENTERBLOCK_RIGHT=>array('showflag'=>'xoops_showcblock','block'=>'xoops_crblocks'),
				XOOPS_CENTERBLOCK_CENTER=>array('showflag'=>'xoops_showcblock','block'=>'xoops_ccblocks'),
				XOOPS_SIDEBLOCK_RIGHT=>array('showflag'=>'xoops_showrblock','block'=>'xoops_rblocks')
			);

		foreach($assignNameMap as $key=>$val) {
			$mTpl->assign($val['showflag'],$this->_getBlockShowFlag($val['showflag']));
			if(isset($mContext->mAttributes['xcore_BlockContents'][$key])) {
				foreach($mContext->mAttributes['xcore_BlockContents'][$key] as $result) {
					$mTpl->append($val['block'], $result);
				}
			}
		}

		$this->mBeginRender->call(new XCube_Ref($mTpl));
		
		//
		// Render result, and set it to the RenderBuffer of the $target.
		//
		$result=null;
		if($target->getAttribute('isFileTheme')) {
			$result=$mTpl->fetch($target->getTemplateName().'/theme.html');
		}
		else {
			$result=$mTpl->fetch('db:'.$target->getTemplateName());
		}
		
		$result .= $mTpl->fetchDebugConsole();

		$target->setResult($result);
	}

	function _getBlockShowFlag($area) {
		switch($area) {
			case 'xoops_showrblock' :
				if (isset($GLOBALS['show_rblock']) && empty($GLOBALS['show_rblock'])) return 0;
				return (!empty($this->mController->mRoot->mContext->mAttributes['xcore_BlockShowFlags'][XOOPS_SIDEBLOCK_RIGHT])) ? 1 : 0;
				break;
			case 'xoops_showlblock' :
				if (isset($GLOBALS['show_lblock']) && empty($GLOBALS['show_lblock'])) return 0;
				return (!empty($this->mController->mRoot->mContext->mAttributes['xcore_BlockShowFlags'][XOOPS_SIDEBLOCK_LEFT])) ? 1 : 0;
				break;
			case 'xoops_showcblock' :
				if (isset($GLOBALS['show_cblock']) && empty($GLOBALS['show_cblock'])) return 0;
				return (!empty($this->mController->mRoot->mContext->mAttributes['xcore_BlockShowFlags'][XOOPS_CENTERBLOCK_LEFT])||
						!empty($this->mController->mRoot->mContext->mAttributes['xcore_BlockShowFlags'][XOOPS_CENTERBLOCK_RIGHT])||
						!empty($this->mController->mRoot->mContext->mAttributes['xcore_BlockShowFlags'][XOOPS_CENTERBLOCK_CENTER])) ? 1 : 0;
				break;
			default :
				return 0;
		}
	}
	//
	// There must not be the following functions here!
	//
	//

	/**
	 * @deprecated
	 */
	function sendHeader()
	{
		header('Content-Type:text/html; charset='._CHARSET);
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
	}

	/**
	 * @deprecated
	 */
	function showXoopsHeader($closeHead=true)
	{
		global $xoopsConfig;
		$myts =& MyTextSanitizer::getInstance();
		if ($xoopsConfig['gzip_compression'] == 1) {
			ob_start('ob_gzhandler');
		} else {
			ob_start();
		}

		$this->sendHeader();
		$this->_renderHeader($closeHead);
	}
	
	// TODO never direct putput
	/**
	 * @deprecated
	 */
	function _renderHeader($closehead=true)
	{
		global $xoopsConfig, $xoopsTheme, $xoopsConfigMetaFooter;

		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';

		echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="'._LANGCODE.'" lang="'._LANGCODE.'">
		<head>
		<meta http-equiv="content-type" content="text/html; charset='._CHARSET.'" />
		<meta http-equiv="content-language" content="'._LANGCODE.'" />
		<meta name="robots" content="'.htmlspecialchars($xoopsConfigMetaFooter['meta_robots']).'" />
		<meta name="keywords" content="'.htmlspecialchars($xoopsConfigMetaFooter['meta_keywords']).'" />
		<meta name="description" content="'.htmlspecialchars($xoopsConfigMetaFooter['meta_desc']).'" />
		<meta name="rating" content="'.htmlspecialchars($xoopsConfigMetaFooter['meta_rating']).'" />
		<meta name="author" content="'.htmlspecialchars($xoopsConfigMetaFooter['meta_author']).'" />
		<meta name="copyright" content="'.htmlspecialchars($xoopsConfigMetaFooter['meta_copyright']).'" />
		<meta name="generator" content="XOOPS" />
		<title>'.htmlspecialchars($xoopsConfig['sitename']).'</title>
		<script type="text/javascript" src="'.XOOPS_URL.'/js/xoops.js"></script>
		';
		$themecss = getcss($xoopsConfig['theme_set']);
		echo '<link rel="stylesheet" type="text/css" media="all" href="'.XOOPS_URL.'/xoops.css" />';
		if ($themecss) {
			echo '<link rel="stylesheet" type="text/css" media="all" href="'.$themecss.'" />';
			//echo '<style type="text/css" media="all"><!-- @import url('.$themecss.'); --></style>';
		}
		if ($closehead) {
			echo '</head><body>';
		}
	}
	
	/**
	 * @deprecated
	 */
	function _renderFooter()
	{
		echo '</body></html>';
		ob_end_flush();
	}
	
	/**
	 * @deprecated
	 */
	function showXoopsFooter()
	{
		$this->_renderFooter();
	}

	function &createRenderTarget($type = XCORE_RENDER_TARGET_TYPE_MAIN, $option = null)
	{
		$renderTarget = null;
		switch ($type) {
			case XCUBE_RENDER_TARGET_TYPE_MAIN:
				$renderTarget =new Xcore_RenderTargetMain();
				break;
				
			case XCORE_RENDER_TARGET_TYPE_BLOCK:
				$renderTarget =new XCube_RenderTarget();
				$renderTarget->setAttribute('xcore_buffertype', XCORE_RENDER_TARGET_TYPE_BLOCK);
				break;
				
			default:
				$renderTarget =new XCube_RenderTarget();
				break;
		}

		return $renderTarget;
	}
	
	/**
	 * @TODO This function is not cool!
	 */
	function &getThemeRenderTarget($isDialog = false)
	{
		$screenTarget = $isDialog ? new Xcore_DialogRenderTarget() : new Xcore_ThemeRenderTarget();
		return $screenTarget;
	}
}
