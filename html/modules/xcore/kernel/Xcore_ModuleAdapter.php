<?php

/**
 * @public
 * @brief Used for adapting $xoopsModule to imitate XOOPS2 responses.
 * @remarks
 *    This class is the standard class implementing Xcore_AbstractModule, and is helpful
 *    to be used by Xcore_Controller. If a module doesn't define its sub-class of
 *    Xcore_AbstractModule, this class is used as generic Xcore_AbstractModule.
 */
use XCore\Kernel\Root;

class Xcore_ModuleAdapter extends Xcore_AbstractModule
{
    /**
     * @private
     * @brief bool
     */
    var $_mAdminMenuLoadedFlag = false;
    
    /**
     * @protected
     * @brief Complex Array - cached
     */
    var $mAdminMenu = null;
    
    function __construct($module, $loadConfig=true)
    {
        parent::__construct($module, $loadConfig);
    }

    /**
     * @public
     * @brief This method is called back by the action search feature in the control
     *        panel.
     * @param Xcore_ActionSearchArgs $searchArgs
     * @return void
     * @see Xcore_ActionSearchArgs
     */
    function doActionSearch(&$searchArgs)
    {
        if(!is_object($searchArgs)) {
            return;
        }

        $this->mKarimojiModule->loadAdminMenu();
        if(count($this->mKarimojiModule->adminmenu) == 0 && !isset($this->mKarimojiModule->modinfo['config']) ) {
            return;
        }
            
        //
        // Search preference
        //
        if(isset($this->mKarimojiModule->modinfo['config'])&&count($this->mKarimojiModule->modinfo['config'])>0) {
            $findFlag = false;
            foreach($searchArgs->getKeywords() as $word) {
                if (stristr(_PREFERENCES, $word) !== false) {
                    $root = Root::getSingleton();
                    $searchArgs->addRecord($this->mKarimojiModule->getVar('name'), $root->mController->getPreferenceEditUrl($this->mKarimojiModule), _PREFERENCES);
                    $findFlag = true;
                    break;
                }
            }
            
            if (!$findFlag) {
                $configInfos=array();
                foreach($this->mKarimojiModule->modinfo['config'] as $config) {
                    if(isset($config['title']))
                        $configInfos[]=@constant($config['title']);
                    if(isset($config['description']))
                        $configInfos[]=@constant($config['description']);
                    if(isset($config['options'])&&count($config['options'])>0) {
                        foreach($config['options'] as $key=>$val) {
                            $configInfos[]=(@constant($key) ? @constant($key) : $key);
                        }
                    }
                }
    
                $findFlag=true;
                foreach($searchArgs->getKeywords() as $word) {
                    $findFlag&=(stristr(implode(" ",$configInfos),$word)!==false);
                }
                    
                if($findFlag) {
                    $searchArgs->addRecord($this->mKarimojiModule->getVar('name'),
                                      XOOPS_URL.'/modules/xcore/admin/index.php?action=PreferenceEdit&amp;confmod_id='.$this->mKarimojiModule->getVar('mid'),
                                      _PREFERENCES );
                }
            }
        }
        
        //
        // Search AdminMenu
        //
        if(count($this->mKarimojiModule->adminmenu)>0) {
            foreach($this->mKarimojiModule->adminmenu as $menu) {
                $findFlag=true;
                foreach($searchArgs->getKeywords() as $word) {
                    $tmpFlag=false;
                    $tmpFlag|=(stristr($menu['title'],$word)!==false);

                    // Search keyword
                    if(isset($menu['keywords'])) {
                        $keyword=is_array($menu['keywords']) ? implode(" ",$menu['keywords']) : $menu['keywords'];
                        $tmpFlag|=(stristr($keyword,$word)!==false);
                    }

                    $findFlag&=$tmpFlag;
                }

                if($findFlag) {
                    //
                    // Create url string with absolute information.
                    //
                    $url="";
                    if(isset($menu['absolute'])&&$menu['absolute']) {
                        $url=$menu['link'];
                    }
                    else {
                        $url=XOOPS_URL."/modules/".$this->mKarimojiModule->getVar('dirname')."/".$menu['link'];
                    }

                    //
                    // Add record
                    //
                    $searchArgs->addRecord($this->mKarimojiModule->getVar('name'),$url,$menu['title']);
                }
            }
        }
        
        //
        // Search help
        //
        if ($this->mKarimojiModule->hasHelp()) {
            $findFlag = false;
            
            foreach($searchArgs->getKeywords() as $word) {
                if (stristr(_HELP, $word) !== false) {
                    $root = Root::getSingleton();
                    $searchArgs->addRecord($this->mKarimojiModule->getVar('name'), $root->mController->getHelpViewUrl($this->mKarimojiModule), _HELP);
                    $findFlag = true;
                    break;
                }
            }
            
            if (!$findFlag) {
                $root = Root::getSingleton();
                $language = $root->mContext->getXoopsConfig('language');
                $helpfile = $this->mKarimojiModule->getHelp();
                $dir = XOOPS_MODULE_PATH . "/" . $this->mKarimojiModule->getVar('dirname') . "/language/" . $language. "/help";
    
                if (!file_exists($dir . "/" . $helpfile)) {
                    $dir = XOOPS_MODULE_PATH . "/" . $this->mKarimojiModule->getVar('dirname') . "/language/english/help";
                        if (!file_exists($dir . "/" . $helpfile)) {
                            return;
                        }
                }
                $lines = file($dir . "/" . $helpfile);
                foreach ($lines as $line) {
                    foreach($searchArgs->getKeywords() as $word) {
                        if (stristr($line, $word) !== false) {
                            $url = XOOPS_MODULE_URL . "/xcore/admin/index.php?action=Help&amp;dirname=" . $this->mKarimojiModule->getVar('dirname');
                            $searchArgs->addRecord($this->mKarimojiModule->getVar('name'), $url, _HELP);
                            return;
                        }
                    }
                }
            }
        }
    }

    function doXcoreGlobalSearch($queries, $andor, $max_hit, $start, $uid)
    {
        $ret = array();
        $results = $this->mKarimojiModule->search($queries, $andor, $max_hit, $start, $uid);
        
        if (is_array($results) && count($results) > 0) {
            foreach ($results as $result) {
                $item = array();
                if (isset($result['image']) && strlen($result['image']) > 0) {
                    $item['image'] = XOOPS_URL . '/modules/' . $this->mKarimojiModule->get('dirname') . '/' . $result['image'];
                }
                else {
                    $item['image'] = XOOPS_URL . '/images/icons/posticon2.gif';
                }
                        
                $item['link'] = XOOPS_URL . '/modules/' . $this->mKarimojiModule->get('dirname') . '/' . $result['link'];
                $item['title'] = $result['title'];
                $item['uid'] = $result['uid'];
                        
                //
                // TODO If this service will come to web service, we should
                // change format from unixtime to string by timeoffset.
                //
                $item['time'] = isset($result['time']) ? $result['time'] : 0;
                
                $ret[] = $item;
            }
        }
        
        return $ret;
    }
    
    /**
     * @public
     * @brief [Final] Gets a value indicating whether this module has the page controller in
     *        the control panel side.
     * @return bool
     */
    function hasAdminIndex()
    {
        $dmy =& $this->mKarimojiModule->getInfo();
        return isset($this->mKarimojiModule->modinfo['adminindex']) && $this->mKarimojiModule->modinfo['adminindex'] != null;
    }
    
    /**
     * @public
     * @brief Gets an absolute URL indicating the top page of this module for the control
     *        panel side.
     * @return string
     */
    function getAdminIndex()
    {
        $dmy =& $this->mKarimojiModule->getInfo();
        return XOOPS_MODULE_URL . '/' . $this->mKarimojiModule->get('dirname') . '/' . $this->mKarimojiModule->modinfo['adminindex'];
    }
    
    function getAdminMenu()
    {
        if ($this->_mAdminMenuLoadedFlag) {
            return $this->mAdminMenu;
        }
        
        $info =& $this->mKarimojiModule->getInfo();
        $root = Root::getSingleton();

        //
        // Load admin menu, and add preference menu by own judge.
        //
        $this->mKarimojiModule->loadAdminMenu();
        if ($this->mKarimojiModule->get('hasnotification')
            || (isset($info['config']) && is_array($info['config']))
            || (isset($info['comments']) && is_array($info['comments']))) {
                $this->mKarimojiModule->adminmenu[] = array(
                    'link' => $root->mController->getPreferenceEditUrl($this->mKarimojiModule),
                    'title' => _PREFERENCES,
                    'absolute' => true);
        }
            
        if ($this->mKarimojiModule->hasHelp()) {
            $this->mKarimojiModule->adminmenu[] = array('link' =>  $root->mController->getHelpViewUrl($this->mKarimojiModule),
                                          'title' => _HELP,
                                          'absolute' => true);
        }
        
        $this->_mAdminMenuLoadedFlag = true;
        
        if ($this->mKarimojiModule->adminmenu) {
			$dirname = $this->mKarimojiModule->get('dirname');
            foreach ($this->mKarimojiModule->adminmenu as $menu) {
                if (!isset($menu['absolute']) || (isset($menu['absolute']) && $menu['absolute'] != true)) {
                    $menu['link'] = XOOPS_MODULE_URL . '/' . $dirname . '/' . $menu['link'];
                }
                $this->mAdminMenu[] = $menu;
            }
        }
        
        return $this->mAdminMenu;
    }
}
