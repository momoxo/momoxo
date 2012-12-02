<?php

use XCore\Kernel\ActionFilter;

class Xcore_Waiting extends ActionFilter {
    function preBlockFilter()
    {
        $this->mController->mRoot->mDelegateManager->add('Xcoreblock.Waiting.Show',array(&$this,"callbackWaitingShow"));
    }
    
    function callbackWaitingShow(&$modules) {
        $xoopsDB =& Database::getInstance();
        // for News Module
        $module_handler =& xoops_gethandler('module');
        if ($module_handler->getCount(new Criteria('dirname', 'news'))) {
            $result = $xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("stories")." WHERE published=0");
            if ( $result ) {
                $blockVal = array();
                $blockVal['adminlink'] = XOOPS_URL."/modules/news/admin/index.php?op=newarticle";
                list($blockVal['pendingnum']) = $xoopsDB->fetchRow($result);
                $blockVal['lang_linkname'] = _MB_XCORE_SUBMS;
                $modules[] = $blockVal;
            }
        }
        // for MyLinks Module
        if ($module_handler->getCount(new Criteria('dirname', 'mylinks'))) {
            $result = $xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("mylinks_links")." WHERE status=0");
            if ( $result ) {
                $blockVal = array();
                $blockVal['adminlink'] = XOOPS_URL."/modules/mylinks/admin/index.php?op=listNewLinks";
                list($blockVal['pendingnum']) = $xoopsDB->fetchRow($result);
                $blockVal['lang_linkname'] = _MB_XCORE_WLNKS;
                $modules[] = $blockVal;
            }
            $result = $xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("mylinks_broken"));
            if ( $result ) {
                $blockVal = array();
                $blockVal['adminlink'] = XOOPS_URL."/modules/mylinks/admin/index.php?op=listBrokenLinks";
                list($blockVal['pendingnum']) = $xoopsDB->fetchRow($result);
                $blockVal['lang_linkname'] = _MB_XCORE_BLNK;
                $modules[] = $blockVal;
            }
            $result = $xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("mylinks_mod"));
            if ( $result ) {
                $blockVal = array();
                $blockVal['adminlink'] = XOOPS_URL."/modules/mylinks/admin/index.php?op=listModReq";
                list($blockVal['pendingnum']) = $xoopsDB->fetchRow($result);
                $blockVal['lang_linkname'] = _MB_XCORE_MLNKS;
                $modules[] = $blockVal;
            }
        }
        // for MyDownloads Modules
        if ($module_handler->getCount(new Criteria('dirname', 'mydownloads'))) {
            $result = $xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("mydownloads_downloads")." WHERE status=0");
            if ( $result ) {
                $blockVal = array();
                $blockVal['adminlink'] = XOOPS_URL."/modules/mydownloads/admin/index.php?op=listNewDownloads";
                list($blockVal['pendingnum']) = $xoopsDB->fetchRow($result);
                $blockVal['lang_linkname'] = _MB_XCORE_WDLS;
                $modules[] = $blockVal;
            }
            $result = $xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("mydownloads_broken")."");
            if ( $result ) {
                $blockVal = array();
                $blockVal['adminlink'] = XOOPS_URL."/modules/mydownloads/admin/index.php?op=listBrokenDownloads";
                list($blockVal['pendingnum']) = $xoopsDB->fetchRow($result);
                $blockVal['lang_linkname'] = _MB_XCORE_BFLS;
                $modules[] = $blockVal;
            }
            $result = $xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("mydownloads_mod")."");
            if ( $result ) {
                $blockVal = array();
                $blockVal['adminlink'] = XOOPS_URL."/modules/mydownloads/admin/index.php?op=listModReq";
                list($blockVal['pendingnum']) = $xoopsDB->fetchRow($result);
                $blockVal['lang_linkname'] = _MB_XCORE_MFLS;
                $modules[] = $blockVal;
            }
        }
        // for Comments
        $result = $xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("xoopscomments")." WHERE com_status=1");
        if ( $result ) {
            $blockVal = array();
            $blockVal['adminlink'] = XOOPS_URL."/modules/xcore/admin/index.php?action=CommentList&amp;com_modid=0&amp;com_status=1";
            list($blockVal['pendingnum']) = $xoopsDB->fetchRow($result);
            $blockVal['lang_linkname'] =_MB_XCORE_COMPEND;
            $modules[] = $blockVal;
        }
    }
}
