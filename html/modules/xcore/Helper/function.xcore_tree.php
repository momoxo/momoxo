<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:	 function
 * Name:	 xcore_tree
 * Version:  1.2
 * Date:	 Mar 28, 2008 / Feb 19, 2010
 * Author:	 HIKAWA Kilica
 * Purpose:  format category tree object
 * Input:	 tree=Xcore_AbstractCategoryObject object[]
 *			 control=bool	:display control(edit,delete,add child) or not
 *			 dirname=string
 *			 className=string
 * Examples: {xcore_tree tree=$cattree control=false dirname=$dirname className=xcore_tree}
 * -------------------------------------------------------------
 */
 
use XCore\Kernel\Root;
use XCore\Kernel\RenderTarget;

function smarty_function_xcore_tree($params, &$smarty)
{
	$tree = $params['tree'];
	$control = $params['control'];
	$dirname = $params['dirname'];
	$className = $params['className'] ? $params['className'] : 'tree';
	$template = isset($params['template']) ? $params['template'] : 'xcore_inc_tree.html';

	//render template
	$render = new RenderTarget();
	$render->setTemplateName($template);
	$render->setAttribute('xcore_buffertype',XCUBE_RENDER_TARGET_TYPE_MAIN);
	$render->setAttribute('tree', $tree);
	$render->setAttribute('dirname', $dirname);
	$render->setAttribute('className', $className);
	Root::getSingleton()->getRenderSystem('Xcore_RenderSystem')->render($render);

	echo $render->getResult();
}
