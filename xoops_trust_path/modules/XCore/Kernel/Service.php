<?php

namespace XCore\Kernel;

/**
 * This class is a collection for functions.
 */
abstract class Service
{
	/**
	 * @protected
	 * @var string
	 * @todo protectedにするために、サブクラスを修正する
	 */
	public $mServiceName = "";

	/**
	 * @protected
	 * @var string
	 * @todo protectedにするために、サブクラスを修正する
	 */
	public $mNameSpace = "";

	/**
	 * @protected
	 * @var string
	 * @todo protectedにするために、サブクラスを修正する
	 */
	public $mClassName = 'XCore\Kernel\Service';

	/**
	 * @deprecated
	 */
	protected $_mActionStrategy = null;

	/**
	 * @var string[]
	 * @todo protectedにするために、サブクラスを修正する
	 */
	public $_mTypes = array();

	/**
	 * @var array
	 * @todo protectedにするために、サブクラスを修正する
	 */
	public $_mFunctions = array();

	public function __construct()
	{
	}

	public function prepare()
	{
	}

	/**
	 * @param string $className
	 * @return void
	 */
	public function addType($className)
	{
		$this->_mTypes[] = $className;
	}

	/**
	 * @return void
	 */
	public function addFunction()
	{
		$args = func_get_args();
		$n = func_num_args();
		$arg0 = & $args[0];

		if ( $n == 3 ) {
			$this->_addFunctionStandard($arg0, $args[1], $args[2]);
		} elseif ( $n == 1 && is_array($arg0) ) {
			$this->_addFunctionStandard($arg0['name'], $arg0['in'], $arg0['out']);
		}
	}

	/**
	 * @param $name
	 * @param $in
	 * @param $out
	 */
	protected function _addFunctionStandard($name, $in, $out)
	{
		$this->_mFunctions[$name] = array(
			'out'  => $out,
			'name' => $name,
			'in'   => $in
		);
	}

	/**
	 * @param string $name
	 * @param        $procedure
	 */
	public function register($name, &$procedure)
	{
	}
}
