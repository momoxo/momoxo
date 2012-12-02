<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:	 function
 * Name:	 xcore_profile
 * Version:  1.0
 * Date:	 Feb 01, 2011
 * Author:	 HIKAWA Kilica
 * Purpose:  Profile data show
 * Input:	 User_EditUserForm	actionForm
 * 			 int	uid: user id
 *			 string	action: 'view', 'edit', etc
 *			 string	template:	template name
 * Examples: {xcore_profile uid=3 action=edit actionForm=$actionForm}
 * -------------------------------------------------------------
 */
use XCore\Kernel\Root;
use XCore\Kernel\Ref;
use XCore\Kernel\DelegateUtils;
use XCore\Kernel\RenderTarget;

function smarty_function_xcore_profile($params, &$smarty)
{
	$uid = isset($params['uid']) ? intval($params['uid']) : Xcore_Utils::getUid();
	if($uid===0){
		return;
	}
	$profileActionForm = isset($params['actionForm']) ? $params['actionForm'] : null;
	$action = isset($params['action']) ? $params['action'] : 'view';
	$template = isset($params['template']) ? $params['template'] : 'profile_inc_data_view.html';

	$defArr = null;
	DelegateUtils::call(
		'Xcore_Profile.GetDefinition',
		new Ref($defArr),
		$action
	);

	$profile = null;
	DelegateUtils::call(
		'Xcore_Profile.GetProfile',
		new Ref($profile),
		$uid
	);

	//render template
	$render = new RenderTarget();
	$render->setTemplateName($template);
	$render->setAttribute('xcore_buffertype',XCUBE_RENDER_TARGET_TYPE_MAIN);
	$render->setAttribute('profileForm', $profileActionForm);
	$render->setAttribute('profile', $profile);
	$render->setAttribute('defArr', $defArr);
	Root::getSingleton()->getRenderSystem('Xcore_RenderSystem')->render($render);

	echo $render->getResult();
}

