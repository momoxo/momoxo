<?php
/**
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 3
 * @author Marijuana
 */
use XCore\Kernel\Root;
use XCore\Utils\Utils;
use XCore\Entity\Module;

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH.'/modules/xcore/admin/class/ModuleUpdater.class.php';

class Message_myUpdater extends Xcore_ModulePhasedUpgrader
{
  function __construct()
  {
    parent::__construct();
    $this->_mMilestone = array(
      '041' => 'update041',
      '060' => 'update060',
      '070' => 'update070'
    );
  }
  
  function updatemain()
  {
    Xcore_ModuleInstallUtils::clearAllOfModuleTemplatesForUpdate($this->_mTargetModule, $this->mLog);
    Xcore_ModuleInstallUtils::installAllOfModuleTemplates($this->_mTargetModule, $this->mLog);
    
    $this->saveModule($this->_mTargetModule);
    $this->mLog->add('Version'.($this->_mTargetVersion / 100).' for update.');
    $this->_mCurrentVersion = $this->_mTargetVersion;
  }
  
  function update070()
  {
    $this->mLog->addReport(_AD_XCORE_MESSAGE_UPDATE_STARTED);
    $root = Root::getSingleton();
    $db = $root->mController->getDB();
    
    $sql = "ALTER TABLE `".$db->prefix('message_inbox')."` ";
    $sql.= "ADD `uname` varchar(100) NOT NULL default ''";
    if (!$db->query($sql)) {
      $this->mLog->addReport($db->error());
    }
    
    $this->updatemain();
    return true;
  }
  
  function update060()
  {
    $this->mLog->addReport(_AD_XCORE_MESSAGE_UPDATE_STARTED);
    $root = Root::getSingleton();
    $db = $root->mController->getDB();
    
    $sql = "ALTER TABLE `".$db->prefix('message_users')."` ";
    $sql.= "ADD `viewmsm` int( 1 ) UNSIGNED NOT NULL DEFAULT '0', ";
    $sql.= "ADD `pagenum` int( 2 ) UNSIGNED NOT NULL DEFAULT '0', ";
    $sql.= "ADD `blacklist` VARCHAR( 255 ) NOT NULL DEFAULT ''";
    if (!$db->query($sql)) {
      $this->mLog->addReport($db->error());
    }
    
    $this->updatemain();
    return true;
  }
  
  function update041()
  {
    $this->mLog->addReport(_AD_XCORE_MESSAGE_UPDATE_STARTED);
    
    //Add Table
    $sqlfileInfo = $this->_mTargetModule->getInfo('sqlfile');
    $dirname = $this->_mTargetModule->getVar('dirname');
    $sqlfile = $sqlfileInfo[XOOPS_DB_TYPE];
    $sqlfilepath = XOOPS_MODULE_PATH.'/'.$dirname.'/'.$sqlfile;
    require_once XOOPS_MODULE_PATH.'/xcore/admin/class/Xcore_SQLScanner.class.php';
    $scanner = new Xcore_SQLScanner();
    $scanner->setDB_PREFIX(XOOPS_DB_PREFIX);
    $scanner->setDirname($this->_mTargetModule->get('dirname'));
    if (!$scanner->loadFile($sqlfilepath)) {
      $this->mLog->addError(Utils::formatMessage(_AD_XCORE_ERROR_SQL_FILE_NOT_FOUND, $sqlfile));
      return false;
    }
  
    $scanner->parse();
    $sqls = $scanner->getSQL();
    $root = Root::getSingleton();
    $db = $root->mController->getDB();
  
    foreach ($sqls as $sql) {
      if ( strpos($sql, '_message_users') !== false ) {
        if (!$db->query($sql)) {
          $this->mLog->addError($db->error());
          return false;
        }
      }
    }
    $this->mLog->addReport(_AD_XCORE_MESSAGE_DATABASE_SETUP_FINISHED);
    //add table
    
    $this->updatemain();
    return true;
  }
}
?>
