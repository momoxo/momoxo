<?php

//%%%%%		TIME FORMAT SETTINGS   %%%%%
use XCore\Kernel\Root;

if (!defined('_DATESTRING')) define("_DATESTRING","Y/n/j G:i:s");
if (!defined('_MEDIUMDATESTRING')) define("_MEDIUMDATESTRING","Y/n/j G:i");
if (!defined('_SHORTDATESTRING')) define("_SHORTDATESTRING","Y/n/j");
define('_JSDATEPICKSTRING','yy-mm-dd');
define('_PHPDATEPICKSTRING','Y-m-d');

//%%%%% 	REQUSTED DATA SETTINGS	 %%%%%
if (!defined('_REQUESTED_DATA_NAME')) define('_REQUESTED_DATA_NAME', 'requested_data_name');
if (!defined('_REQUESTED_ACTION_NAME')) define('_REQUESTED_ACTION_NAME', 'requested_action_name');
if (!defined('_REQUESTED_DATA_ID')) define('_REQUESTED_DATA_ID', 'requested_data_id');

//%%%%%		LANGUAGE SPECIFIC SETTINGS	 %%%%%
@define('_CHARSET', 'UTF-8');
@define('_LANGCODE', 'ja');
mb_language( 'ja' ) ;
// mb_internal_encoding( 'UTF-8' ) ;
// mb_http_output( 'UTF-8' ) ;
@ini_set('default_charset', _CHARSET);

// change 0 to 1 if this language is a multi-bytes language
if (!defined('XOOPS_USE_MULTIBYTES')) define("XOOPS_USE_MULTIBYTES", "1");

// If _MBSTRING_LANGUAGE is defined, the Xcore_LanguageManager class initializes mb functions.
// This mechanism exists for CJK --- Chinese, Japanese, Korean ---
define("_MBSTRING_LANGUAGE", "japanese");


//
// Register the function about local.
//

if ( class_exists('Root') && function_exists('mb_convert_encoding') && function_exists('mb_convert_kana')) {
	$root = Root::getSingleton();
	$root->mDelegateManager->add('Xcore_Mailer.ConvertLocal', 'Xcore_JapaneseUtf8_convLocal');
}

@define('XCORE_MAIL_LANG','ja');
@define('XCORE_MAIL_CHAR','iso-2022-jp');
@define('XCORE_MAIL_ENCO','7bit');

if(! defined('FOR_XOOPS_LANG_CHECKER')) {

function Xcore_JapaneseUtf8_convLocal(&$text, $mime)
{
	if ($mime) {
		switch ($mime) {
			case '1':
				$text = mb_encode_mimeheader($text, XCORE_MAIL_CHAR, 'B', "\n");
				break;
			case '2':
				$text = mb_encode_mimeheader($text, XCORE_MAIL_CHAR, 'B', "");
				break;
		}
	}
	else {
		$text = mb_convert_encoding($text, 'JIS', _CHARSET);
	}
}

function xoops_language_trim($text)
{
	if (function_exists('mb_convert_kana')) {
		$text = mb_convert_kana($text, 's');
	}
	$text = trim($text);
	return $text;
}
}
