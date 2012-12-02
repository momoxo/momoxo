<?php

namespace XCore\Kernel;

use XCube_AbstractRequest;

/**
 * Enables a program to read the HTTP values through XCubeAbstractRequest
 * interface.
 */
class HttpRequest extends XCube_AbstractRequest
{
	/**
	 * Gets a value of the current HTTP request. The return value doesn't
	 * include quotes which are appended by magic_quote_gpc, even if it's
	 * active.
	 *
	 * @param string $key
	 * @return mixed
	 */
	function getRequest($key)
	{
		if (!isset($_GET[$key]) && !isset($_POST[$key])) {
			return null;
		}

		$value = isset($_GET[$key]) ? $_GET[$key] : $_POST[$key];

		if (!get_magic_quotes_gpc()) {
			return $value;
		}

		if (is_array($value)) {
			return $this->_getArrayRequest($value);
		}

		return stripslashes($value);
	}

	/**
	 * Supports getRequest().
	 *
	 * @private
	 * @param Array $arr
	 * @return Array
	 */
	function _getArrayRequest($arr)
	{
		foreach (array_keys($arr) as $t_key) {
			if (is_array($arr[$t_key])) {
				$arr[$t_key] = $this->_getArrayRequest($arr[$t_key]);
			}
			else {
				$arr[$t_key] = stripslashes($arr[$t_key]);
			}
		}

		return $arr;
	}
}

