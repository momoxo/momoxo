<?php

/***
 * @internal
 * Some XOOPS2 resources need $xoopsTpl, before Xcore_RenderSystem will be
 * prepared under XOOPS Cube regular process. For that, this action filter
 * tries to get 'Xcore_RenderSystem' as dummy.
 */
class Xcore_StartupXoopsTpl extends XCube_ActionFilter
{
	function postFilter()
	{
		$dmy =& $this->mRoot->getRenderSystem('Xcore_RenderSystem');
	}
}
