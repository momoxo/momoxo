<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\IntProperty;

class Profile_DataEditForm extends ActionForm
{
	//table field definitions
	var $mDef = array();

	/**
	 * @public
	 */
	function getTokenName()
	{
		return "module.profile.DataEditForm.TOKEN";
	}

	/**
	 * @public
	 */
	function prepare()
	{
		$handler =& xoops_getmodulehandler('definitions');
		$this->mDef = $handler->getFields4DataEdit();
	
		//
		// Set form properties
		//
		$this->mFormProperties['uid'] =new IntProperty('uid');
		foreach(array_keys($this->mDef) as $key){
			$className = $this->mDef[$key]->mFieldType->getFormPropertyClass();
			$this->mFormProperties[$this->mDef[$key]->get('field_name')] =new $className($this->mDef[$key]->get('field_name'));
		
			//validation checks
			$validationArr = array();
			$this->mFieldProperties[$this->mDef[$key]->get('field_name')] =new FieldProperty($this);
			//required check
			if($this->mDef[$key]->get('required')==1){
				$validationArr[] = 'required';
				$this->mFieldProperties[$this->mDef[$key]->get('field_name')]->addMessage('required', _MD_PROFILE_ERROR_REQUIRED, $this->mDef[$key]->get('label'));
			}
			//validation check
			switch($this->mDef[$key]->get('validation')){
			case 'email' :
				$validationArr[] = 'email';
				$this->mFieldProperties[$this->mDef[$key]->get('field_name')]->addMessage($this->mDef[$key]->get('field_name'), _MD_PROFILE_ERROR_EMAIL);
			break;
			}
			$this->mFieldProperties[$this->mDef[$key]->get('field_name')]->setDependsByArray($validationArr);
		}
	
		//
		// Set field properties
		//
		$this->mFieldProperties['uid'] =new FieldProperty($this);
		$this->mFieldProperties['uid']->setDependsByArray(array('required'));
		$this->mFieldProperties['uid']->addMessage('required', _MD_PROFILE_ERROR_REQUIRED, _MD_PROFILE_LANG_UID);
	}

	/**
	 * @public
	 */
	function load(&$obj)
	{
		$this->set('uid', $obj->get('uid'));
		foreach(array_keys($this->mDef) as $key){
			$this->set($this->mDef[$key]->get('field_name'), $obj->showField($this->mDef[$key]->get('field_name'), Profile_ActionType::EDIT));
		}
	}

	/**
	 * @public
	 */
	function update(&$obj)
	{
		$obj->set('uid', $this->get('uid'));
		foreach(array_keys($this->mDef) as $key){
			$val = ($this->mDef[$key]->get('type')!='date') ? $this->get($this->mDef[$key]->get('field_name')) : $this->_makeUnixtime($this->mDef[$key]->get('field_name'));
			$obj->set($this->mDef[$key]->get('field_name'), $val);
		}
	}

	protected function _makeUnixtime($key)
	{
		$timeArray = explode('/', $this->get($key));
		return mktime(0, 0, 0, $timeArray[1], $timeArray[2], $timeArray[0]);
	}
}

?>
