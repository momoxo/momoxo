<?php


namespace XCore\Database;

/**
 * A criteria (grammar?) for a database query.
 *
 * Abstract base class should never be instantiated directly.
 *
 * @abstract
 *
 * @package     kernel
 * @subpackage  database
 *
 * @author      Kazumi Ono  <onokazu@xoops.org>
 * @copyright   copyright (c) 2000-2003 XOOPS.org
 */
use XCore\Database\Criteria;

abstract class CriteriaElement
{
    /**
     * Sort order
     * @var string
     */
    var $order = array();

    /**
     * @var string
     */
    var $sort = array();

    /**
     * Number of records to retrieve
     * @var int
     */
    var $limit = 0;

    /**
     * Offset of first record
     * @var int
     */
    var $start = 0;

    /**
     * @var string
     */
    var $groupby = '';

    /**
     * Constructor
     **/
    function __construct()
    {

    }

    /**
     * Render the criteria element
     * @deprecated
     */
    function render()
    {

    }
    
    /**
     * Return true if this object has child elements.
     */
    function hasChildElements()
    {
		return false;
	}
    
    function getCountChildElements()
    {
		return 0;
	}
    
    /**
     * Return child element.
     */
	function getChildElement($idx)
	{
		return null;
	}
	
    /**
     * Return condition string.
     */
	function getCondition($idx)
	{
		return null;
	}

	function getName()
	{
		return null;
	}
	
	function getValue()
	{
		return null;
	}
	
	function getOperator()
	{
		return null;
	}

    /**#@+
     * Accessor
     */
    /**
     * @param   string  $sort
     * @param   string  $order
     */
    function setSort($sort, $order = null)
    {
        $this->sort[0] = $sort;
		
		if (!isset($this->order[0])) {
			$this->order[0] = 'ASC';
		}
		
		if ($order != null) {
			if (strtoupper($order) == 'ASC') {
				$this->order[0] = 'ASC';
			}
			elseif (strtoupper($order) == 'DESC') {
				$this->order[0] = 'DESC';
			}
		}
    }
	
	/**
	 * Add sort and order condition to this object.
	 */
	function addSort($sort, $order = 'ASC')
	{
        $this->sort[] = $sort;
		if (strtoupper($order) == 'ASC') {
			$this->order[] = 'ASC';
		}
		elseif (strtoupper($order) == 'DESC') {
			$this->order[] = 'DESC';
		}
	}

    /**
     * @return  string
     */
    function getSort()
    {
		if (isset($this->sort[0])) {
			return $this->sort[0];
		}
		else {
			return '';
		}
    }

	/**
	 * Return sort and order condition as hashmap array.
	 * 
	 * @return hashmap 'sort' ... sort string/key'order' order string.
	 */
	function getSorts()
	{
		$ret = array();
		$max = count($this->sort);
		
		for ($i = 0; $i < $max; $i++) {
			$ret[$i]['sort'] = $this->sort[$i];
			if (isset($this->order[$i])) {
				$ret[$i]['order'] = $this->order[$i];
			}
			else {
				$ret[$i]['order'] = 'ASC';
			}
		}
		
		return $ret;
	}

    /**
     * @param   string  $order
     * @deprecated
     */
    function setOrder($order)
    {
        if (strtoupper($order) == 'ASC') {
            $this->order[0] = 'ASC';
        }
        elseif (strtoupper($order) == 'DESC') {
            $this->order[0] = 'DESC';
        }
    }

    /**
     * @return  string
     */
    function getOrder()
    {
		if (isset($this->order[0])) {
			return $this->order[0];
		}
		else {
			return 'ASC';
		}
    }

    /**
     * @param   int $limit
     */
    function setLimit($limit=0)
    {
        $this->limit = intval($limit);
    }

    /**
     * @return  int
     */
    function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param   int $start
     */
    function setStart($start=0)
    {
        $this->start = intval($start);
    }

    /**
     * @return  int
     */
    function getStart()
    {
        return $this->start;
    }

    /**
     * @param   string  $group
     * @deprecated
     */
    function setGroupby($group){
        $this->groupby = $group;
    }

    /**
     * @return  string
     * @deprecated
     */
    function getGroupby(){
        return ' GROUP BY '.$this->groupby;
    }
    /**#@-*/

	/**
	 * @return string
	 * @deprecated
	 */
	public function renderWhere()
	{
		return '';
	}
}
