<?php

class XcoreImageHandler extends XoopsObjectGenericHandler
{
	var $mTable = "image";
	var $mPrimary = "image_id";
	var $mClass = "XcoreImageObject";

	function insert(&$obj, $force = false)
	{
		if (parent::insert($obj, $force)) {
			if (is_object($obj->mImageBody)) {
				$obj->mImageBody->set('image_id', $obj->get('image_id'));
				$handler =& xoops_getmodulehandler('imagebody', 'xcore');
				return $handler->insert($obj->mImageBody, $force);
			}
			
			return true;
		}
		
		return false;
	}
	
	/**
	 *
	 * Delete object and image file.
	 *
	 * @param $obj    XcoreImageObject
	 * @param $force  boolean
	 * @return boolean
	 */	
	function delete(&$obj, $force = false)
	{
		$obj->loadImagebody();
			
		if (parent::delete($obj, $force)) {
			$filepath = XOOPS_UPLOAD_PATH . "/" . $obj->get('image_name');
			if (file_exists($filepath)) {
				@unlink($filepath);
			}
			
			if (is_object($obj->mImageBody)) {
				$handler =& xoops_getmodulehandler('imagebody', 'xcore');
				$handler->delete($obj->mImageBody, $force);
			}
			
			return true;
		}
		
		return false;
	}
}
