<?php

use XCore\Kernel\Root;

class Xcore_HtaccessViewAction extends Xcore_Action
{
	public function getDefaultView(&$controller, &$xoopsUser)
	{
		return XCORE_FRAME_VIEW_SUCCESS;
	}

	public function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		Root::getSingleton()->mLanguageManager->loadGlobalMessageCatalog();
	
		$render->setAttribute('xoops_module_path', XOOPS_MODULE_PATH);
		$render->setAttribute('data_name', _REQUESTED_DATA_NAME);
		$render->setAttribute('action_name', _REQUESTED_ACTION_NAME);
		$render->setAttribute('data_id', _REQUESTED_DATA_ID);
		$render->setTemplateName("htaccess_view.html");
	}
}

