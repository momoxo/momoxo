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
	XCube_DelegateUtils::call(
		'Xcore_Profile.GetDefinition',
		new XCube_Ref($defArr),
		$action
	);

	$profile = null;
	XCube_DelegateUtils::call(
		'Xcore_Profile.GetProfile',
		new XCube_Ref($profile),
		$uid
	);

	//render template
	$render = new XCube_RenderTarget();
	$render->setTemplateName($template);
	$render->setAttribute('xcore_buffertype',XCUBE_RENDER_TARGET_TYPE_MAIN);
	$render->setAttribute('profileForm', $profileActionForm);
	$render->setAttribute('profile', $profile);
	$render->setAttribute('defArr', $defArr);
	XCube_Root::getSingleton()->getRenderSystem('Xcore_RenderSystem')->render($render);

	echo $render->getResult();
}

