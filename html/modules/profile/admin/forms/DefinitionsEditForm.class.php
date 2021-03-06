<?php

use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\BoolProperty;
use XCore\Property\IntProperty;
use XCore\Property\StringProperty;
use XCore\Property\TextProperty;

class Profile_Admin_DefinitionsEditForm extends ActionForm
{
	/**
	 * @public
	 */
	function getTokenName()
	{
		return "module.profile.Admin_DefinitionsEditForm.TOKEN";
	}

	/**
	 * @public
	 */
	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['field_id'] =new IntProperty('field_id');
		$this->mFormProperties['field_name'] =new StringProperty('field_name');
		$this->mFormProperties['label'] =new StringProperty('label');
		$this->mFormProperties['type'] =new StringProperty('type');
		$this->mFormProperties['validation'] =new StringProperty('validation');
		$this->mFormProperties['required'] =new BoolProperty('required');
		$this->mFormProperties['show_form'] =new BoolProperty('show_form');
		$this->mFormProperties['weight'] =new IntProperty('weight');
		$this->mFormProperties['description'] =new TextProperty('description');
		$this->mFormProperties['access'] =new TextProperty('access');
		$this->mFormProperties['options'] =new TextProperty('options');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['field_id'] =new FieldProperty($this);
		$this->mFieldProperties['field_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['field_id']->addMessage('required', _MD_PROFILE_ERROR_REQUIRED, _MD_PROFILE_LANG_FIELD_ID);
	
		$this->mFieldProperties['field_name'] =new FieldProperty($this);
		$this->mFieldProperties['field_name']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['field_name']->addMessage('required', _MD_PROFILE_ERROR_REQUIRED, _MD_PROFILE_LANG_FIELD_NAME, '32');
		$this->mFieldProperties['field_name']->addMessage('maxlength', _MD_PROFILE_ERROR_MAXLENGTH, _MD_PROFILE_LANG_FIELD_NAME, '32');
		$this->mFieldProperties['field_name']->addVar('maxlength', '32');
	
		$this->mFieldProperties['label'] =new FieldProperty($this);
		$this->mFieldProperties['label']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['label']->addMessage('required', _MD_PROFILE_ERROR_REQUIRED, _MD_PROFILE_LANG_LABEL, '255');
		$this->mFieldProperties['label']->addMessage('maxlength', _MD_PROFILE_ERROR_MAXLENGTH, _MD_PROFILE_LANG_LABEL, '255');
		$this->mFieldProperties['label']->addVar('maxlength', '255');
	
		$this->mFieldProperties['type'] =new FieldProperty($this);
		$this->mFieldProperties['type']->setDependsByArray(array('maxlength'));
//		$this->mFieldProperties['type']->addMessage('required', _MD_PROFILE_ERROR_REQUIRED, _MD_PROFILE_LANG_TYPE, '16');
		$this->mFieldProperties['type']->addMessage('maxlength', _MD_PROFILE_ERROR_MAXLENGTH, _MD_PROFILE_LANG_TYPE, '32');
		$this->mFieldProperties['type']->addVar('maxlength', '32');
	
		$this->mFieldProperties['validation'] =new FieldProperty($this);
		$this->mFieldProperties['validation']->setDependsByArray(array('maxlength'));
		$this->mFieldProperties['validation']->addMessage('maxlength', _MD_PROFILE_ERROR_MAXLENGTH, _MD_PROFILE_LANG_VALIDATION, '255');
		$this->mFieldProperties['validation']->addVar('maxlength', '255');
	
		$this->mFieldProperties['weight'] =new FieldProperty($this);
		$this->mFieldProperties['weight']->setDependsByArray(array('required'));
		$this->mFieldProperties['weight']->addMessage('required', _MD_PROFILE_ERROR_REQUIRED, _MD_PROFILE_LANG_WEIGHT);
	}

	/**
	 * @public
	 */
	function load(&$obj)
	{
		$this->set('field_id', $obj->get('field_id'));
		$this->set('field_name', $obj->get('field_name'));
		$this->set('label', $obj->get('label'));
		$this->set('type', $obj->get('type'));
		$this->set('validation', $obj->get('validation'));
		$this->set('required', $obj->get('required'));
		$this->set('show_form', $obj->get('show_form'));
		$this->set('weight', $obj->get('weight'));
		$this->set('description', $obj->get('description'));
		$this->set('access', explode(",", $obj->get('access')));
		$this->set('options', $obj->get('options'));
	}

	/**
	 * @public
	 */
	function update(&$obj)
	{
		$obj->set('field_id', $this->get('field_id'));
		$obj->set('field_name', $this->get('field_name'));
		$obj->set('label', $this->get('label'));
		$obj->set('type', $this->get('type'));
		$obj->set('validation', $this->get('validation'));
		$obj->set('required', $this->get('required'));
		$obj->set('show_form', $this->get('show_form'));
		$obj->set('weight', $this->get('weight'));
		$obj->set('description', $this->get('description'));
		if($this->get('access')){
			$obj->set('access', implode(",", $this->get('access')));
		}
		$obj->set('options', $this->get('options'));
	}

    /**
     * validateField_name
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function validateField_name(){
    	if($this->get('field_id')>0){
    		return;
    	}
        $objs = xoops_getmodulehandler('definitions', 'profile')->getObjects(new Criteria('field_name', $this->get('field_name')));
        if(count($objs)>0){
            $this->addErrorMessage(_MD_PROFILE_ERROR_DUPLICATED_FIELD_NAME);
        }
    }

}

?>
