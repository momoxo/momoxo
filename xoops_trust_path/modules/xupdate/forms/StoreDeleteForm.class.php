<?php

/**
 * Xupdate_StoreDeleteForm
**/
use XCore\Form\ActionForm;
use XCore\Form\FieldProperty;
use XCore\Property\IntProperty;
use XCore\Entity\SimpleObject;

class Xupdate_StoreDeleteForm extends ActionForm
{
    /**
     * getTokenName
     * 
     * @param   void
     * 
     * @return  string
    **/
    public function getTokenName()
    {
        return "module.xupdate.StoreDeleteForm.TOKEN";
    }

    /**
     * prepare
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function prepare()
    {
        //
        // Set form properties
        //
        $this->mFormProperties['sid'] = new IntProperty('sid');
    
        //
        // Set field properties
        //
        $this->mFieldProperties['sid'] = new FieldProperty($this);
        $this->mFieldProperties['sid']->setDependsByArray(array('required'));
        $this->mFieldProperties['sid']->addMessage('required', _MD_XUPDATE_ERROR_REQUIRED, _MD_XUPDATE_LANG_SID);
    }

    /**
     * load
     * 
     * @param   SimpleObject  &$obj
     * 
     * @return  void
    **/
    public function load(/*** SimpleObject ***/ &$obj)
    {
        $this->set('sid', $obj->get('sid'));
    }

    /**
     * update
     * 
     * @param   SimpleObject  &$obj
     * 
     * @return  void
    **/
    public function update(/*** SimpleObject ***/ &$obj)
    {
        $obj->set('sid', $this->get('sid'));
    }
}

?>
