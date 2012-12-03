<?php

use XCore\Kernel\Root;
use XCore\Form\ActionForm;

class MessageSettingsForm extends ActionForm
{
  public function __construct()
  {
	  parent::__construct();
  }
  
  public function getTokenName()
  {
    return 'module.message.Settings.TOKEN';
  }
  
  public function prepare()
  {
    $this->mFormProperties['usepm'] = new XCube_BoolProperty('usepm');
    $this->mFormProperties['tomail'] = new XCube_BoolProperty('tomail');
    $this->mFormProperties['viewmsm'] = new XCube_BoolProperty('viewmsm');
    $this->mFormProperties['pagenum'] = new XCube_IntProperty('pagenum');
    $this->mFormProperties['blacklist'] = new XCube_StringProperty('blacklist');
  }
  
  public function fetchBlacklist()
  {
    $blacklist = $this->get('blacklist');
    if ( $blacklist == "" ) {
      return;
    } elseif( strpos($blacklist, ',') !== false )  {
      $lists = explode(',', $blacklist);
      $lists = array_map('intval', $lists);
      $lists = array_unique($lists);
      $this->set('blacklist', implode(',', $lists));
    } else {
      $this->set('blacklist', intval($blacklist));
    }
  }
  
  public function update(&$obj)
  {
    $root = Root::getSingleton();
    $obj->set('uid', $root->mContext->mXoopsUser->get('uid'));
    $obj->set('usepm', $this->get('usepm'));
    $obj->set('tomail', $this->get('tomail'));
    $obj->set('viewmsm', $this->get('viewmsm'));
    $obj->set('pagenum', $this->get('pagenum'));
    $obj->set('blacklist', $this->get('blacklist'));
  }
  
  public function load(&$obj)
  {
    $this->set('usepm', $obj->get('usepm'));
    $this->set('tomail', $obj->get('tomail'));
    $this->set('viewmsm', $obj->get('viewmsm'));
    $this->set('pagenum', $obj->get('pagenum'));
    $this->set('blacklist', $obj->get('blacklist'));
  }
}
?>
