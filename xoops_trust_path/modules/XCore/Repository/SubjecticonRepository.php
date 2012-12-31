<?php


namespace XCore\Repository;

use XCore\Repository\ObjectRepository;
use XCore\Entity\Subjecticon;

class SubjecticonRepository extends ObjectRepository
{
	var $_mResult;
	
	function __construct(&$db)
	{
		$this->_mResult =& XoopsLists::getSubjectsList();
	}
	
	function &create()
	{
		$ret =new Subjecticon();
		return $ret;
	}
	
	function &get($filename)
	{
		if (isset($this->_mResult[$filename])) {
			$obj =new Subjecticon();
			$obj->setVar('filename', $this->_mResult[$filename]);

			return $obj;
		}
		
		$ret = null;
		return $ret;
	}

	function &getObjects($criteria = null, $key_as_id = false)
	{
		$ret = array();
		
		foreach ($this->_mResult as $filename => $value) {
			$obj =new Subjecticon();
			$obj->setVar('filename', $filename);
			if ($key_as_id) {
				$ret[$filename] =& $obj;
			}
			else {
				$ret[] =& $obj;
			}
			unset($obj);
		}
		
		return $ret;
	}
	
	function insert(&$obj)
	{
		return false;
	}

	function delete(&$obj)
	{
		return false;
	}
}
