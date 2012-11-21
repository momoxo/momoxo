<?php

class Xcore_BlockInstallEditForm extends Xcore_BlockEditForm
{
	function getTokenName()
	{
		return "module.xcore.BlockInstallEditForm.TOKEN" . $this->get('bid');
	}
	
	function update(&$obj)
	{
		parent::update($obj);
		$obj->set('visible', true);
	}
}

?>
