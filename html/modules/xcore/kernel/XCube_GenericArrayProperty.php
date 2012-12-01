<?php

/**
 * @public
 * @brief [Abstract] Defines common array property class which implements XCube_PropertyInterface.
 * 
 * This class is a kind of template-class --- XCube_GenericArrayProperty<T>.
 * Developers should know about sub-classes of XCube_AbstractProperty.
 */
class XCube_GenericArrayProperty extends XCube_PropertyInterface
{
	/**
	 * @protected
	 * @brief string
	 */
	var $mName = null;

	/**
	 * @protected
	 * @brief XCube_AbstractProperty[] - std::map<mixed_key, mixed_value>
	 */
	var $mProperties = array();
	
	/**
	 * @protected
	 * @brief string - <T>
	 * 
	 * If this class is XCube_GenericArrayProperty<T>, mPropertyClassName is <T>.
	 */
	var $mPropertyClassName = null;
	
	/**
	 * @public
	 * @brief Constructor.
	 * @param $classname string - <T>
	 * @param $name string - A name of the property.
	 */
	function __construct($classname, $name)
	{
		$this->mPropertyClassName = $classname;
		$this->mName = $name;
	}
	
	/**
	 * @public
	 * @brief Sets a value. And the value is casted by the property's type'.
	 * 
	 *   This member function has two signatures.
	 * 
	 * \par set(something[] values);
	 *    Fetches values from the array.
	 * 
	 * \par set(mixed key, mixed value);
	 *    Set values with index 'key'.
	 */
	function set($arg1, $arg2 = null)
	{
		if (is_array($arg1) && $arg2 == null) {
			$this->reset();
			foreach ($arg1 as $t_key => $t_value) {
				$this->_set($t_key, $t_value);
			}
		}
		elseif($arg1===null && $arg2===null){	//ex) all checkbox options are off
			$this->reset();
		}
		elseif ($arg1 !== null && $arg2 !== null) {
			$this->_set($arg1, $arg2);
		}
	}
	
	/**
	 * @internal
	 * @todo Research this method.
	 */
	function add($arg1, $arg2 = null)
	{
		if (is_array($arg1) && $arg2 == null) {
			foreach ($arg1 as $t_key => $t_value) {
				$this->_set($t_key, $t_value);
			}
		}
		elseif ($arg1 !== null && $arg2 !== null) {
			$this->_set($arg1, $arg2);
		}
	}
	
	/**
	 * @private
	 * @brief This member function helps set().
	 * @param string $index
	 * @param mixed $value
	 * @return void
	 */
	function _set($index, $value)
	{
		if (!isset($this->mProperties[$index])) {
			$this->mProperties[$index] = new $this->mPropertyClassName($this->mName);
		}
		$this->mProperties[$index]->set($value);
	}
	
	/**
	 * @public
	 * @brief Gets values of this property.
	 * @param $index mixed - If $indes is null, gets array (std::map<mixed_key, mixed_value>).
	 * @return mixed
	 */
	function get($index = null)
	{
		if ($index === null) {
			$ret = array();
			
			foreach ($this->mProperties as $t_key => $t_value) {
				$ret[$t_key] = $t_value->get();
			}
			
			return $ret;
		}
		
		return isset($this->mProperties[$index]) ? $this->mProperties[$index]->get() : null;
	}
	
	/**
	 * @protected
	 * @brief Resets all properties of this.
	 */
	function reset()
	{
		unset($this->mProperties);
		$this->mProperties = array();
	}
	
	/**
	 * @public
	 * @brief Gets a value indicating whether this object expresses Array.
	 * @return bool
	 * 
	 * @remarks
	 *     This class is a base class for array properties, so a sub-class of this
	 *     does not override this method.
	 */
	function isArray()
	{
		return true;
	}
	
	/**
	 * @public
	 * @brief Gets a value indicating whether this object is null.
	 * @return bool
	 */
	function isNull()
	{
		return (count($this->mProperties) == 0);
	}
	
	/**
	 * @public
	 * @brief Gets a value as integer --- but, gets null always.
	 * @return int
	 */
	function toNumber()
	{
		return null;
	}
	
	/**
	 * @public
	 * @brief Gets a value as string --- but, gets 'Array' always.
	 * @return string
	 */
	function toString()
	{
		return 'Array';
	}
	
	/**
	 * @public
	 * @brief Gets a value as encoded HTML code --- but, gets 'Array' always.
	 * @return string - HTML
	 * @deprecated
	 */	
	function toHTML()
	{
		return htmlspecialchars($this->toString(), ENT_QUOTES);
	}
	
	/**
	 * @public
	 * @brief Gets a value indicating whether this object has a fetch control.
	 * @return bool
	 */
	function hasFetchControl()
	{
		return false;
	}
}
