<?php

/**
 * The adapter class for XoopsBlock objects of XOOPS2 JP.
 * @see Xcore_AbstractBlockProcedure
 */
class Xcore_BlockProcedureAdapter extends Xcore_BlockProcedure
{
    var $_mDisplayFlag = true;
    
    function execute()
    {
        $result =& $this->_mBlock->buildBlock();
        
        if (empty($result)) {
            $this->_mDisplayFlag = false;
            return;
        }
        
        $render =& $this->getRenderTarget();
        $render->setAttribute("mid", $this->_mBlock->get('mid'));
        $render->setAttribute("bid", $this->_mBlock->get('bid'));
        
        if ($this->_mBlock->get('template') == null) {
            $render->setTemplateName('system_dummy.html');
            $render->setAttribute('dummy_content', $result['content']);
        }
        else {
            $render->setTemplateName($this->_mBlock->get('template'));
            $render->setAttribute('block', $result);
        }
        
        $root =& XCube_Root::getSingleton();
        $renderSystem =& $root->getRenderSystem($this->getRenderSystemName());
        
        $renderSystem->renderBlock($render);
    }
    
    function isDisplay()
    {
        return $this->_mDisplayFlag;
    }

    function _hasVisibleOptionForm()
    {
        return ($this->_mBlock->get('func_file') && $this->_mBlock->get('edit_func'));
    }
    
    function getOptionForm()
    {
        if ($this->_mBlock->get('func_file') && $this->_mBlock->get('edit_func')) {
            $func_file = XOOPS_MODULE_PATH . "/" . $this->_mBlock->get('dirname') . "/blocks/" . $this->_mBlock->get('func_file');
            if (file_exists($func_file)) {
                require $func_file;
                $edit_func = $this->_mBlock->get('edit_func');
                
                $options = explode('|', $this->_mBlock->get('options'));
                
                if (function_exists($edit_func)) {
                    //
                    // load language file.
                    //
                    $root =& XCube_Root::getSingleton();
                    $langManager =& $root->getLanguageManager();
                    $langManager->loadBlockMessageCatalog($this->_mBlock->get('dirname'));
                    
                    return call_user_func($edit_func, $options);
                }
            }
        }
        
        //
        // The block may have options, even it doesn't have end_func 
        //
        if ($this->_mBlock->get('options')) {
            $root =& XCube_Root::getSingleton();
            $textFilter =& $root->getTextFilter();
            
            $buf = "";
            $options = explode('|', $this->_mBlock->get('options'));
            foreach ($options as $val) {
                $val = $textFilter->ToEdit($val);
                $buf .= "<input type='hidden' name='options[]' value='${val}'/>";
            }
            
            return $buf;
        }

        return null;
    }
}
