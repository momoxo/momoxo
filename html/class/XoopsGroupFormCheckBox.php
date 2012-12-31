<?php

/**
 * Renders checkbox options for a group permission form
 * 
 * @author Kazumi Ono <onokazu@myweb.ne.jp> 
 * @copyright copyright (c) 2000-2003 XOOPS.org
 * @package kernel
 * @subpackage form
 */
use XCore\Entity\Group;

class GroupFormCheckBox extends XoopsFormElement
{
    /**
     * Pre-selected value(s)
     * 
     * @var array;
     */
    var $_value = array();
    /**
     * Group ID
     * 
     * @var int 
     */
    var $_groupId;
    /**
     * Option tree
     * 
     * @var array 
     */
    var $_optionTree = array();

    /**
     * Constructor
     */
    function GroupFormCheckBox($caption, $name, $groupId, $values = null)
    {
        $this->setCaption($caption);
        $this->setName($name);
        if (isset($values)) {
            $this->setValue($values);
        }
        $this->_groupId = $groupId;
    }

    /**
     * Sets pre-selected values
     * 
     * @param mixed $value A group ID or an array of group IDs
     * @access public 
     */
    function setValue($value)
    {
        if (is_array($value)) {
            foreach ($value as $v) {
                $this->setValue($v);
            }
        } else {
            $this->_value[] = $value;
        }
    }

    /**
     * Sets the tree structure of items
     * 
     * @param array $optionTree 
     * @access public 
     */
    function setOptionTree(&$optionTree)
    {
        $this->_optionTree =& $optionTree;
    }
	
    /**
     * Renders checkbox options for this group
     * 
     * @return string 
     * @access public 
     */
    function render()
    {
		$ret = '<table class="outer"><tr><td class="odd"><table><tr>';
		$cols = 1;
		
		if ($this->_hasChildren())
		foreach ($this->_optionTree[0]['children'] as $topitem) {
			if ($cols > 4) {
				$ret .= '</tr><tr>';
				$cols = 1;
			}
			$tree = '<td>';
			$prefix = '';
			$this->_renderOptionTree($tree, $this->_optionTree[$topitem], $prefix);
			$ret .= $tree.'</td>';
			$cols++;
		}
		$ret .= '</tr></table></td><td class="even">';
		$option_ids = array();
		foreach (array_keys($this->_optionTree) as $id) {
			if (!empty($id)) {
				$option_ids[] = "'".$this->getName().'[groups]['.$this->_groupId.']['.$id.']'."'";
			}
		}
		$checkallbtn_id = $this->getName().'[checkallbtn]['.$this->_groupId.']';
		$checkallbtn_id = str_replace(array('[', ']'), array('_', ''), $checkallbtn_id); // Remove injury characters for ID
		
		$option_ids_str = implode(', ', $option_ids);
		$option_ids_str = str_replace(array('[', ']'), array('_', ''), $option_ids_str); // Remove injury characters for ID
		
		
		$ret .= _ALL." <input id=\"".$checkallbtn_id."\" type=\"checkbox\" value=\"\" onclick=\"var optionids = new Array(".$option_ids_str."); xoopsCheckAllElements(optionids, '".$checkallbtn_id."');\" />";
		$ret .= '</td></tr></table>';
		return $ret;
    } 

    /**
     * Renders checkbox options for an item tree
     * 
     * @param string $tree 
     * @param array $option 
     * @param string $prefix 
     * @param array $parentIds 
     * @access private 
     */
    function _renderOptionTree(&$tree, $option, $prefix, $parentIds = array())
    {
		// Remove injury characters for ID
 		$tree .= $prefix . "<input type=\"checkbox\" name=\"" . $this->getName() .
		         "[groups][" . $this->_groupId . "][" . $option['id'] . "]\" id=\"" .
				 str_replace(array('[', ']'), array('_', ''), $this->getName() . "[groups][" . $this->_groupId . "][" . $option['id'] . "]") .
				 "\" onclick=\"";
  
        // If there are parent elements, add javascript that will
        // make them selecteded when this element is checked to make
        // sure permissions to parent items are added as well.
        foreach ($parentIds as $pid) {
            $parent_ele = $this->getName() . '[groups][' . $this->_groupId . '][' . $pid . ']';
			$parent_ele = str_replace(array('[', ']'), array('_', ''), $parent_ele); // Remove injury characters for ID
            $tree .= "var ele = xoopsGetElementById('" . $parent_ele . "'); if(ele.checked != true) {ele.checked = this.checked;}";
        } 
        // If there are child elements, add javascript that will
        // make them unchecked when this element is unchecked to make
        // sure permissions to child items are not added when there
        // is no permission to this item.
        foreach ($option['allchild'] as $cid) {
            $child_ele = $this->getName() . '[groups][' . $this->_groupId . '][' . $cid . ']';
			$child_ele = str_replace(array('[', ']'), array('_', ''), $child_ele); // Remove injury characters for ID
            $tree .= "var ele = xoopsGetElementById('" . $child_ele . "'); if(this.checked != true) {ele.checked = false;}";
        } 
        $tree .= '" value="1"';
        if (in_array($option['id'], $this->_value)) {
            $tree .= ' checked="checked"';
        } 
        $tree .= " />" . $option['name'] . "<input type=\"hidden\" name=\"" . $this->getName() . "[parents][" . $option['id'] . "]\" value=\"" . implode(':', $parentIds). "\" /><input type=\"hidden\" name=\"" . $this->getName() . "[itemname][" . $option['id'] . "]\" value=\"" . htmlspecialchars($option['name']). "\" /><br />\n";
        if (isset($option['children'])) {
            foreach ($option['children'] as $child) {
                array_push($parentIds, $option['id']);
                $this->_renderOptionTree($tree, $this->_optionTree[$child], $prefix . '&nbsp;-', $parentIds);
            }
        }
    }
	
	/**
	 * Gets a value indicating whether this object has children.
	 * @return bool
	 */
	function _hasChildren()
	{
		return isset($this->_optionTree[0]) && is_array($this->_optionTree[0]['children']);
	}
}
