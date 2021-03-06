<?php
/**
 * @file
 * @package xupdate
 * @version $Id$
**/

use XCore\Kernel\Root;
use XCore\Kernel\Controller;
use XCore\Kernel\Ref;
use XCore\Kernel\DelegateUtils;

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

require_once XUPDATE_TRUST_PATH . '/class/AbstractAction.class.php';

define('XUPDATE_FRAME_PERFORM_SUCCESS', 1);
define('XUPDATE_FRAME_PERFORM_FAIL', 2);
define('XUPDATE_FRAME_INIT_SUCCESS', 3);

define('XUPDATE_FRAME_VIEW_NONE','none');
define('XUPDATE_FRAME_VIEW_SUCCESS','success');
define('XUPDATE_FRAME_VIEW_ERROR','error');
define('XUPDATE_FRAME_VIEW_INDEX','index');
define('XUPDATE_FRAME_VIEW_INPUT','input');
define('XUPDATE_FRAME_VIEW_PREVIEW','preview');
define('XUPDATE_FRAME_VIEW_CANCEL','cancel');

/**
 * Xupdate_Module
**/
class Xupdate_Module extends Xcore_ModuleAdapter
{
    public /*** string ***/ $mActionName = null;

    public /*** Xupdate_AbstractAction ***/ $mAction = null;

    public /*** bool ***/ $mAdminFlag = false;

    public /*** Xupdate_AssetManager ***/ $mAssetManager = null;

    protected /*** string ***/ $_mPreferenceEditUrl = null;

    protected /*** string ***/ $_mHelpViewUrl = null;

    protected /*** Enum[] ***/ $_mAllowViewNames = array(
        XUPDATE_FRAME_VIEW_NONE,
        XUPDATE_FRAME_VIEW_SUCCESS,
        XUPDATE_FRAME_VIEW_ERROR,
        XUPDATE_FRAME_VIEW_INDEX,
        XUPDATE_FRAME_VIEW_INPUT,
        XUPDATE_FRAME_VIEW_PREVIEW,
        XUPDATE_FRAME_VIEW_CANCEL
    );

    /**
     * startup
     *
     * @param   void
     *
     * @return  void
    **/
    public function startup()
    {
        parent::startup();

        DelegateUtils::call('Module.xupdate.Global.Event.GetAssetManager',new Ref($this->mAssetManager),$this->mXoopsModule->get('dirname'));

        $root = Root::getSingleton();
        $root->mController->mExecute->add(array(&$this, 'execute'));

        //
        // TODO/Insert your initialization code.
        //
    }

    /**
     * setAdminMode
     *
     * @param   bool  $flag
     *
     * @return  void
    **/
    public function setAdminMode(/*** bool ***/ $flag)
    {
        $this->mAdminFlag = $flag;
    }

    /**
     * _getDefaultActionName
     *
     * @param   void
     *
     * @return  string
    **/
    private function _getDefaultActionName()
    {
        // TODO insert your default action name
//		return 'index.php?action=StoreList';
		return 'StoreList';
    }

    /**
     * setActionName
     *
     * @param   string  $name
     *
     * @return  void
    **/
    public function setActionName(/*** string ***/ $name)
    {
        $this->mActionName = $name;
    }

    /**
     * getRenderSystemName
     *
     * @param   void
     *
     * @return  string
    **/
    public function getRenderSystemName()
    {
        if(!$this->mAdminFlag)
        {
            return parent::getRenderSystemName();
        }

        // TODO will be use site config
        if(!defined('XUPDATE_ADMIN_RENDER_REGISTED'))
        {
            define('XUPDATE_ADMIN_RENDER_REGISTED',true);
            $root = Root::getSingleton();
            $root->overrideSiteConfig(
                array(
                    'RenderSystems' => array(
                        'Xupdate_AdminRenderSystem' => 'Xupdate_AdminRenderSystem'
                    ),
                    'Xupdate_AdminRenderSystem' => array(
                        'root' => XUPDATE_TRUST_PATH,
                        'path' => '/admin/class/XupdateAdminRenderSystem.class.php',
                        'class' => 'Xupdate_AdminRenderSystem'
                    )
                )
            );
        }

        return 'Xupdate_AdminRenderSystem';
    }

    /**
     * getAdminMenu
     *
     * @param   void
     *
     * @return  {string 'title',string 'link',string 'keywords',bool 'show',bool 'absolute'}[]
    **/
    public function getAdminMenu()
    {
        if(is_array($this->mAdminMenu))
        {
            return $this->mAdminMenu;
        }

        $root = Root::getSingleton();

        // load admin menu
        $adminMenu = $this->mXoopsModule->getInfo('adminmenu');
        if(!is_array($adminMenu))
        {
            $adminMenu = array();
        }

        // add preference menu
        if($url = $this->getPreferenceEditUrl())
        {
            $adminMenu[] = array(
                'title'    => _PREFERENCES,
                'link'     => $url,
                'absolute' => true
            );
        }

        // add help menu
        if($url = $this->getHelpViewUrl())
        {
            $adminMenu[] = array(
                'title'    => _HELP,
                'link'     => $url,
                'absolute' => true
            );
        }

        $this->mAdminMenu = array();
        foreach($adminMenu as $menu)
        {
            if(!(isset($menu['absolute']) && $menu['absolute']))
            {
                $menu['link'] = XOOPS_MODULE_URL . '/' . $this->mXoopsModule->get('dirname') . '/' . $menu['link'];
            }
            $this->mAdminMenu[] = $menu;
        }

        return $this->mAdminMenu;
    }

    /**
     * getPreferenceEditUrl
     *
     * @param   void
     *
     * @return  string
    **/
    public function getPreferenceEditUrl()
    {

        if($this->_mPreferenceEditUrl === null)
        {
            if(is_array($this->mXoopsModule->getInfo('config')) && count($this->mXoopsModule->getInfo('config')) > 0)
            {
                $root = Root::getSingleton();
                $this->_mPreferenceEditUrl = $root->mController->getPreferenceEditUrl($this->mXoopsModule);
            }
            else
            {
                $this->_mPreferenceEditUrl = false;
            }
        }

        return $this->_mPreferenceEditUrl;
    }

    /**
     * getHelpViewUrl
     *
     * @param   void
     *
     * @return  string
    **/
    public function getHelpViewUrl()
    {
        if($this->_mHelpViewUrl === null)
        {
            if($this->mXoopsModule->hasHelp())
            {
                $root = Root::getSingleton();
                $this->_mHelpViewUrl = $root->mController->getHelpViewUrl($this->mXoopsModule);
            }
            else
            {
                $this->_mHelpViewUrl = false;
            }
        }

        return $this->_mHelpViewUrl;
    }

    /**
     * execute
     *
     * @param   Controller  &$controller
     *
     * @return  void
    **/
    public function execute(&$controller)
    {
        if($this->_createAction() === false)
        {
            $this->doActionNotFoundError();
            die();
        }

        if($this->mAction->prepare() === false)
        {
            $this->doPreparationError();
            die();
        }

        if($this->mAction->hasPermission() === false)
        {
            $this->doPermissionError();
            die();
        }

        $viewStatus = (Xupdate_Utils::getEnv('REQUEST_METHOD') == 'POST') ?
            $this->mAction->execute() :
            $this->mAction->getDefaultView();

        if(in_array($viewStatus,$this->_mAllowViewNames))
        {
            $methodName = 'executeView' . ucfirst($viewStatus);
            if(is_callable(array($this->mAction,$methodName)))
            {
                $render = $this->getRenderTarget();
                $this->mAction->$methodName($render);
		        $render->setAttribute('xoops_pagetitle', $this->mAction->getPagetitle());
		        //$this->mAction->setHeaderScript();
            }
        }
    }

    /**
     * _createAction
     *
     * @param   void
     *
     * @return  bool
    **/
    private function _createAction()
    {
        $root = Root::getSingleton();

        if($this->mActionName == null)
        {
            $this->mActionName = $root->mContext->mRequest->getRequest('action');
            if($this->mActionName == null)
            {
                $this->mActionName = $this->_getDefaultActionName();
            }
        }

        if(!ctype_alnum($this->mActionName))
        {
            return false;
        }

        $fileName = ($this->mAdminFlag ? '/admin' : '')
            . '/actions/' . ucfirst($this->mActionName) . 'Action.class.php';
        switch(true)
        {
            case file_exists(
                $path = XOOPS_MODULE_PATH . '/' . $this->mXoopsModule->get('dirname') . $fileName
            ):
                break;
            case file_exists(
                $path = XUPDATE_TRUST_PATH . '/' . $fileName
            ):
                break;
            default:
                return false;
        }

        require_once $path;

        $className = 'Xupdate_' . ($this->mAdminFlag ? 'Admin_' : '')
            . ucfirst($this->mActionName) . 'Action';
        if(class_exists($className))
        {
            $this->mAction = new $className();
        }
        if(!$this->mAction instanceof Xupdate_AbstractAction)
        {
            return false;
        }

        return true;
    }

    /**
     * doActionNotFoundError
     *
     * @param   void
     *
     * @return  void
    **/
    private function doActionNotFoundError()
    {
        /**
         * Module.xupdate.Global.Event.Exception.ActionNotFound
         *
         * @param   string  $dirname
         *
         * @return  void
        **/
        DelegateUtils::call('Module.xupdate.Global.Event.Exception.ActionNotFound',$this->mAssetManager->mDirname);
        /**
         * Module.{dirname}.Event.Exception.ActionNotFound
         *
         * @param   void
         *
         * @return  void
        **/
        DelegateUtils::call('Module.' . $this->mXoopsModule->get('dirname') . '.Event.Exception.ActionNotFound');
        $root = Root::getSingleton();
        $root->mController->executeForward(XOOPS_URL);
    }

    /**
     * doPreparationError
     *
     * @param   void
     *
     * @return  void
    **/
    private function doPreparationError()
    {
        /**
         * Module.xupdate.Global.Event.Exception.Preparation
         *
         * @param   string  $dirname
         *
         * @return  void
        **/
        DelegateUtils::call('Module.xupdate.Global.Event.Exception.Preparation',$this->mAssetManager->mDirname);
        /**
         * Module.{dirname}.Event.Exception.Preparation
         *
         * @param   void
         *
         * @return  void
        **/
        DelegateUtils::call('Module.' . $this->mXoopsModule->get('dirname') . '.Event.Exception.Preparation');
        $root = Root::getSingleton();
        $root->mController->executeForward(XOOPS_URL);
    }

    /**
     * doPermissionError
     *
     * @param   void
     *
     * @return  void
    **/
    private function doPermissionError()
    {
        /**
         * Module.xupdate.Global.Event.Exception.Permission
         *
         * @param   string  $dirname
         *
         * @return  void
        **/
        DelegateUtils::call('Module.xupdate.Global.Event.Exception.Permission',$this->mAssetManager->mDirname);
        /**
         * Module.{dirname}.Event.Exception.Permission
         *
         * @param   void
         *
         * @return  void
        **/
        DelegateUtils::call('Module.' . $this->mXoopsModule->get('dirname') . '.Event.Exception.Permission');
        $root = Root::getSingleton();
        $root->mController->executeForward(XOOPS_URL);
    }
}

?>
