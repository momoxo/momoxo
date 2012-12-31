<?php


namespace XCore\Repository;

use XCore\Repository\ObjectRepository;
use XCore\Entity\Cachetime;

class CachetimeRepository extends ObjectRepository
{
	var $_mResult;
	
	function __construct(&$db)
	{
		parent::__construct($db);

		//
		// This handler not connects to database.
		//
		$this->_mResult = array(
			"0"       => _NOCACHE,
			"30"      => sprintf(_SECONDS, 30),
			"60"      => _MINUTE,
			"300"     => sprintf(_MINUTES, 5),
			"1800"    => sprintf(_MINUTES, 30),
			"3600"    => _HOUR,
			"18000"   => sprintf(_HOURS, 5),
			"86400"   => _DAY,
			"259200"  => sprintf(_DAYS, 3),
			"604800"  => _WEEK,
			"2592000" => _MONTH
		);
	}
	
	function &create()
	{
		$ret =new Cachetime();
		return $ret;
	}
	
	function &get($cachetime)
	{
		if (isset($this->_mResult[$cachetime])) {
			$obj =new Cachetime();
			$obj->setVar('cachetime', $cachetime);
			$obj->setVar('label', $this->_mResult[$cachetime]);

			return $obj;
		}
		
		$ret = null;
		return $ret;
	}

	function &getObjects($criteria = null, $key_as_id = false)
	{
		$ret = array();
		
		foreach ($this->_mResult as $cachetime => $label) {
			$obj =new Cachetime();
			$obj->setVar('cachetime', $cachetime);
			$obj->setVar('label', $label);
			if ($key_as_id) {
				$ret[$cachetime] =& $obj;
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
