<?php
/**
 *
 * @package Xcore
 * @version $Id: function.xoops_explaceholder.php,v 1.3 2008/09/25 15:12:36 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <https://github.com/momoxo/momoxo>
 * @license https://github.com/momoxo/momoxo/blob/master/docs/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     xoops_explaceholder
 * Version:  1.0
 * Date:     Oct 12, 2006
 * Author:   minahito
 * Purpose:  Extended place holder
 * Input:    control =
 * 
 * Examples: <{xoops_explaceholder control=sp_pagenavi pagenavi=$pagenavi}>
 * -------------------------------------------------------------
 */
use XCore\Kernel\Ref;
use XCore\Kernel\DelegateUtils;

function smarty_function_xoops_explaceholder($params, &$smarty)
{
	$buf = null;
	
	if (isset($params['control'])) {
		DelegateUtils::call('Xcore.Event.Explaceholder.Get.' . $params['control'], new Ref($buf), $params);
		
		if ($buf === null) {
			DelegateUtils::call('Xcore.Event.Explaceholder.Get', new Ref($buf), $params['control'], $params);
		}
	}
	
	return $buf;
}

