<?php

/**
 * Renders a form for setting module specific group permissions
 * 
 * @author Kazumi Ono <onokazu@myweb.ne.jp> 
 * @copyright copyright (c) 2000-2003 XOOPS.org
 * @package kernel
 * @subpackage form
 */
use XCore\Kernel\Root;

class XoopsGroupPermForm extends XoopsForm
{
    /**
     * Module ID
     * 
     * @var int 
     */
    var $_modid;
    /**
     * Tree structure of items
     * 
     * @var array 
     */
    var $_itemTree = array();
    /**
     * Name of permission
     * 
     * @var string 
     */
    var $_permName;
    /**
     * Description of permission
     * 
     * @var string 
     */
    var $_permDesc;

    /**
     * Constructor
     */
    function XoopsGroupPermForm($title, $modid, $permname, $permdesc, $url = "")
    {
        $this->XoopsForm($title, 'groupperm_form', XOOPS_URL . '/modules/xcore/include/groupperm.php', 'post');
        $this->_modid = intval($modid);
        $this->_permName = $permname;
        $this->_permDesc = $permdesc;
        $this->addElement(new XoopsFormHidden('modid', $this->_modid));
        if ($url != "") {
            $this->addElement(new XoopsFormHidden('redirect_url', $url));
        }
    } 

    /**
     * Adds an item to which permission will be assigned
     * 
     * @param string $itemName 
     * @param int $itemId 
     * @param int $itemParent 
     * @access public 
     */
    function addItem($itemId, $itemName, $itemParent = 0)
    {
        $this->_itemTree[$itemParent]['children'][] = $itemId;
        $this->_itemTree[$itemId]['parent'] = $itemParent;
        $this->_itemTree[$itemId]['name'] = $itemName;
        $this->_itemTree[$itemId]['id'] = $itemId;
    } 

    /**
     * Loads all child ids for an item to be used in javascript
     * 
     * @param int $itemId 
     * @param array $childIds 
     * @access private 
     */
    function _loadAllChildItemIds($itemId, &$childIds)
    {
        if (!empty($this->_itemTree[$itemId]['children'])) {
            $first_child = $this->_itemTree[$itemId]['children'];
            foreach ($first_child as $fcid) {
                array_push($childIds, $fcid);
                if (!empty($this->_itemTree[$fcid]['children'])) {
                    foreach ($this->_itemTree[$fcid]['children'] as $_fcid) {
                        array_push($childIds, $_fcid);
                        $this->_loadAllChildItemIds($_fcid, $childIds);
                    }
                }
            }
        }
    }

    /**
     * Renders the form
     * 
     * @return string
     * @access public
     */
    function render()
    { 
        // load all child ids for javascript codes
        foreach (array_keys($this->_itemTree)as $item_id) {
            $this->_itemTree[$item_id]['allchild'] = array();
            $this->_loadAllChildItemIds($item_id, $this->_itemTree[$item_id]['allchild']);
        }
        $gperm_handler =& xoops_gethandler('groupperm');
        $member_handler =& xoops_gethandler('member');
        $glist =& $member_handler->getGroupList();
        foreach (array_keys($glist) as $i) {
            // get selected item id(s) for each group
            $selected = $gperm_handler->getItemIds($this->_permName, $i, $this->_modid);
            $ele = new XoopsGroupFormCheckBox($glist[$i], 'perms[' . $this->_permName . ']', $i, $selected);
            $ele->setOptionTree($this->_itemTree);
            $this->addElement($ele);
            unset($ele);
        } 
        $tray = new XoopsFormElementTray('');
        $tray->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $tray->addElement(new XoopsFormButton('', 'reset', _CANCEL, 'reset'));
        $this->addElement($tray);
		
		$root =& Root::getSingleton();
		$renderSystem =& $root->getRenderSystem(XOOPSFORM_DEPENDENCE_RENDER_SYSTEM);
		
		$renderTarget =& $renderSystem->createRenderTarget('main');
	
		$renderTarget->setAttribute('xcore_module', 'xcore');
		$renderTarget->setTemplateName("xcore_xoopsform_grouppermform.html");
		
		$renderTarget->setAttribute("form", $this);

		$renderSystem->render($renderTarget);
	
		return $renderTarget->getResult();
    }
}
