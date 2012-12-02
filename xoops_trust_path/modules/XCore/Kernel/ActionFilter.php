<?php

namespace XCore\Kernel;

use XCore\Kernel\Root;
use XCore\Kernel\Controller;

/**
 * Used for initialization, post-processing and others by the controller.
 *
 * This class is chained and called by the initialization procedure of the
 * controller class. Developers or users can use the subclass of this class for
 * dynamic customizing.
 *
 * Users usually don't need to add on filters because each controllers should
 * have initialization code enough. This class is used to the case of special
 * customizing by modules and users.
 *
 * Each controllers should not use this class to their initialization procedure.
 *
 * Two member functions are called by the controller at the special timing.
 * These timing is different in each controllers.
 *
 * This class is an abstract class.
 */
abstract class ActionFilter
{
	/**
	 * @var Controller
	 * @readonly
	 */
	protected $mController;

	/**
	 * @var Root
	 * @readonly
	 */
	protected $mRoot;

	/**
	 * Constructor.
	 * @param Controller $controller
	 */
	public function __construct(&$controller)
	{
		$this->mController =& $controller;
		$this->mRoot =& $this->mController->mRoot;
	}

	/**
	 * Executes the logic, when the controller executes preFilter().
	 *
	 * This method is called earliest in the controller's initialization process, so
	 * some of filters may not be called if these filters are registered later.
	 */
	public function preFilter()
	{
		// template method
	}

	/**
	 * Executes the logic, when the controller executes preBlockFilter().
	 *
	 * Each controller has different timing when it calls preBlockFilter().
	 */
	public function preBlockFilter()
	{
		// template method
	}

	/**
	 * Executes the logic, when the controller executes postFilter().
	 *
	 * Each controller has different timing when it calls postFilter().
	 */
	public function postFilter()
	{
		// template method
	}
}
