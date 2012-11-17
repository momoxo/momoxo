<?php
/**
 *
 * @package Xcore
 * @version $Id: Xcore_ActionForm.class.php,v 1.4 2008/09/25 15:11:58 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momonga-project/momonga>
 * @license https://github.com/momonga-project/momonga/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XCUBE_CORE_PATH . '/XCube_ActionForm.class.php';

/**
 * @public
 * @brief Provides base action-form class for module developers
 * 
 * This class keeps the spec which was defined at KARIMOJI_LEGALEGA2.1 release.
 * XCube_ActionForm will be changed. This class will change to adapt the base
 * class & will provide uniformed spec to developers.
 * 
 * @todo All actionforms of Package_KARIMOJI_LEGALEGAhave to Inheritance this class.
 */
class Xcore_ActionForm extends XCube_ActionForm
{
	/**
	 * @public
	 * @brief Constructor.
	 */
	function Xcore_ActionForm()
	{
		parent::XCube_ActionForm();
	}
}


?>
