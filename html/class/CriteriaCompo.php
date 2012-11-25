<?php

/**
 * Collection of multiple {@link CriteriaElement}s
 *
 * @package     kernel
 * @subpackage  database
 *
 * @author      Kazumi Ono  <onokazu@xoops.org>
 * @copyright   copyright (c) 2000-2003 XOOPS.org
 */
class CriteriaCompo extends CriteriaElement
{

    /**
     * The elements of the collection
     * @var array   Array of {@link CriteriaElement} objects
     */
    var $criteriaElements = array();

    /**
     * Conditions
     * @var array
     */
    var $conditions = array();

    /**
     * Constructor
     *
     * @param   object  $ele
     * @param   string  $condition
     **/
    function CriteriaCompo($ele=null, $condition='AND')
    {
        if (isset($ele) && is_object($ele)) {
            $this->add($ele, $condition);
        }
    }
    
	function hasChildElements()
	{
		return count($this->criteriaElements) > 0;
	}
	
    function getCountChildElements()
    {
		return count($this->criteriaElements);
	}
	
	function getChildElement($idx)
	{
		return $this->criteriaElements[$idx];
	}
	
	function getCondition($idx)
	{
		return $this->conditions[$idx];
	}

    /**
     * Add an element
     *
     * @param   object  &$criteriaElement
     * @param   string  $condition
     *
     * @return  object  reference to this collection
     **/
    function &add(&$criteriaElement, $condition='AND')
    {
        $this->criteriaElements[] =& $criteriaElement;
        $this->conditions[] = $condition;
        return $this;
    }

    /**
     * Make the criteria into a query string
     *
     * @return  string
     * @deprecated XoopsObjectGenericHandler::_makeCriteriaElement4sql()
     */
    function render()
    {
        $ret = '';
        $count = count($this->criteriaElements);
        if ($count > 0) {
			$elems =& $this->criteriaElements;
			$conds =& $this->conditions;
            $ret = '('. $elems[0]->render();
            for ($i = 1; $i < $count; $i++) {
                $ret .= ' '.$conds[$i].' '.$elems[$i]->render();
            }
            $ret .= ')';
        }
        return $ret;
    }

    /**
     * Make the criteria into a SQL "WHERE" clause
     *
     * @return  string
     * @deprecated
     */
    function renderWhere()
    {
        $ret = $this->render();
        $ret = ($ret != '') ? 'WHERE ' . $ret : $ret;
        return $ret;
    }

    /**
     * Generate an LDAP filter from criteria
     *
     * @return string
     * @author Nathan Dial ndial@trillion21.com
     * @deprecated
     */
    function renderLdap(){
        $retval = '';
        $count = count($this->criteriaElements);
        if ($count > 0) {
            $retval = $this->criteriaElements[0]->renderLdap();
            for ($i = 1; $i < $count; $i++) {
                $cond = $this->conditions[$i];
                if(strtoupper($cond) == 'AND'){
                    $op = '&';
                } elseif (strtoupper($cond)=='OR'){
                    $op = '|';
                }
                $retval = "($op$retval" . $this->criteriaElements[$i]->renderLdap().")";
            }
        }
        return $retval;
    }
}
