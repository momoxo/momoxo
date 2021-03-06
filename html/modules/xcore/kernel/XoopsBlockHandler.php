<?php

/**
 * XOOPS block handler class. (Singelton)
 *
 * This class is responsible for providing data access mechanisms to the data source
 * of XOOPS block class objects.
 *
 * @author  Kazumi Ono <onokazu@xoops.org>
 * @copyright copyright (c) 2000 XOOPS.org
 * @package kernel
 * @subpackage block
*/
use XCore\Kernel\Root;

class XoopsBlockHandler extends XoopsObjectHandler
{

    /**
     * create a new block
     *
     * @see XoopsBlock
     * @param bool $isNew is the new block new??
     * @return object XoopsBlock reference to the new block
     **/
    function &create($isNew = true)
    {
        $block = new XoopsBlock();
        if ($isNew) {
            $block->setNew();
        }
        return $block;
    }

	/**
	 * Create a new block by array that is defined in xoops_version. You must 
	 * be careful that the value that it is returned doesn't have $mid, $func_num
	 * and $dirname.
	 *
	 * @param $info array
	 * @return object XoopsBlock
	 */
	function &createByInfo($info)
	{
		$block =& $this->create();

		$options=isset($info['options']) ? $info['options'] : null;
		$edit_func=isset($info['edit_func']) ? $info['edit_func'] : null;

		$block->setVar('options',$options);
		$block->setVar('name',$info['name']);
		$block->setVar('title',$info['name']);
		$block->setVar('block_type','M');
		$block->setVar('c_type',1);
		$block->setVar('func_file',$info['file']);
		$block->setVar('show_func',$info['show_func']);
		$block->setVar('edit_func',$edit_func);
		$block->setVar('template',$info['template']);
		$block->setVar('last_modified',time());

		return $block;
	}

    /**
     * retrieve a specific {@link XoopsBlock}
     *
     * @see XoopsBlock
     * @param int $id bid of the block to retrieve
     * @return object XoopsBlock reference to the block
     **/
    function &get($id)
    {
        $id = (int)$id;
        if ($id > 0) {
			$db = $this->db;
            $sql = 'SELECT * FROM '.$db->prefix('newblocks').' WHERE bid='.$id;
            if (!$result = $db->query($sql)) {
				$ret = false;	//< You may think this should be null. But this is the compatibility with X2.
				return $ret;
            }
            $numrows = $db->getRowsNum($result);
            if ($numrows == 1) {
                $block = new XoopsBlock();
                $block->assignVars($db->fetchArray($result));
                return $block;
            }
        }
		
		$ret = false;	//< You may think this should be null. But this is the compatibility with X2.
        return $ret;
    }

    /**
     * write a new block into the database
     *
     * @param object XoopsBlock $block reference to the block to insert
     * @param $autolink temp
     * @return bool TRUE if succesful
     **/
    function insert(&$block, $autolink=false)
    {
        if (strtolower(get_class($block)) != 'xoopsblock') {
            return false;
        }
        if (!$block->isDirty()) {
            return true;
        }
        if (!$block->cleanVars()) {
            return false;
        }
        foreach ($block->cleanVars as $k => $v) {
            ${$k} = $v;
        }
		
		$isNew = false;
		
		$db = $this->db;
        if ($block->isNew()) {
			if(intval($weight) == 0){
				$weight = 100;
			}
			$isNew = true;
            $bid = $db->genId('newblocks_bid_seq');
            $sql = sprintf('INSERT INTO %s (bid, mid, func_num, options, name, title, content, side, weight, visible, block_type, c_type, isactive, dirname, func_file, show_func, edit_func, template, bcachetime, last_modified) VALUES (%u, %u, %u, %s, %s, %s, %s, %u, %u, %u, %s, %s, %u, %s, %s, %s, %s, %s, %u, %u)', $db->prefix('newblocks'), $bid, $mid, $func_num, $db->quoteString($options), $db->quoteString($name), $db->quoteString($title), $db->quoteString($content), $side, $weight, $visible, $db->quoteString($block_type), $db->quoteString($c_type), 1, $db->quoteString($dirname), $db->quoteString($func_file), $db->quoteString($show_func), $db->quoteString($edit_func), $db->quoteString($template), $bcachetime, time());
        } else {
            $sql = sprintf('UPDATE %s SET func_num = %u, options = %s, name = %s, title = %s, content = %s, side = %u, weight = %u, visible = %u, c_type = %s, isactive = %u, func_file = %s, show_func = %s, edit_func = %s, template = %s, bcachetime = %u, last_modified = %u WHERE bid = %u', $db->prefix('newblocks'), $func_num, $db->quoteString($options), $db->quoteString($name), $db->quoteString($title), $db->quoteString($content), $side, $weight, $visible, $db->quoteString($c_type), $isactive, $db->quoteString($func_file), $db->quoteString($show_func), $db->quoteString($edit_func), $db->quoteString($template), $bcachetime, time(), $bid);
        }
        if (!$result = $db->query($sql)) {
            return false;
        }
        if (empty($bid)) {
            $bid = $db->getInsertId();
        }
        $block->assignVar('bid', $bid);

		//
		// $autolink is temp variable.
		//
		if ($isNew && $autolink) {
			$link_sql = 'INSERT INTO ' . $db->prefix('block_module_link') . ' (block_id, module_id) VALUES ('.$bid.', -1)';
			return $db->query($link_sql);
		}

        return true;
    }

    /**
     * delete a block from the database
     *
     * @param object XoopsBlock $block reference to the block to delete
     * @return bool TRUE if succesful
     **/
    function delete(&$block)
    {
        if (strtolower(get_class($block)) != 'xoopsblock') {
            return false;
        }
        $id = $block->get('bid');
		$db = $this->db;
        $sql = sprintf('DELETE FROM %s WHERE bid = %u', $db->prefix('newblocks'), $id);
        if (!$result = $db->query($sql)) {
            return false;
        }
        $sql = sprintf('DELETE FROM %s WHERE block_id = %u', $db->prefix('block_module_link'), $id);
        $db->query($sql);
        return true;
    }

    /**
     * retrieve array of {@link XoopsBlock}s meeting certain conditions
     * @param object $criteria {@link CriteriaElement} with conditions for the blocks
     * @param bool $id_as_key should the blocks' bid be the key for the returned array?
     * @return array {@link XoopsBlock}s matching the conditions
     **/
    function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret = array();
        $limit = $start = 0;
        $sql = 'SELECT DISTINCT(b.*) FROM '.$this->db->prefix('newblocks').' b LEFT JOIN '.$this->db->prefix('block_module_link').' l ON b.bid=l.block_id';
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }
        while ($myrow = $this->db->fetchArray($result)) {
            $block =& $this->create(false);
            $block->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] =& $block;
            } else {
                $ret[$myrow['bid']] =& $block;
            }
            unset($block);
        }
        return $ret;
    }
    
	function &getObjectsDirectly($criteria = null)
	{
		$ret = array();
		$limit = 0;
		$start = 0;

		$sql = 'SELECT * FROM ' . $this->db->prefix('newblocks');
		if ($criteria)
			$sql .= ' ' . $criteria->renderWhere();
		
		$result = $this->db->query($sql);
		if (!$result) {
			return $ret;
		}

		while ($row = $this->db->fetchArray($result)) {
			$block =& $this->create(false);
			$block->assignVars($row);
			
			$ret[] =& $block;
			
			unset($block);
		}
		
		return $ret;
	}


    /**
     * get a list of blocks matchich certain conditions
     *
     * @param string $criteria conditions to match
     * @return array array of blocks matching the conditions
     **/
    function &getList($criteria = null)
    {
        $blocks =& $this->getObjects($criteria, true);
        $ret = array();
        foreach (array_keys($blocks) as $i) {
            $name = ($blocks[$i]->get('block_type') != 'C') ? $blocks[$i]->getVar('name') : $blocks[$i]->getVar('title');
            $ret[$i] = $name;
        }
        return $ret;
    }

    /**
    * get all the blocks that match the supplied parameters
    * @param $side   0: sideblock - left
    *        1: sideblock - right
    *        2: sideblock - left and right
    *        3: centerblock - left
    *        4: centerblock - right
    *        5: centerblock - center
    *        6: centerblock - left, right, center
    * @param $groupid   groupid (can be an array)
    * @param $visible   0: not visible 1: visible
    * @param $orderby   order of the blocks
    * @returns array of block objects
    */
    function &getAllBlocksByGroup($groupid, $asobject=true, $side=null, $visible=null, $orderby='b.weight,b.bid', $isactive=1)
    {
        $ret = array();
        if ( !$asobject ) {
            $sql = 'SELECT b.bid ';
        } else {
            $sql = 'SELECT b.* ';
        }
        $sql .= 'FROM '.$this->db->prefix('newblocks').' b LEFT JOIN '.$this->db->prefix('group_permission').' l ON l.gperm_itemid=b.bid WHERE gperm_name = \'block_read\' AND gperm_modid = 1';
        if ( is_array($groupid) ) {
            $sql .= ' AND (l.gperm_groupid='.(int)$groupid[0];
            $size = count($groupid);
            if ( $size  > 1 ) {
                for ( $i = 1; $i < $size; $i++ ) {
                    $sql .= ' OR l.gperm_groupid='.(int)$groupid[$i];
                }
            }
            $sql .= ')';
        } else {
            $sql .= ' AND l.gperm_groupid='.(int)$groupid;
        }
        $sql .= ' AND b.isactive='.(int)$isactive;
        if ( isset($side) ) {
            $side = (int)$side;
            // get both sides in sidebox? (some themes need this)
            if ( $side == XOOPS_SIDEBLOCK_BOTH ) {
                $side = '(b.side=0 OR b.side=1)';
            } elseif ( $side == XOOPS_CENTERBLOCK_ALL ) {
                $side = '(b.side=3 OR b.side=4 OR b.side=5)';
            } else {
                $side = 'b.side='.$side;
            }
            $sql .= ' AND '.$side;
        }
        if ( isset($visible) ) {
            $sql .= ' AND b.visible='.(int)$visible;
        }
        $sql .= ' ORDER BY '.addslashes($orderby);
        $result = $this->db->query($sql);
        $added = array();
        while ( $myrow = $this->db->fetchArray($result) ) {
            if ( !in_array($myrow['bid'], $added) ) {
                if (!$asobject) {
                    $ret[] = $myrow['bid'];
                } else {
                    $block =& $this->create(false);
                    $block->assignVars($myrow);
                    $ret[] =& $block;
                }
                array_push($added, $myrow['bid']);
            }
        }
        return $ret;
    }
    function &getAllBlocks($rettype='object', $side=null, $visible=null, $orderby='side,weight,bid', $isactive=1)
    {
        $ret = array();
        $where_query = ' WHERE isactive='.(int)$isactive;
        if ( isset($side) ) {
            $side = (int)$side;
            // get both sides in sidebox? (some themes need this)
            if ( $side == 2 ) {
                $side = '(side=0 OR side=1)';
            } elseif ( $side == 6 ) {
                $side = '(side=3 OR side=4 OR side=5)';
            } else {
                $side = 'side='.$side;
            }
            $where_query .= ' AND '.$side;
        }
        if ( isset($visible) ) {
            $visible = (int)$visible;
            $where_query .= ' AND visible='.$visible;
        }
        $where_query .= ' ORDER BY '.addslashes($orderby);
        switch ($rettype) {
        case 'object':
            $sql = 'SELECT * FROM '.$this->db->prefix('newblocks').$where_query;
            $result = $this->db->query($sql);
            while ( $myrow = $this->db->fetchArray($result) ) {
                $block =& $this->create(false);
                $block->assignVars($myrow);
                $ret[] =& $block;
            }
            break;
        case 'list':
            $sql = 'SELECT * FROM '.$this->db->prefix('newblocks').$where_query;
            $result = $this->db->query($sql);
            while ( $myrow = $this->db->fetchArray($result) ) {
                $block =& $this->create(false);
                $block->assignVars($myrow);
                $name = ($block->get('block_type') != 'C') ? $block->getVar('name') : $block->getVar('title');
                $ret[$block->getVar('bid')] = $name;
                unset($block);
            }
            break;
        case 'id':
            $sql = 'SELECT bid FROM '.$this->db->prefix('newblocks').$where_query;
            $result = $this->db->query($sql);
            while ( $myrow = $this->db->fetchArray($result) ) {
                $ret[] = $myrow['bid'];
            }
            break;
        }
        //echo $sql;
        return $ret;
    }

    function &getByModule($moduleid, $asobject=true)
    {
        $moduleid = (int)$moduleid;
        if ( $asobject == true ) {
            $sql = $sql = 'SELECT * FROM '.$this->db->prefix('newblocks').' WHERE mid='.$moduleid;
        } else {
            $sql = 'SELECT bid FROM '.$this->db->prefix('newblocks').' WHERE mid='.$moduleid;
        }
        $result = $this->db->query($sql);
        $ret = array();
        while( $myrow = $this->db->fetchArray($result) ) {
            if ( $asobject ) {
                $block =& $this->create(false);
                $block->assignVars($myrow);
                $ret[] =& $block;
            } else {
                $ret[] = $myrow['bid'];
            }
        }
        return $ret;
    }

	/**
	 * Gets block objects by groups & modules.
	 * @remark This is the special API for base modules like Xcore.
	 */
    function &getAllByGroupModule($groupid, $module_id=0, $toponlyblock=false, $visible=null, $orderby='b.weight,b.bid', $isactive=1)
    {
        $ret = array();
		$db = $this->db;
        $sql = 'SELECT DISTINCT gperm_itemid FROM '.$db->prefix('group_permission').' WHERE gperm_name = \'block_read\' AND gperm_modid = 1';
        if ( is_array($groupid) ) {
            $sql .= ' AND gperm_groupid IN ('.addslashes(implode(',', array_map('intval', $groupid))).')';
        } else {
			$groupid = (int)$groupid;
			if ($groupid > 0) {
                $sql .= ' AND gperm_groupid='.$groupid;
            }
        }
        $result = $db->query($sql);
        $blockids = array();
        while ( $myrow = $db->fetchArray($result) ) {
            $blockids[] = $myrow['gperm_itemid'];
        }
        if (!empty($blockids)) {
            $sql = 'SELECT b.* FROM '.$db->prefix('newblocks').' b, '.$db->prefix('block_module_link').' m WHERE m.block_id=b.bid';
            $sql .= ' AND b.isactive='.$isactive;
            if (isset($visible)) {
                $sql .= ' AND b.visible='.(int)$visible;
            }
            if ($module_id !== false) {
                $sql .= ' AND m.module_id IN (0,'.(int)$module_id;
                if ($toponlyblock) {
                    $sql .= ',-1';
                }
                $sql .= ')';
            } else {
                if ($toponlyblock) {
                    $sql .= ' AND m.module_id IN (0,-1)';
                } else {
                    $sql .= ' AND m.module_id=0';
                }
            }
            $sql .= ' AND b.bid IN ('.implode(',', $blockids).')';
            $sql .= ' ORDER BY '.$orderby;
            $result = $db->query($sql);
            while ( $myrow = $db->fetchArray($result) ) {
                $block =& $this->create(false);
                $block->assignVars($myrow);
                $ret[$myrow['bid']] =& $block;
                unset($block);
            }
        }
        return $ret;
    }

	/**
	 * Return block instance array by $groupid, $mid and $blockFlag.
	 * This function is new function of Cube and used from controller.
	 * @remark This is the special API for base modules like Xcore.
	 **/
	function &getBlocks($groupid, $mid=false, $blockFlag=SHOW_BLOCK_ALL, $orderby='b.weight,b.bid')
    {
        $root = Root::getSingleton();
        $db = $this->db =& $root->mController->getDB();

        $ret = array();
        $sql = 'SELECT DISTINCT gperm_itemid FROM '.$db->prefix('group_permission').' WHERE gperm_name = \'block_read\' AND gperm_modid = 1';
        if ( is_array($groupid) ) {
            $sql .= ' AND gperm_groupid IN ('.addslashes(implode(',', array_map('intval', $groupid))).')';
        } else {
	    $groupid = (int)$groupid;
            if ($groupid > 0) {
                $sql .= ' AND gperm_groupid='.$groupid;
            }
        }
        $result = $db->query($sql);
        $blockids = array();
        while ( list($itemid) = $db->fetchRow($result) ) {
            $blockids[] = $itemid;
        }
        if (!empty($blockids)) {
            $sql = 'SELECT b.* FROM '.$db->prefix('newblocks').' b, '.$db->prefix('block_module_link').' m WHERE m.block_id=b.bid';
            $sql .= ' AND b.isactive=1 AND b.visible=1';
            if ($mid !== false && $mid !== 0) {
                $sql .= ' AND m.module_id IN (0,'.(int)$mid.')';
            } else {
                $sql .= ' AND m.module_id=0';
            }
            
            //
            // SIDE
            //
            if ($blockFlag != SHOW_BLOCK_ALL) {
				$arr = array();
				if ($blockFlag & SHOW_SIDEBLOCK_LEFT) {
					$arr[] = 'b.side=' . $this->mBlockFlagMapping[SHOW_SIDEBLOCK_LEFT];
				}
				if ($blockFlag & SHOW_SIDEBLOCK_RIGHT) {
					$arr[] = 'b.side=' . $this->mBlockFlagMapping[SHOW_SIDEBLOCK_RIGHT];
				}
				if ($blockFlag & SHOW_CENTERBLOCK_LEFT) {
					$arr[] = 'b.side=' . $this->mBlockFlagMapping[SHOW_CENTERBLOCK_LEFT];
				}
				if ($blockFlag & SHOW_CENTERBLOCK_CENTER) {
					$arr[] = 'b.side=' . $this->mBlockFlagMapping[SHOW_CENTERBLOCK_CENTER];
				}
				if ($blockFlag & SHOW_CENTERBLOCK_RIGHT) {
					$arr[] = 'b.side=' . $this->mBlockFlagMapping[SHOW_CENTERBLOCK_RIGHT];
				}
				
				$sql .= ' AND (' . implode(' OR ', $arr) . ')';
			}

			$sql .= ' AND b.bid IN ('.implode(',', $blockids).')' . ' ORDER BY '.addslashes($orderby);
            $result = $db->query($sql);
            while ( $myrow = $db->fetchArray($result) ) {
                $block =& $this->create(false);
                $block->assignVars($myrow);
                $ret[$myrow['bid']] =& $block;
                unset($block);
            }
        }
        return $ret;
    }

	/**
	 * @remark This is the special API for base modules like Xcore.
	 */
    function &getNonGroupedBlocks($module_id=0, $toponlyblock=false, $visible=null, $orderby='b.weight,b.bid', $isactive=1)
    {
        $ret = array();
        $bids = array();
		$db = $this->db;
        $sql = 'SELECT DISTINCT(bid) from '.$db->prefix('newblocks');
        if ($result = $db->query($sql)) {
            while ( $myrow = $db->fetchArray($result) ) {
                $bids[] = $myrow['bid'];
            }
        }
        $sql = 'SELECT DISTINCT(p.gperm_itemid) from '.$db->prefix('group_permission').' p, '.$db->prefix('groups').' g WHERE g.groupid=p.gperm_groupid AND p.gperm_name=\'block_read\'';
        $grouped = array();
        if ($result = $db->query($sql)) {
            while ( $myrow = $db->fetchArray($result) ) {
                $grouped[] = $myrow['gperm_itemid'];
            }
        }
        $non_grouped = array_diff($bids, $grouped);
        if (!empty($non_grouped)) {
            $sql = 'SELECT b.* FROM '.$db->prefix('newblocks').' b, '.$db->prefix('block_module_link').' m WHERE m.block_id=b.bid';
            $sql .= ' AND b.isactive='.(int)$isactive;
            if (isset($visible)) {
                $sql .= ' AND b.visible='.(int)$visible;
            }
            $module_id = (int)$module_id;
            if (!empty($module_id)) {
                $sql .= ' AND m.module_id IN (0,'.$module_id.($toponlyblock?',-1)':')');
            } else {
                if ($toponlyblock) {
                    $sql .= ' AND m.module_id IN (0,-1)';
                } else {
                    $sql .= ' AND m.module_id=0';
                }
            }
            $sql .= ' AND b.bid IN ('.implode(',', $non_grouped).')';
            $sql .= ' ORDER BY '.addslashes($orderby);
            $result = $db->query($sql);
            while ( $myrow = $db->fetchArray($result) ) {
                $block =& $this->create(false);
                $block->assignVars($myrow);
                $ret[$myrow['bid']] =& $block;
                unset($block);
            }
        }
        return $ret;
    }

    function countSimilarBlocks($moduleId, $funcNum, $showFunc = null)
    {
        $funcNum = (int)$funcNum;
        $moduleId = (int)$moduleId;
        if ($funcNum < 1 || $moduleId < 1) {
            // invalid query
            return 0;
        }
		$db = $this->db;
        if (isset($showFunc)) {
            // showFunc is set for more strict comparison
            $sql = sprintf('SELECT COUNT(*) FROM %s WHERE mid = %d AND func_num = %d AND show_func = %s', $db->prefix('newblocks'), $moduleId, $funcNum, $db->quoteString(trim($showFunc)));
        } else {
            $sql = sprintf('SELECT COUNT(*) FROM %s WHERE mid = %d AND func_num = %d', $db->prefix('newblocks'), $moduleId, $funcNum);
        }
        if (!$result = $db->query($sql)) {
            return 0;
        }
        list($count) = $db->fetchRow($result);
        return $count;
    }
    
    /**
     * Changes 'isactive' value of the module specified by $moduleId.
     * @remark This method should be called by only the base modules like Xcore.
     */
    function syncIsActive($moduleId, $isActive, $force = false)
    {
		$db = $this->db;
    	$db->prepare('UPDATE ' . $db->prefix('newblocks') . ' SET isactive=? WHERE mid=?');
    	$db->bind_param('ii', $isActive, $moduleId);
    	
    	if ($force) {
			$db->executeF();
    	}
    	else {
			$db->execute();
    	}
    }
}
