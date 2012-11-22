<?php

class XoopsTplset extends XoopsObject
{

	function XoopsTplset()
	{
		static $initVars;
		if (isset($initVars)) {
			$this->vars = $initVars;
			return;
		}
		$this->XoopsObject();
		$this->initVar('tplset_id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('tplset_name', XOBJ_DTYPE_OTHER, null, false);
		$this->initVar('tplset_desc', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('tplset_credits', XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('tplset_created', XOBJ_DTYPE_INT, 0, false);
		$initVars = $this->vars;
	}
}

/**
* XOOPS tplset handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS tplset class objects.
*
*
* @author  Kazumi Ono <onokazu@xoops.org>
*/

class XoopsTplsetHandler extends XoopsObjectHandler
{

    function &create($isNew = true)
    {
        $tplset =new XoopsTplset();
        if ($isNew) {
            $tplset->setNew();
        }
        return $tplset;
    }

    function &get($id)
    {
        $ret = false;
        $id = (int)$id;
        if ($id > 0) {
            $sql = 'SELECT * FROM '.$this->db->prefix('tplset').' WHERE tplset_id='.$id;
            if ($result = $this->db->query($sql)) {
                $numrows = $this->db->getRowsNum($result);
                if ($numrows == 1) {
                    $tplset = new XoopsTplset();
                    $tplset->assignVars($this->db->fetchArray($result));
                        $ret =& $tplset;
                }
            }
        }
        return $ret;
    }

    function &getByName($tplset_name)
    {
        $ret = false;
        $tplset_name = trim($tplset_name);
        if ($tplset_name != '') {
            $sql = 'SELECT * FROM '.$this->db->prefix('tplset').' WHERE tplset_name='.$this->db->quoteString($tplset_name);
            if ($result = $this->db->query($sql)) {
                $numrows = $this->db->getRowsNum($result);
                if ($numrows == 1) {
                        $tplset =new XoopsTplset();
                    $tplset->assignVars($this->db->fetchArray($result));
                        $ret =& $tplset;
                }
            }
        }
        return $ret;
    }

    function insert(&$tplset)
    {
        if (strtolower(get_class($tplset)) != 'xoopstplset') {
            return false;
        }
        if (!$tplset->isDirty()) {
            return true;
        }
        if (!$tplset->cleanVars()) {
            return false;
        }
        foreach ($tplset->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        if ($tplset->isNew()) {
            $tplset_id = $this->db->genId('tplset_tplset_id_seq');
            $sql = sprintf("INSERT INTO %s (tplset_id, tplset_name, tplset_desc, tplset_credits, tplset_created) VALUES (%u, %s, %s, %s, %u)", $this->db->prefix('tplset'), $tplset_id, $this->db->quoteString($tplset_name), $this->db->quoteString($tplset_desc), $this->db->quoteString($tplset_credits), $tplset_created);
        } else {
            $sql = sprintf("UPDATE %s SET tplset_name = %s, tplset_desc = %s, tplset_credits = %s, tplset_created = %u WHERE tplset_id = %u", $this->db->prefix('tplset'), $this->db->quoteString($tplset_name), $this->db->quoteString($tplset_desc), $this->db->quoteString($tplset_credits), $tplset_created, $tplset_id);
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        if (empty($tplset_id)) {
            $tplset_id = $this->db->getInsertId();
        }
		$tplset->assignVar('tplset_id', $tplset_id);
        return true;
    }

    function delete(&$tplset)
    {
        if (strtolower(get_class($tplset)) != 'xoopstplset') {
            return false;
        }
        $sql = sprintf("DELETE FROM %s WHERE tplset_id = %u", $this->db->prefix('tplset'), $tplset->getVar('tplset_id'));
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $sql = sprintf("DELETE FROM %s WHERE tplset_name = %s", $this->db->prefix('imgset_tplset_link'), $this->db->quoteString($tplset->getVar('tplset_name')));
        $this->db->query($sql);
        return true;
    }

    function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret = array();
        $limit = $start = 0;
        $sql = 'SELECT * FROM '.$this->db->prefix('tplset');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere().' ORDER BY tplset_id';
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }
        while ($myrow = $this->db->fetchArray($result)) {
            $tplset =new XoopsTplset();
            $tplset->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] =& $tplset;
            } else {
                $ret[$myrow['tplset_id']] =& $tplset;
            }
            unset($tplset);
        }
        return $ret;
    }


    function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('tplset');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (!$result =& $this->db->query($sql)) {
            return 0;
        }
        list($count) = $this->db->fetchRow($result);
        return $count;
    }

    function &getList($criteria = null)
	{
        $ret = array();
		$tplsets =& $this->getObjects($criteria, true);
		foreach ($tplsets as $tpl) {
			$name = $tpl->getVar('tplset_name');
            $ret[$name] = $name;
        }
		return $ret;
	}
}
