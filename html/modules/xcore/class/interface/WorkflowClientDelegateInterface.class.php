<?php

/**
 * Interface of workflow client delegate
 * Modules which uses Xcore_Workflow must implement this interface.
 * Xcore_Workflow module must be unique.
 * You can get its dirname by constant XCORE_WORKFLOW_DIRNAME
**/
interface Xcore_iWorkflowClientDelegate
{
	/**
	 * getClientList	Xcore_WorkflowClient.GetClientList
	 * Get client module's dirname and dataname(tablename)
	 *
	 * @param mixed[]	&$list
	 *  $list[]['dirname']	client module dirname
	 *  $list[]['dataname']	client module dataname(tablename)
	 *
	 * @return	void
	 */ 
	public static function getClientList(/*** mixed[] ***/ &$list);

	/**
	 * updateStatus Xcore_WorkflowClient.UpdateStatus
	 * Update client module's status(publish, rejected, etc).
	 *
	 * @param string	&$result
	 * @param string	$dirname	client module dirname
	 * @param string	$dataname	client module dataname(tablename)
	 * @param int		$data_id	client module primary key
	 * @param Enum		$status Lenum_WorkflowStatus
	 *
	 * @return	void
	 */ 
	public static function updateStatus(/*** string ***/ &$result, /*** string ***/ $dirname, /*** string ***/ $dataname, /*** int ***/ $data_id, /*** Enum ***/ $status);
}

