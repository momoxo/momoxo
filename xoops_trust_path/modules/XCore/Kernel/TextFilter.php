<?php

namespace XCore\Kernel;

/**
 *
 * @final
 * @todo final なのに継承しているクラスがある…
 */
class TextFilter
{
	public $mDummy = null; //Dummy member for preventing object be treated as empty.

	public static function getInstance(&$instance)
	{
		if ( empty($instance) ) {
			$instance = new TextFilter();
		}
	}

	/**
	 * @param string $str
	 * @return string
	 */
	public function toShow($str)
	{
		return htmlspecialchars($str, ENT_QUOTES);
	}

	/**
	 * @param string $str
	 * @return string
	 */
	public function toEdit($str)
	{
		return htmlspecialchars($str, ENT_QUOTES);
	}
}

