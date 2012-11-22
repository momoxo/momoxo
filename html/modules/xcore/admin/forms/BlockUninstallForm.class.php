<?php

class Xcore_BlockUninstallForm extends Xcore_CustomBlockDeleteForm
{
	function getTokenName()
	{
		return "module.xcore.BlockUninstallForm.TOKEN" . $this->get('bid');
	}

	function update(&$obj)
	{
		parent::update($obj);
		$obj->set('last_modified', time());
		$obj->set('visible', false);
	}
}

