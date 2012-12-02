<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:	 function
 * Name:	 xcore_tag_select
 * Version:  1.0
 * Date:	 Dec 14, 2010
 * Author:	 HIKAWA Kilica
 * Purpose:  get tag cloud html source from tag list
 * Input:	 string	tDirname(*): tag module's dirname
 *			 string	dirname: filter data by this dirname
 *			 string	dataname: filter data by this dataname
 *			 string[]	tags: selected tag name list
 *			 int[]	uidList: filter data by user in this array
 *			 int	max: maximum font size in the cloud (%)
 *			 int	min: minimum font size in the cloud (%)
 *			 string	template:	template name
 * Examples: {xcore_tag_select tDirname=tag dirname=news tags=$tags}
 * -------------------------------------------------------------
 */
use XCore\Kernel\Root;
use XCore\Kernel\Ref;
use XCore\Kernel\DelegateUtils;
use XCore\Kernel\RenderTarget;

function smarty_function_xcore_tag_select($params, &$smarty)
{
	$tDirname = $params['tDirname'];
	$dirname = isset($params['dirname']) ? $params['dirname'] : null;
	$dataname = isset($params['dataname']) ? $params['dataname'] : null;
	$uidList = isset($params['uidList']) ? $params['uidList'] : null;
	$tags = isset($params['tags']) ? $params['tags'] : null;	//selected tags
	$template = isset($params['template']) ? $params['template'] : 'xcore_inc_tag_select.html';
	$cloud = array();

	DelegateUtils::call('Xcore_Tag.'.$tDirname.'.GetTagCloudSrc',
		new Ref($cloud),
		$tDirname,
		$dirname,
		$dataname,
		$uidList
	);

	//render template
	$render = new RenderTarget();
	$render->setTemplateName($template);
	$render->setAttribute('xcore_buffertype',XCUBE_RENDER_TARGET_TYPE_MAIN);
	$render->setAttribute('cloud', $cloud);
	$render->setAttribute('tags', $tags);
	Root::getSingleton()->getRenderSystem('Xcore_RenderSystem')->render($render);

	echo $render->getResult();
}

