<?php

namespace XCore\Kernel;

use XCore\Kernel\Controller;
use XCube_RenderTarget;

/**
 * This system is in charge of rendering and contents cache management.
 * For cache management, this system must talk with a business logic before business logic executes.
 * This class has a bad design so that the template engine is strongly tied to cache management.
 * We must divide this class into renderer and cache management.
 */
class RenderSystem
{
	/**
	 * @private
	 * @var Controller
	 * @todo 他のクラスからの参照を取り除いてprivateにする
	 */
	public $mController;

	/**
	 * @var int
	 */
	public $mRenderMode = XCUBE_RENDER_MODE_NORMAL;

	/**
	 * Return new RenderSysatem instance
	 */
	public function __construct()
	{
	}

	/**
	 * Prepare.
	 * @param Controller $controller
	 * @return void
	 */
	public function prepare(&$controller)
	{
		$this->mController =& $controller;
	}

	/**
	 * Create an object of the render-target, and return it.
	 * @return XCube_RenderTarget
	 */
	public function &createRenderTarget()
	{
		$renderTarget = new XCube_RenderTarget();
		return $renderTarget;
	}

	/**
	 * Render to $target.
	 * @param XCube_RenderTarget $target
	 * @return void
	 */
	public function render(&$target)
	{
	}
}
