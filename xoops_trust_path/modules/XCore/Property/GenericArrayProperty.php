<?php

namespace XCore\Property;

use XCore\Property\PropertyInterface;
use XCore\Property\AbstractProperty;

/**
 * Defines common array property class which implements PropertyInterface.
 * 
 * This class is a kind of template-class --- GenericArrayProperty<T>.
 * Developers should know about sub-classes of AbstractProperty.
 */
abstract class GenericArrayProperty extends PropertyInterface
{
	/**
	 * @var string
	 */
	protected $mName = null;

	/**
	 * @var AbstractProperty[]
     * @todo 直接参照しているクライアントコードを直して protected にする
	 */
	public $mProperties = array();
	
	/**
	 * @var string
	 */
    protected $mPropertyClassName = null;
	
	/**
	 * Constructor.
	 * @param string $classname
	 * @param string $name A name of the property.
	 */
	public function __construct($classname, $name)
	{
		$this->mPropertyClassName = $classname;
		$this->mName = $name;
	}
	
	/**
	 * Sets a value. And the value is casted by the property's type'.
	 * 
	 *   This member function has two signatures.
	 * 
	 * \par set(something[] values);
	 *    Fetches values from the array.
	 * 
	 * \par set(mixed key, mixed value);
	 *    Set values with index 'key'.
	 */
	public function set($arg1, $arg2 = null)
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
	public function add($arg1, $arg2 = null)
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
	 * This member function helps set().
	 * @param string $index
	 * @param mixed $value
	 * @return void
	 */
	private function _set($index, $value)
	{
		if (!isset($this->mProperties[$index])) {
			$this->mProperties[$index] = new $this->mPropertyClassName($this->mName);
		}
		$this->mProperties[$index]->set($value);
	}
	
	/**
	 * Gets values of this property.
	 * @param mixed $index If $index is null, gets array (std::map<mixed_key, mixed_value>).
	 * @return mixed
	 */
	public function get($index = null)
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
	 * Resets all properties of this.
	 */
	protected function reset()
	{
		unset($this->mProperties);
		$this->mProperties = array();
	}
	
	/**
	 * Gets a value indicating whether this object expresses Array.
	 * @return bool
	 * 
	 * @remarks
	 *     This class is a base class for array properties, so a sub-class of this
	 *     does not override this method.
	 */
    public function isArray()
	{
		return true;
	}
	
	/**
	 * Gets a value indicating whether this object is null.
	 * @return bool
	 */
    public function isNull()
	{
		return (count($this->mProperties) == 0);
	}
	
	/**
	 * Gets a value as integer --- but, gets null always.
	 * @return int
	 */
    public function toNumber()
	{
		return null;
	}
	
	/**
	 * Gets a value as string --- but, gets 'Array' always.
	 * @return string
	 */
    public function toString()
	{
		return 'Array';
	}
	
	/**
	 * Gets a value as encoded HTML code --- but, gets 'Array' always.
	 * @return string - HTML
	 * @deprecated
	 */
    public function toHTML()
	{
		return htmlspecialchars($this->toString(), ENT_QUOTES);
	}
	
	/**
	 * Gets a value indicating whether this object has a fetch control.
	 * @return bool
	 */
    public function hasFetchControl()
	{
		return false;
	}
}
