<?php

/**
 * A block
 *
 * @author Kazumi Ono <onokazu@xoops.org>
 * @copyright copyright (c) 2000 XOOPS.org
 *
 * @package kernel
 **/
use XCore\Kernel\Root;

class XoopsBlock extends XoopsObject
{
	var $mBlockFlagMapping = array();

    /**
     * constructor
     *
     * @param mixed $id
     **/
    function __construct($id = null)
    {
		static $initVars, $initMap;
		if (isset($initVars)) {
		    $this->vars = $initVars;
		}
		else{
	        $this->initVar('bid', XOBJ_DTYPE_INT, null, false);
	        $this->initVar('mid', XOBJ_DTYPE_INT, 0, false);
	        $this->initVar('func_num', XOBJ_DTYPE_INT, 0, false);
	        $this->initVar('options', XOBJ_DTYPE_TXTBOX, null, false, 255);
	        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, true, 150);
	        //$this->initVar('position', XOBJ_DTYPE_INT, 0, false);
	        $this->initVar('title', XOBJ_DTYPE_TXTBOX, null, false, 150);
	        $this->initVar('content', XOBJ_DTYPE_TXTAREA, null, false);
	        $this->initVar('side', XOBJ_DTYPE_INT, 0, false);
	        $this->initVar('weight', XOBJ_DTYPE_INT, 0, false);
	        $this->initVar('visible', XOBJ_DTYPE_INT, 0, false);
	        $this->initVar('block_type', XOBJ_DTYPE_OTHER, null, false);
	        $this->initVar('c_type', XOBJ_DTYPE_OTHER, null, false);
	        $this->initVar('isactive', XOBJ_DTYPE_INT, null, false);
	        $this->initVar('dirname', XOBJ_DTYPE_TXTBOX, null, false, 50);
	        $this->initVar('func_file', XOBJ_DTYPE_TXTBOX, null, false, 50);
	        $this->initVar('show_func', XOBJ_DTYPE_TXTBOX, null, false, 50);
	        $this->initVar('edit_func', XOBJ_DTYPE_TXTBOX, null, false, 50);
	        $this->initVar('template', XOBJ_DTYPE_OTHER, null, false);
	        $this->initVar('bcachetime', XOBJ_DTYPE_INT, 0, false);
	        $this->initVar('last_modified', XOBJ_DTYPE_INT, time(), false);
			$initVars = $this->vars;
			$initMap = array(
			0 => false,
				SHOW_SIDEBLOCK_LEFT => 0,
				SHOW_SIDEBLOCK_RIGHT => 1,
				SHOW_CENTERBLOCK_LEFT => 3,
				SHOW_CENTERBLOCK_RIGHT => 4,
				SHOW_CENTERBLOCK_CENTER => 5
			);
		}
	
        // for backward compatibility
        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            } else {
                $this->load($id);
            }
        }
		$this->mBlockFlagMapping = $initMap;
    }

    /**
     * return the content of the block for output
     *
     * [ToDo]
     * Why does this function return reference? Perhaps, it isn't needed even
     * if it's at compatibility also.
     *
     * @param string $format
     * @param string $c_type type of content<br>
     * Legal value for the type of content<br>
     * <ul><li>H : custom HTML block
     * <li>P : custom PHP block
     * <li>S : use text sanitizater (smilies enabled)
     * <li>T : use text sanitizater (smilies disabled)</ul>
     * @return string content for output
     **/
    function &getContent($format = 'S', $c_type = 'T')
    {
		$ret = null;

        switch ( $format ) {
        case 'S':
		
            // check the type of content
            // H : custom HTML block
            // P : custom PHP block
            // S : use text sanitizater (smilies enabled)
            // T : use text sanitizater (smilies disabled)
            if ( $c_type == 'H' ) {
                $ret = str_replace('{X_SITEURL}', XOOPS_URL.'/', $this->getVar('content', 'N'));
            } elseif ( $c_type == 'P' ) {
                ob_start();
                echo eval($this->get('content'));
                $content = ob_get_contents();
                ob_end_clean();
                $ret = str_replace('{X_SITEURL}', XOOPS_URL.'/', $content);
            } elseif ( $c_type == 'S' ) {
                $myts =& MyTextSanitizer::getInstance();
                $ret = str_replace('{X_SITEURL}', XOOPS_URL.'/', $myts->displayTarea($this->get('content'), 1, 1));
            } else {
                $myts =& MyTextSanitizer::getInstance();
                $ret = str_replace('{X_SITEURL}', XOOPS_URL.'/', $myts->displayTarea($this->get('content'), 1, 0));
            }
            break;
        case 'E':
            $ret = $this->getVar('content', 'E');
            break;
        default:
            $ret = $this->get('content');
            break;
        }
		
		return $ret;
    }

    function &buildBlock()
    {
        $ret = false;

        $block = array();
        // M for module block, S for system block C for Custom
        if ( $this->get('block_type') != 'C' ) {
            // get block display function
            $show_func = $this->getVar('show_func', 'N');
            if ( !$show_func ) return $ret;
            // must get lang files b4 execution of the function
            if ( file_exists($path = XOOPS_ROOT_PATH.'/modules/'.($dirname = $this->getVar('dirname', 'N')).'/blocks/'.$this->getVar('func_file', 'N')) ) {
                $root = Root::getSingleton();
                $root->mLanguageManager->loadBlockMessageCatalog($dirname);

                require_once $path;
                if ( function_exists($show_func) ) {
                    // execute the function
                    $block = $show_func(explode('|', $this->getVar('options', 'N')));
                    if ( !$block ) return $ret;
                } else return $ret;
            } else return $ret;
        } else {
            // it is a custom block, so just return the contents
            $block['content'] = $this->getContent('S',$this->getVar('c_type', 'N'));
            if (empty($block['content'])) return $ret;
        }
        return $block;
    }

    /*
    * Aligns the content of a block
    * If position is 0, content in DB is positioned
    * before the original content
    * If position is 1, content in DB is positioned
    * after the original content
    */
    function &buildContent($position,$content='',$contentdb='')
    {
        if ( $position == 0 ) {
            $ret = $contentdb.$content;
        } elseif ( $position == 1 ) {
            $ret = $content.$contentdb;
        }
        return $ret;
    }

    function &buildTitle($originaltitle, $newtitle='')
    {
        if ($newtitle != '') {
            $ret = $newtitle;
        } else {
            $ret = $originaltitle;
        }
        return $ret;
    }

    function isCustom()
    {
        if ( $this->get('block_type') == 'C' ) {
            return true;
        }
        return false;
    }

/**
     * (HTML-) form for setting the options of the block
     *
     * @return string HTML for the form, FALSE if not defined for this block
     **/
    function getOptions()
    {
        if ($this->get('block_type') != 'C') {
            $edit_func = $this->getVar('edit_func', 'N');
            if (!$edit_func) {
                return false;
            }
            if (file_exists($path = XOOPS_ROOT_PATH.'/modules/'.($dirname=$this->getVar('dirname', 'N')).'/blocks/'.$this->getVar('func_file', 'N'))) {
				$root = Root::getSingleton();
				$root->mLanguageManager->loadBlockMessageCatalog($dirname);
				
                include_once $path;
                $options = explode('|', $this->getVar('options', 'N'));
                $edit_form = $edit_func($options);
                if (!$edit_form) {
                    return false;
                }
                return $edit_form;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Some functions for for backward compatibility
    //  @deprecated

    function load($id) 
    {
        $handler = xoops_gethandler('block');
        if ($obj =& $handler->get($id)) {
            foreach ($obj->vars as $k => $v) {
                $this->assignVar($k, $v['value']);
            }
        }
    }

    function store()
    {
        $handler = xoops_gethandler('block');
        if($handler->insert($this)) {
            return $this->getVar('bid', 'N');
         
        } else {
            return false;
        }
    }

    function delete()
    {
        $handler = xoops_gethandler('block');
        return $handler->delete($this);
    }
    function &getAllBlocksByGroup($groupid, $asobject=true, $side=null, $visible=null, $orderby='b.weight,b.bid', $isactive=1)
    {
        $handler = xoops_gethandler('block');
        $ret =& $handler->getAllBlocksByGroup($groupid, $asobject, $side, $visible, $orderby, $isactive);
        return $ret;
    }
    function &getAllBlocks($rettype='object', $side=null, $visible=null, $orderby='side,weight,bid', $isactive=1)
    {
        $handler = xoops_gethandler('block');
        $ret =& $handler->getAllBlocks($rettype, $side, $visible, $orderby, $isactive);
        return $ret;
    }
    function &getByModule($moduleid, $asobject=true)
    {
        $handler = xoops_gethandler('block');
        $ret =& $handler->getByModule($moduleid, $asobject);
        return $ret;
    }
    function &getAllByGroupModule($groupid, $module_id=0, $toponlyblock=false, $visible=null, $orderby='b.weight,b.bid', $isactive=1)
    {
        $handler = xoops_gethandler('block');
        $ret =& $handler->getAllByGroupModule($groupid, $module_id, $toponlyblock, $visible, $orderby, $isactive);
        return $ret;
    }
	function &getBlocks($groupid, $mid=false, $blockFlag=SHOW_BLOCK_ALL, $orderby='b.weight,b.bid')
    {
        $handler = xoops_gethandler('block');
        $ret =& $handler->getBlocks($groupid, $mid, $blockFlag, $orderby);
        return $ret;
    }
    function &getNonGroupedBlocks($module_id=0, $toponlyblock=false, $visible=null, $orderby='b.weight,b.bid', $isactive=1)
    {
        $handler = xoops_gethandler('block');
        $ret =& $handler->getNonGroupedBlocks($module_id, $toponlyblock, $visible, $orderby, $isactive);
        return $ret;
    }
    function countSimilarBlocks($moduleId, $funcNum, $showFunc = null)
    {
        $handler = xoops_gethandler('block');
        $ret =& $handler->countSimilarBlocks($moduleId, $funcNum, $showFunc);
        return $ret;
    }
}
