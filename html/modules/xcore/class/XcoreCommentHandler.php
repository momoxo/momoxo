<?php

use XCore\Kernel\Delegate;

class XcoreCommentHandler extends XoopsObjectGenericHandler
{
	var $mTable = "xoopscomments";
	var $mPrimary = "com_id";
	var $mClass = "XcoreCommentObject";

	/**
	 * @var Delegate
	 */	
	var $mUpdateSuccess;
	
	/**
	 * @var Delegate
	 */	
	var $mDeleteSuccess;
	
	function XcoreCommentHandler(&$db)
	{
		parent::XoopsObjectGenericHandler($db);
		
		$this->mUpdateSuccess =new Delegate();
		$this->mDeleteSuccess =new Delegate();
	}
	
	function insert(&$comment, $force = false)
	{
		if (parent::insert($comment, $force)) {
			$this->mUpdateSuccess->call($comment);
			return true;
		}
		else {
			return false;
		}
	}
	
	/**
	 * Delete $comment and childlen of $comment.
	 */
	function delete(&$comment, $force = false)
	{
		$criteria =new Criteria('com_pid', $comment->get('com_id'));
		$this->deleteAll($criteria);
		
		if (parent::delete($comment, $force)) {
			$this->mDeleteSuccess->call($comment);
			return true;
		}
		else{
			return false;
		}
	}

	/**
	 * 
	 * Return array of module id that comments are written.
	 * 
	 * @return array
	 */	
	function getModuleIds()
	{
		$ret = array();

		$sql = "SELECT DISTINCT com_modid FROM " . $this->mTable;
		$res = $this->db->query($sql);
		if ($res) {
			while ($row = $this->db->fetchArray($res)) {
				$ret[] = $row['com_modid'];
			}
		}
		
		return $ret;
	}
}
