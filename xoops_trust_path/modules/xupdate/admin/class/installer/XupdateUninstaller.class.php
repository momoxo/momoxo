<?php
/**
 * @file
 * @package xupdate
 * @version $Id$
**/

use XCore\Kernel\Root;
use XCore\Utils\Utils;

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

require_once XUPDATE_TRUST_PATH . '/admin/class/installer/XupdateInstallUtils.class.php';

/**
 * Xupdate_Uninstaller
**/
class Xupdate_Uninstaller
{
    public /*** Xcore_ModuleInstallLog ***/ $mLog = null;

    private /*** bool ***/ $_mForceMode = false;

    private /*** XoopsModule ***/ $_mKarimojiModule = null;

    /**
     * __construct
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function __construct()
    {
        $this->mLog = new Xcore_ModuleInstallLog();
    }

    /**
     * setCurrentXoopsModule
     * 
     * @param   XoopsModule  &$xoopsModule
     * 
     * @return  void
    **/
    public function setCurrentXoopsModule(/*** XoopsModule ***/ &$xoopsModule)
    {
        $this->_mKarimojiModule =& $xoopsModule;
    }

    /**
     * setForceMode
     * 
     * @param   bool  $isForceMode
     * 
     * @return  void
    **/
    public function setForceMode(/*** bool ***/ $isForceMode)
    {
        $this->_mForceMode = $isForceMode;
    }

    /**
     * _uninstallModule
     * 
     * @param   void
     * 
     * @return  void
    **/
    private function _uninstallModule()
    {
        $moduleHandler =& Xupdate_Utils::getXoopsHandler('module');
    
        if($moduleHandler->delete($this->_mKarimojiModule))
        {
            $this->mLog->addReport(_MI_XUPDATE_INSTALL_MSG_MODULE_INFORMATION_DELETED);
        }
        else
        {
            $this->mLog->addError(_MI_XUPDATE_INSTALL_ERROR_MODULE_INFORMATION_DELETED);
        }
    }

    /**
     * _uninstallTables
     * 
     * @param   void
     * 
     * @return  void
    **/
    private function _uninstallTables()
    {
        $root = Root::getSingleton();
        $db =& $root->mController->getDB();
        $dirname = $this->_mKarimojiModule->get('dirname');
    
        $tables =& $this->_mKarimojiModule->getInfo('tables');
        if(is_array($tables))
        {
            foreach($tables as $table)
            {
                $tableName = str_replace(
                    array('{prefix}','{dirname}'),
                    array(XOOPS_DB_PREFIX,$dirname),
                    $table
                );
                $sql = sprintf('drop table `%s`;',$tableName);
                
                if($db->query($sql))
                {
                    $this->mLog->addReport(
                        Utils::formatString(
                            _MI_XUPDATE_INSTALL_MSG_TABLE_DOROPPED,
                            $tableName
                        )
                    );
                }
                else
                {
                    $this->mLog->addError(
                        Utils::formatString(
                            _MI_XUPDATE_INSTALL_ERROR_TABLE_DOROPPED,
                            $tableName
                        )
                    );
                }
            }
        }
    }

    /**
     * _uninstallTemplates
     * 
     * @param   void
     * 
     * @return  void
    **/
    private function _uninstallTemplates()
    {
        Xupdate_InstallUtils::uninstallAllOfModuleTemplates($this->_mKarimojiModule,$this->mLog,false);
    }

    /**
     * _uninstallBlocks
     * 
     * @param   void
     * 
     * @return  void
    **/
    private function _uninstallBlocks()
    {
        Xupdate_InstallUtils::uninstallAllOfBlocks($this->_mKarimojiModule,$this->mLog);
    
        $tplHandler =& Xupdate_Utils::getXoopsHandler('tplfile');
        $cri = new Criteria('tpl_module',$this->_mKarimojiModule->get('dirname'));
        if(!$tplHandler->deleteAll($cri))
        {
            $this->mLog->addError(
                Utils::formatString(
                    _MI_XUPDATE_INSTALL_ERROR_BLOCK_TPL_DELETED,
                    $tplHandler->db->error()
                )
            );
        }
    }

    /**
     * _uninstallPreferences
     * 
     * @param   void
     * 
     * @return  void
    **/
    private function _uninstallPreferences()
    {
        Xupdate_InstallUtils::uninstallAllOfConfigs($this->_mKarimojiModule,$this->mLog);
    }

    /**
     * _processReport
     * 
     * @param   void
     * 
     * @return  void
    **/
    private function _processReport()
    {
        if(!$this->mLog->hasError())
        {
            $this->mLog->add(
                Utils::formatString(
                    _MI_XUPDATE_INSTALL_MSG_MODULE_UNINSTALLED,
                    $this->_mKarimojiModule->get('name')
                )
            );
        }
        else if(is_object($this->_mKarimojiModule))
        {
            $this->mLog->addError(
                Utils::formatString(
                    _MI_XUPDATE_INSTALL_ERROR_MODULE_UNINSTALLED,
                    $this->_mKarimojiModule->get('name')
                )
            );
        }
        else
        {
            $this->mLog->addError(
                Utils::formatString(
                    _MI_XUPDATE_INSTALL_ERROR_MODULE_UNINSTALLED,
                    'something'
                )
            );
        }
    }

    /**
     * executeUninstall
     * 
     * @param   void
     * 
     * @return  bool
    **/
    public function executeUninstall()
    {
        $this->_uninstallTables();
        if(!$this->_mForceMode && $this->mLog->hasError())
        {
            $this->_processReport();
            return false;
        }
    
        if($this->_mKarimojiModule->get('mid') != null)
        {
            $this->_uninstallModule();
            if(!$this->_mForceMode && $this->mLog->hasError())
            {
                $this->_processReport();
                return false;
            }
    
            $this->_uninstallTemplates();
            if(!$this->_mForceMode && $this->mLog->hasError())
            {
                $this->_processReport();
                return false;
            }
    
            $this->_uninstallBlocks();
            if(!$this->_mForceMode && $this->mLog->hasError())
            {
                $this->_processReport();
                return false;
            }
    
            $this->_uninstallPreferences();
            if(!$this->_mForceMode && $this->mLog->hasError())
            {
                $this->_processReport();
                return false;
            }
        }
    
        $this->_processReport();
        return true;
    }
}

?>
