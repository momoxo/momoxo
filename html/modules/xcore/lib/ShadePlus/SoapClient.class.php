<?php

class ShadePlus_SoapClient extends XCube_AbstractServiceClient
{
	var $mClient = null;
	
	function ShadePlus_SoapClient(&$service)
	{
		parent::XCube_AbstractServiceClient($service);
		$this->mClient =new soap_client($service, true);
		$this->mClient->decodeUTF8(false);
	}
	
	function call($operation, $args)
	{
		$root =& XCube_Root::getSingleton();
		
		$args = $this->_encodeUTF8($args, $root->mLanguageManager);
		
		$retValue = $this->mClient->call($operation, $args);
		
		if (is_array($retValue)) {
			$retValue = $this->_decodeUTF8($retValue, $root->mLanguageManager);
		}
		else {
			$retValue = $root->mLanguageManager->decodeUTF8($retValue);
		}
		
		return $retValue;
	}
	
	function _encodeUTF8($arr, &$languageManager)
	{
		foreach (array_keys($arr) as $key) {
			if (is_array($arr[$key])) {
				$arr[$key] = $this->_encodeUTF8($arr[$key], $languageManager);
			}
			else {
				$arr[$key] = $languageManager->encodeUTF8($arr[$key]);
			}
		}
		
		return $arr;
	}

	function _decodeUTF8($arr, &$languageManager)
	{
		foreach (array_keys($arr) as $key) {
			if (is_array($arr[$key])) {
				$arr[$key] = $this->_decodeUTF8($arr[$key], $languageManager);
			}
			else {
				$arr[$key] = $languageManager->decodeUTF8($arr[$key]);
			}
		}
		
		return $arr;
	}
}

