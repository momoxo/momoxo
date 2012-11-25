<?php

/**
 * Interface of Image delegate
 * Xcore_Image module must be unique.
 * You can get its dirname by constant XCORE_IMAGE_DIRNAME
**/
interface Xcore_iImageDelegate
{
	/**
	 * createImageObject	Xcore_Image.CreateImageObject
	 * Create new Image Object
	 * must be 'setNew()'.
	 *
	 * @param Xcore_AbstractImageObject	&$obj
	 *
	 * @return	void
	 */ 
	public static function createImageObject(/*** Xcore_AbstractImageObject ***/ &$obj);

	/**
	 * saveImage	Xcore_Image.SaveImage
	 * 1) insert Xcore_AbstractImageObject to database
	 * 2) copy image from upload file($_FILES['xcore_image']) to upload directory
	 * 3) create thumbnail if needed.
	 *
	 * @param bool		&$ret
	 * @param Abstract_ImageObject	$obj
	 *
	 * @return	void
	 */ 
	public static function saveImage(/*** bool ***/ &$ret, /*** Xcore_AbstractImageObject ***/ $obj);

	/**
	 * deleteImage	Xcore_Image.DeleteImage
	 * 1) delete thumbnails
	 * 2) delete image file
	 * 3) delete image data from database
	 *
	 * @param bool		&$ret
	 * @param Abstract_ImageObject	$obj
	 *
	 * @return	void
	 */ 
	public static function deleteImage(/*** bool ***/ &$ret, /*** Xcore_AbstractImageObject ***/ $obj);

	/**
	 * getImageObjects	Xcore_Image.GetImageObjects
	 * return requested image objects
	 *
	 * @param Xcore_AbstractImageObject[]	&$objects
	 * @param string	$dirname	client module dirname
	 * @param string	$dataname	client module dataname
	 * @param int		$dataId		client module primary key
	 * @param int		$num		image serial number in a client data
	 * @param int		$limit		the number of images 
	 * @param int		$start		offset value
	 *
	 * @return	void
	 */ 
	public static function getImageObjects(/*** Xcore_AbstractImageObject[] ***/ &$objects, /*** string ***/ $dirname, /*** string ***/ $dataname, /*** int ***/ $dataId=0, /*** int ***/ $num=0, /*** int ***/ $limit=10, /*** int ***/ $start=0);
}
