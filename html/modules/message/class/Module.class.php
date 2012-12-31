<?php
/**
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 3
 * @author Marijuana
 */
use XCore\Kernel\Root;

if (!defined('XOOPS_ROOT_PATH')) exit();
class Message_Module extends Xcore_ModuleAdapter
{
  public function __construct(&$xoopsModule)
  {
    parent::Xcore_ModuleAdapter($xoopsModule);
  }
  
  public function hasAdminIndex()
  {
    return true;
  }
  
  public function getAdminIndex()
  {
    //return XOOPS_MODULE_URL.'/'.$this->mKarimojiModule->get('dirname').'/admin/index.php';
    $root = Root::getSingleton();
    return $root->mController->getPreferenceEditUrl($this->mKarimojiModule);
  }
  
  public function getAdminMenu()
  {
    if ($this->_mAdminMenuLoadedFlag) {
      return $this->mAdminMenu;
    }
    $root = Root::getSingleton();
    $this->mAdminMenu[] = array(
      'link' => $root->mController->getPreferenceEditUrl($this->mKarimojiModule),
      'title' => _PREFERENCES,
      'show' => true
    );
    $this->_mAdminMenuLoadedFlag = true;
    return $this->mAdminMenu;
  }
}
?>