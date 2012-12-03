<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;

class Xcore_PreferenceEditForm extends ActionForm
{
	var $mKeyName = "confcat_id";
	var $mKeyValue = 0;
	
	function __construct(&$category)
	{
		parent::__construct();
		$this->mKeyValue = $category->get('confcat_id');
	}
	
	function getTokenName()
	{
		return "module.xcore.PreferenceEditForm.TOKEN" . $this->getCategoryId();
	}
	
	function getCategoryId()
	{
		return $this->mKeyValue;
	}

	function getModuleId()
	{
		return 0;
	}

	function prepare(&$configArr)
	{
		//
		// Set form properties
		//
		foreach ($configArr as $config) {
			switch ($config->get('conf_valuetype')) {
				case 'text':
				case 'string':
					if ($config->get('conf_formtype') == 'textarea') {
						$this->mFormProperties[$config->get('conf_name')] =new XCube_TextProperty($config->get('conf_name'));
					}
					else {
						$this->mFormProperties[$config->get('conf_name')] =new XCube_StringProperty($config->get('conf_name'));
					}
					$this->set($config->get('conf_name'), $config->get('conf_value'));
					break;

				case 'float':
					$this->mFormProperties[$config->get('conf_name')] =new XCube_FloatProperty($config->get('conf_name'));
					$this->set($config->get('conf_name'), $config->get('conf_value'));
					
					$this->mFieldProperties[$config->get('conf_name')] =new FieldProperty($this);
					$this->mFieldProperties[$config->get('conf_name')]->setDependsByArray(array('required'));
					$this->mFieldProperties[$config->get('conf_name')]->addMessage('required', _MD_XCORE_ERROR_REQUIRED, $config->get('conf_title'));
					break;

				case 'int':
					$this->mFormProperties[$config->get('conf_name')] =new XCube_IntProperty($config->get('conf_name'));
					$this->set($config->get('conf_name'), $config->get('conf_value'));
					
					$this->mFieldProperties[$config->get('conf_name')] =new FieldProperty($this);
					$this->mFieldProperties[$config->get('conf_name')]->setDependsByArray(array('required'));
					$this->mFieldProperties[$config->get('conf_name')]->addMessage('required', _MD_XCORE_ERROR_REQUIRED, $config->get('conf_title'));
					break;
					
				case 'other':
					$this->mFormProperties[$config->get('conf_name')] =new XCube_StringProperty($config->get('conf_name'));
					$this->set($config->get('conf_name'), $config->get('conf_value'));
					break;

				case 'array':
					if($config->get('conf_formtype') == 'textarea') {
						$this->mFormProperties[$config->get('conf_name')] =new XCube_StringProperty($config->get('conf_name'));
						$this->set($config->get('conf_name'), implode("|", unserialize($config->get('conf_value'))));
					}
					else {
						$this->mFormProperties[$config->get('conf_name')] =new XCube_StringArrayProperty($config->get('conf_name'));
						$t_arr = unserialize($config->get('conf_value'));
						if (is_array($t_arr)) {
							foreach ($t_arr as $_key => $_value) {
								$this->set($config->get('conf_name'), $_key, $_value);
							}
						}
					}
					break;
			}
		}
	}

	function getImploadValue($key)
	{
		$value = $this->get($key);
		return is_array($value) ? implode("|", $value) : $value;
	}
	
	function update(&$configArr)
	{
		foreach (array_keys($configArr) as $key) {
			$value = $this->get($configArr[$key]->get('conf_name'));
			
			if ($configArr[$key]->get('conf_valuetype') == 'array') {
				if (is_array($value)) {
					$configArr[$key]->set('conf_value', serialize($value));
				}
				else {
					$configArr[$key]->set('conf_value', serialize(explode("|", $value)));
				}
			}
			else {
				$configArr[$key]->set('conf_value', $value);
			}
		}
	}
}

class Xcore_ModulePreferenceEditForm extends Xcore_PreferenceEditForm
{
	var $mKeyName = "confmod_id";

	function __construct(&$module)
	{
		ActionForm::__construct();
		$this->mKeyValue = $module->get('mid');
	}
	
	function getTokenName()
	{
		return "module.xcore.ModulePreferenceEditForm.TOKEN" . $this->getModuleId();
	}
	
	function getCategoryId()
	{
		return 0;
	}

	function getModuleId()
	{
		return $this->mKeyValue;
	}
}

