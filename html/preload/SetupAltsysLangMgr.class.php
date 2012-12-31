<?php

use XCore\Kernel\Root;
use XCore\Kernel\ActionFilter;

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

if( ! defined( 'XOOPS_TRUST_PATH' ) || XOOPS_TRUST_PATH == '' ) {
	header( 'Location: '.XOOPS_URL.'/modules/altsys/setup_xoops_trust_path.php' ) ;
	exit ;
}

define('ALTSYS_MYLANGUAGE_ROOT_PATH', XOOPS_ROOT_PATH . '/my_language');


class SetupAltsysLangMgr extends ActionFilter
{
	function preFilter()
	{
		$this->mController->mCreateLanguageManager->add(array($this, 'createLanguageManager'));
	}
	
	function createLanguageManager(&$langManager, $languageName)
	{
		$langManager = new AltsysLangMgr_LanguageManager();
	}
}

class AltsysLangMgr_LanguageManager extends Xcore_LanguageManager
{
	var $langman = null ;
	var $theme_lang_checked = false ;

	function prepare()
	{
		$langmanpath = XOOPS_TRUST_PATH.'/modules/altsys/class/D3LanguageManager.class.php' ;
		if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
		require_once( $langmanpath ) ;
		$this->langman =& D3LanguageManager::getInstance() ;
		$this->langman->language = $this->mLanguageName ;

		parent::prepare();
	}

	function _loadLanguage($dirname, $fileBodyName)
	{
		// read/check once (selected_theme)/language/(lang).php
		if( ! $this->theme_lang_checked ) {
			$root = Root::getSingleton() ;
			if( ! empty( $root->mContext->mXoopsConfig['theme_set'] ) ) {
				$langdir = XOOPS_THEME_PATH.'/'.$root->mContext->mXoopsConfig['theme_set'].'/language' ;
				if( file_exists( $langdir ) ) {
					$langfile = $langdir.'/'.$this->mLanguageName.'.php' ;
					$engfile = $langdir.'/english.php' ;
					if( file_exists( $langfile ) ) require_once $langfile ;
					else if( file_exists( $engfile ) ) require_once $engfile ;
				}
				$this->theme_lang_checked = true ;
			}
		}
		
		// read normal
		$this->langman->read( $fileBodyName.'.php' , $dirname ) ;
	}

	function loadPageTypeMessageCatalog($type)
	{
		// I dare not to use langman...
		if( strpos( $type , '.' ) === false && $this->langman->my_language ) {
			$mylang_file = $this->langman->my_language.'/'.$this->mLanguageName.'/'.$type.'.php' ;
			if( file_exists( $mylang_file ) ) {
				require_once $mylang_file ;
			}
		}
		$original_error_level = error_reporting() ;
		error_reporting( $original_error_level & ~ E_NOTICE ) ;
		parent::loadPageTypeMessageCatalog($type);
		error_reporting( $original_error_level ) ;
	}

	function loadGlobalMessageCatalog()
	{
		/* if (!$this->_loadFile(XOOPS_ROOT_PATH . "/modules/xcore/language/" . $this->mLanguageName . "/global.php")) {
			$this->_loadFile(XOOPS_ROOT_PATH . "/modules/xcore/language/english/global.php");
		} */
		$this->_loadLanguage( 'xcore' , 'global' ) ;
		$this->_loadLanguage( 'xcore' , 'setting' ) ;

		//
		// Now, if XOOPS_USE_MULTIBYTES isn't defined, set zero to it.
		//
		if (!defined("XOOPS_USE_MULTIBYTES")) {
			define("XOOPS_USE_MULTIBYTES", 0);
		}
	}


}

?>