<?php

/**
 * @public
 * @brief [Abstract] Used for initialization, post-processing and others by the controller.
 * 
 *    This class is chained and called by the initialization procedure of the
 *    controller class. Developers or users can use the subclass of this class for
 *    dynamic customizing.
 * 
 *    Users usually don't need to add on filters because each controllers should
 *    have initialization code enough. This class is used to the case of special
 *    customizing by modules and users.
 * 
 *    Each controllers should not use this class to their initialization procedure.
 * 
 *    Two member functions are called by the controller at the special timing.
 *    These timing is different in each controllers.
 *
 * \par Abstract Class
 *    This class is an abstract class.
 */
use XCore\Kernel\Root;
use XCore\Kernel\Controller;

class XCube_ActionFilter
{
	/**
	 * @protected
	 * @readonly
	 * @var Controller
	 */
	var $mController;
	
	/**
	 * @protected
	 * @brief [READ ONLY] XCube_Root
	 */
	var $mRoot;
	
	/**
	 * @public
	 * @brief Constructor.
	 * @param $controller Controller
	 */
	function __construct(&$controller)
	{
		$this->mController =& $controller;
		$this->mRoot =& $this->mController->mRoot;
	}

	/**
	 * @public
	 * @brief [Abstract] Executes the logic, when the controller executes preFilter().
	 * @remarks
	 *     This method is called earliest in the controller's initialization process, so 
	 *     some of filters may not be called if these filters are registered later.
	 */	
	function preFilter()
	{
	}
	
	/**
	 * @public
	 * @brief [Abstract] Executes the logic, when the controller executes preBlockFilter().
	 * @remarks
	 *      Each controller has different timing when it calls preBlockFilter().
	 */	
	function preBlockFilter()
	{
	}
	
	/**
	 * @public
	 * @brief [Abstract] Executes the logic, when the controller executes postFilter().
	 * @remarks
	 *      Each controller has different timing when it calls postFilter().
	 */	
	function postFilter()
	{
	}
}
