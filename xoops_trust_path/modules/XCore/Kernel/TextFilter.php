<?php

namespace XCore\Kernel;

/**
 *
 * @final
 * @todo final なのに継承しているクラスがある…
 */
class TextFilter
{
	var $mDummy = null; //Dummy member for preventing object be treated as empty.

	public static function getInstance(&$instance)
	{
		if ( empty($instance) ) {
			$instance = new TextFilter();
		}
	}

	function toShow($str)
	{
		return htmlspecialchars($str, ENT_QUOTES);
	}

	function toEdit($str)
	{
		return htmlspecialchars($str, ENT_QUOTES);
	}
}

