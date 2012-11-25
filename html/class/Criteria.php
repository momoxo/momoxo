<?php

/**
 * A single criteria
 *
 * @package     kernel
 * @subpackage  database
 *
 * @author      Kazumi Ono  <onokazu@xoops.org>
 * @copyright   copyright (c) 2000-2003 XOOPS.org
 */
class Criteria extends CriteriaElement
{

    /**
     * @var string
     */
    var $prefix;
    var $function;
    var $column;
    var $operator;
    var $value;
	
	var $dtype = 0;

    /**
     * Constructor
     *
     * @param   string  $column
     * @param   string  $value
     * @param   string  $operator
     **/
    function Criteria($column, $value='', $operator='=', $prefix = '', $function = '') {
        $this->prefix = $prefix;
        $this->function = $function;
        $this->column = $column;
        $this->operator = $operator;

		//
		// Recive DTYPE. This is a prolongation of criterion life operation.
		//
		if (is_array($value) && count($value)==2 && $operator!='IN' && $operator!='NOT IN')
		{
			$this->dtype = intval($value[0]);
			$this->value = $value[1];
		}
		else
		{
			$this->value = $value;
		}
    }
    
    function getName()
    {
		return $this->column;
	}
	
	function getValue()
	{
		return $this->value;
	}
	
	function getOperator()
	{
		return $this->operator;
	}

    /**
     * Make a sql condition string
     *
     * @return  string
     * @deprecated XoopsObjectGenericHandler::_makeCriteriaElement4sql()
     **/
    function render() {
        $value = $this->value;
        if (in_array(strtoupper($this->operator), array('IN', 'NOT IN'))) {
			$value = is_array($value) ? implode(',',$value) : $value;
			if(isset($value)){
				$value = '('.$value.')';
			}
			else{
				$value = '("")';
			}
        }
        else{
	        $value = "'$value'";
	    }
        $clause = (!empty($this->prefix) ? $this->prefix.'.' : '') . $this->column;
        if ( !empty($this->function) ) {
            $clause = sprintf($this->function, $clause);
        }
        $clause .= ' '.$this->operator.' '.$value;
        return $clause;
    }
	
   /**
     * Generate an LDAP filter from criteria
     *
     * @return string
     * @author Nathan Dial ndial@trillion21.com
     * @deprecated
     */
    function renderLdap(){
        $clause = "(" . $this->column . $this->operator . $this->value . ")";
        return $clause;
    }

    /**
     * Make a SQL "WHERE" clause
     *
     * @return  string
     * @deprecated
     */
    function renderWhere() {
        $cond = $this->render();
        return empty($cond) ? '' : "WHERE $cond";
    }
}
