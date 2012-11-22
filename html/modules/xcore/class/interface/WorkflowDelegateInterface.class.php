<?php

/**
 * Interface of workflow delegate
 * Xcore_Workflow module must be unique.
 * You can get its dirname by constant XCORE_WORKFLOW_DIRNAME
**/
interface Xcore_iWorkflowDelegate
{
	/**
	 * addItem	Xcore_Workflow.AddItem
	 *
	 * @param string $title
	 * @param string $dirname	client module dirname
	 * @param string $dataname	client module dataname
	 * @param int	 $data_id	client module primary key
	 * @param string $url		client data's uri
	 *
	 * @return	void
	 */ 
	public static function addItem(/*** string ***/ $title, /*** string ***/ $dirname, /*** string ***/ $dataname, /*** int ***/ $data_id, /*** string ***/ $url);

	/**
	 * deleteItem	Xcore_Workflow.DeleteItem
	 *
	 * @param string $dirname	client module dirname
	 * @param string $dataname	client module dataname
	 * @param int	 $data_id	client module primary key
	 *
	 * @return	void
	 */ 
	public static function deleteItem(/*** string ***/ $dirname, /*** string ***/ $dataname, /*** int ***/ $data_id);

	/**
	 * getHistory	Xcore_Workflow.GetHistory
	 *
	 * @param mix[] &$historyArr
	 *	$hisotryArr['step']
	 *	$hisotryArr['uid']
	 *	$hisotryArr['result']
	 *	$hisotryArr['comment']
	 *	$hisotryArr['posttime']
	 * @param string $dirname	client module dirname
	 * @param string $dataname	client module dataname
	 * @param int	 $data_id	client module primary key
	 *
	 * @return	void
	 */ 
	public static function getHistory(/*** mix[] ***/ &$historyArr, /*** string ***/ $dirname, /*** string ***/ $dataname, /*** int ***/ $data_id);
}

