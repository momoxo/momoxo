<?php

use XCore\Kernel\Root;
use XCore\Form\ActionForm;

class Xcore_NotifyDeleteForm extends ActionForm
{
	var $mNotifiyIds = array();
	var $mFatalError = false;
	
	function getTokenName()
	{
		return $_SERVER['REQUEST_METHOD'] == 'POST' ? "module.xcore.NotifyDeleteForm.TOKEN" : null;
	}

	function fetch()
	{
		parent::fetch();
		
		$root = Root::getSingleton();
		$t_arr = $root->mContext->mRequest->getRequest('del_not');
		
		if (!is_array($t_arr)) {
			$this->addErrorMessage(_MD_XCORE_LANG_ERROR);
			$this->mFatalError = true;
			return;
		}
		
		foreach ($t_arr as $t_modid => $t_idArr) {
			if (!is_array($t_idArr)) {
				$this->addErrorMessage(_MD_XCORE_LANG_ERROR);
				$this->mFatalError = true;
				return;
			}
			foreach ($t_idArr as $t_id) {
				$this->mNotifiyIds[] = array('modid' => intval($t_modid), 'id' => intval($t_id));
			}
		}
	}
}

