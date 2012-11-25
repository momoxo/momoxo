<?php

class XCube_Object
{
	/**
	 * Member property
	 */
	var $mProperty = array();
	
	/**
	 * @static
	 * @return array
	 */
	function isArray()
	{
		return false;
	}
	
	/**
	 * Return member property information. This member function is called in
	 * the initialize of object and service. This member function has to be
	 * a static function.
	 *
	 * @static
	 * @return array
	 */
	function getPropertyDefinition()
	{
	}
	
	function XCube_Object()
	{
		$fileds = $this->getPropertyDefinition();
		foreach ($fileds as $t_field) {
			$this->mProperty[$t_field['name']] = array(
				'type' => $t_field['type'],
				'value' => null
			);
		}
	}
	
	/**
	 * Initialize. If the exception raises, return false.
	 */
	function prepare()
	{
	}
	
	function toArray()
	{
		$retArray = array();
		
		foreach ($this->mProperty as $t_key => $t_value) {
			$retArray[$t_key] = $t_value['value'];
		}
		
		return $retArray;
	}
	
	function loadByArray($vars)
	{
		foreach ($vars as $t_key => $t_value) {
			if (isset($this->mProperty[$t_key])) {
				$this->mProperty[$t_key]['value'] = $t_value;
			}
		}
	}
}
