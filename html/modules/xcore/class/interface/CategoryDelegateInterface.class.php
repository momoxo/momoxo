<?php

/**
 * Interface of category delegate
**/
interface Xcore_iCategoryDelegate
{
	/**
	 * getTitle		Xcore_Category.{dirname}.GetTitle
	 *
	 * @param string 	&$title	category title
	 * @param string 	$catDir	category module's directory name
	 * @param int 		$catId	category id
	 *
	 * @return	void
	 */ 
	public static function getTitle(/*** string ***/ &$title, /*** string ***/ $catDir, /*** int ***/ $catId);

	/**
	 * getTree	Xcore_Category.{dirname}.GetTree
	 * Get category Xcore_AbstractCategoryObject array in parent-child tree order
	 *
	 * @param Xcore_AbstractCategoryObject[] $tree
	 * @param string $catDir	category module's dirname
	 * @param string 	$authType	ex) viewer, editor, manager
	 * @param int 		$catId	get tree under this cat_id
	 * @param string	$module module confinement
	 *
	 * @return	void
	 */ 
	public static function getTree(/*** Xcore_AbstractCategoryObject[] ***/ &$tree, /*** string ***/ $catDir, /*** string ***/ $authType, /*** int ***/ $catId=0, /*** string ***/ $module=null);

	/**
	 * getTitleList		Xcore_Category.{dirname}.GetTitleList
	 *
	 * @param string &$titleList	category title array
	 * @param string $catDir	category module's dirname
	 *
	 * @return	void
	 */ 
	public static function getTitleList(/*** string[] ***/ &$titleList, /*** string ***/ $catDir);

	/**
	 * hasPermission	Xcore_Category.{dirname}.HasPermission
	 *
	 * @param bool &$check
	 * @param string	$catDir	category module's dirname
	 * @param int		$catId	category id
	 * @param string	$authType	ex) viewer, editor, manager
	 * @param string	$module	module confinement
	 *
	 * @return	void
	 */ 
	public static function hasPermission(/*** bool ***/ &$check, /*** string ***/ $catDir, /*** int ***/ $catId, /*** string ***/ $authType, /*** string ***/ $module=null);

	/**
	 * getParent		Xcore_Category.{dirname}.GetParent
	 * get the parent category object.
	 *
	 * @param Xcore_AbstractCategoryObject &$parent
	 * @param string 	$catDir	category module's dirname
	 * @param int 		$catId	category id
	 *
	 * @return	void
	 */ 
	public static function getParent(/*** Xcore_AbstractCategoryObject ***/ &$parent, /*** string ***/ $catDir, /*** int ***/ $catId);

	/**
	 * getChildren		Xcore_Category.{dirname}.GetChildren
	 * get the child category objects. Be careful that you can get only children objects, excluded the given category itself.
	 *
	 * @param Xcore_AbstractCategoryObject[] &$children
	 * @param string	$catDir	category module's dirname
	 * @param int		$catId	the parent's category id
	 * @param string	$authType	ex) viewer, editor, manager
	 * @param string	$module	 module confinement
	 *
	 * @return	void
	 */ 
	public static function getChildren(/*** Xcore_AbstractCategoryObject[] ***/ &$children, /*** string ***/ $catDir, /*** int ***/ $catId, /*** string ***/ $authType, /*** string ***/ $module=null);

	/**
	 * getCatPath		Xcore_Category.{dirname}.GetCatPath
	 * get category path array from top to the given category.
	 *
	 * @param string[] &$catPath
	 *	 $catPath['cat_id']
	 *	 $catPath['title']
	 * @param string $catDir	category module's dirname
	 * @param int $catId		terminal category id in the category path
	 * @param string $order		'ASC' or 'DESC'
	 *
	 * @return	void
	 */ 
	public static function getCatPath(/*** array ***/ &$catPath, /*** string ***/ $catDir, /*** int ***/ $catId, /*** string ***/ $order='ASC');

	/**
	 * getPermittedIdList		Xcore_Category.{dirname}.GetPermittedIdList
	 * get category ids of permission.
	 *
	 * @param int[]		&$idList
	 * @param string	$catDir	category module's dirname
	 * @param string	$authType	ex) viewer, editor, manager
	 * @param int		$uid
	 * @param int		$catId	get result under this cat_id
	 * @param string	$module	 module confinement
	 *
	 * @return	void
	 */ 
	public static function getPermittedIdList(/*** int[] ***/ &$idList, /*** string ***/ $catDir, /*** string ***/ $authType, /*** int ***/ $uid, /*** int ***/ $catId=0, /*** string ***/ $module=null);

}

