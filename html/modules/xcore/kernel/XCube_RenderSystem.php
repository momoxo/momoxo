<?php

/**
 * This system is in charge of rendering and contents cache management.
 * For cache management, this system must talk with a business logic before business logic executes.
 * This class has a bad design so that the template engine is strongly tied to cache management.
 * We must divide this class into renderer and cache management.
 */
class XCube_RenderSystem
{
	/**
	 @access private
	 */
	var $mController;

	var $mRenderMode = XCUBE_RENDER_MODE_NORMAL;
	
	function XCube_RenderSystem()
	{
	}
	
	/**
	 * Prepare.
	 *
	 * @param XCube_Controller $controller
	 */
	function prepare(&$controller)
	{
		$this->mController =& $controller;
	}
	
	/**
	 * Create an object of the render-target, and return it.
	 *
	 * @return XCube_RenderTarget
	 */
	function &createRenderTarget()
	{
		$renderTarget = new XCube_RenderTarget();
		return $renderTarget;
	}

	/**
	 * Render to $target.
	 *
	 * @param XCube_RenderTarget $target
	 */
	function render(&$target)
	{
	}
}
