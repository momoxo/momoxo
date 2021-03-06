<?php

/**
 * Xcore_AbstractClientObjectHandler
**/
use XCore\Kernel\Ref;
use XCore\Kernel\DelegateUtils;

abstract class Xcore_AbstractClientObjectHandler extends XoopsObjectGenericHandler
{
	protected $_mClientField = array('title'=>'title', 'category'=>'category_id', 'posttime'=>'posttime');
	protected $_mClientConfig = array('tag'=>'tag_dirname', 'image'=>'use_image', 'workflow'=>'use_workflow', 'activity'=>'use_activity', 'map'=>'use_map');

	/**
	 * _getTagList
	 *
	 * @param XoopsSimpleObject	$obj
	 *
	 * @return	string[]
	 */
	protected function _getTagList(/*** XoopsSimpleObject ***/ $obj)
	{
		return $obj->mTag;
	}

	/**
	 * insert data to table
	 *
	 * @param XoopsSimpleObject	$obj
	 * @param bool	$force
	 *
	 * @return	bool
	 */
	public function insert(/*** XoopsSimpleObject ***/ &$obj, /*** bool ***/ $force=false)
	{
		$ret = parent::insert($obj, $force);
		if ($ret == true)
		{
			$ret = $this->_setClientData($obj);
		}
	
		return $ret;
	}

	/**
	 * delete data from table
	 *
	 * @param XoopsSimpleObject	$obj
	 * @param bool	$force
	 *
	 * @return	bool
	 */
	public function delete(/*** XoopsSimpleObject ***/ &$obj, /*** bool ***/ $force=false)
	{
		$ret = parent::delete($obj, $force);
		$this->_deleteClientData($obj);
	
		return $ret;
	}

	/**
	 * set client data: tag, image, activity, workflow
	 *
	 * @param XoopsSimpleObject	$obj
	 *
	 * @return	bool
	 */
	protected function _setClientData(/*** XoopsSimpleObject ***/ $obj)
	{
		$handler = xoops_gethandler('config');
		$conf = $handler->getConfigsByDirname($obj->getDirname());
	
		$ret = true;
		if($this->_isActivityClient($conf)===true){
			if($this->_saveActivity($obj)===false){
				$ret = false;
			}
		}
	
		if($this->_isTagClient($conf)===true){
			if($this->_saveTags($obj, $conf[$this->_mClientConfig['tag']])===false){
				$ret = false;
			}
		}
	
		if($this->_isImageClient($conf)===true){
			if($this->_saveImages($obj)===false){
				$ret = false;
			}
		}
	
		if($this->_isMapClient($conf)===true){
			if($this->_saveMap($obj)===false){
				$ret = false;
			}
		}
	
		return $ret;
	}

	/**
	 * delete client data: tag, activity, workflow, image
	 *
	 * @param XoopsSimpleObject	$obj
	 *
	 * @return	bool
	 */
	protected function _deleteClientData(/*** XoopsSimpleObject ***/ $obj)
	{
		$handler = xoops_gethandler('config');
		$conf = $handler->getConfigsByDirname($obj->getDirname());
	
		$ret = true;
		if($this->_isActivityClient($conf)===true){
			if($this->_deleteActivity($obj)===false){
				$ret = false;
			}
		}
	
		if($this->_isTagClient($conf)===true){
			if($this->_deleteTags($obj, $tagDirname)===false){
				$ret = false;
			}
		}
	
		if($this->_isWorkflowClient($conf)===true){
			$ret = $this->_deleteWorkflow($obj);
		}
	
		if($this->_isImageClient($conf)===true){
			if($this->_deleteImages($obj)===false){
				$ret = false;
			}
		}
		return $ret;
	}

	/**
	 * save activity
	 *
	 * @param XoopsSimpleObject	$obj
	 *
	 * @return	bool
	 */
	protected function _saveActivity(/*** XoopsSimpleObject ***/ $obj)
	{
		$ret = false;
		DelegateUtils::call(
			'Xcore_Activity.AddActivity',
			new Ref($ret),
			$obj->get('uid'),
			$obj->get($this->_mClientField['category']),
			$obj->getDirname(), 
			$this->getDataname(), 
			$obj->get($this->mPrimary),
			$obj->get($this->_mClientField['posttime'])
		);
		return $ret;
	}

	/**
	 * save tags
	 *
	 * @param XoopsSimpleObject	$obj
	 * @param string	$tagDirname
	 *
	 * @return	bool
	 */
	protected function _saveTags(/*** XoopsSimpleObject ***/ $obj, /*** string ***/ $tagDirname)
	{
		$ret = false;
		DelegateUtils::call('Xcore_Tag.'.$tagDirname.'.SetTags',
			new Ref($ret),
			$tagDirname, 
			$obj->getDirname(),
			$this->getDataname(),
			$obj->get($this->mPrimary), 
			$obj->get($this->_mClientField['posttime']), 
			$this->_getTagList($obj)
		);
		return $ret;
	}

	/**
	 * upload and save images
	 *
	 * @param XoopsSimpleObject	$obj
	 *
	 * @return	bool
	 */
	protected function _saveImages(/*** Xcore_AbstractObject ***/ $obj)
	{
		$ret = true;
		$obj->setupImages();
		foreach($obj->mImage as $image){
			$result = false;
			if($image->isDeleted()===true){	//delete image
	        	DelegateUtils::call('Xcore_Image.DeleteImage', new Ref($result), $image);
			}
			else{	//save image
				DelegateUtils::call('Xcore_Image.SaveImage', new Ref($result), $image);
			}
			if($result===false){
				$ret = false;
			}
		}
	
		return $ret;
	}

	/**
	 * save map data
	 *
	 * @param XoopsSimpleObject	$obj
	 *
	 * @return	bool
	 */
    protected function _saveMap($obj)
    {
        $result = array();
        DelegateUtils::call(
        	'Xcore_Map.SetPlace',
        	new Ref($result),
        	$obj->getDirname(), 
        	$obj->getDataname(), 
        	$obj->get($obj->getPrimary()), 
        	$obj->mLatlng, 
        	$obj->get($this->_mClientField['posttime'])
        );
    
        return $result;
    }

	/**
	 * delete activity
	 *
	 * @param XoopsSimpleObject	$obj
	 *
	 * @return	bool
	 */
	protected function _deleteActivity(/*** XoopsSimpleObject ***/ $obj)
	{
		$ret = false;
		DelegateUtils::call('Xcore_Activity.DeleteActivity', new Ref($ret), $obj->getDirname(), $this->getDataname(), $obj->get($this->mPrimary));
		return $ret;
	}

	/**
	 * delete tags
	 *
	 * @param XoopsSimpleObject	$obj
	 * @param string	$tagDirname
	 *
	 * @return	bool
	 */
	protected function _deleteTags(/*** XoopsSimpleObject ***/ $obj, /*** string ***/ $tagDirname)
	{
		$ret = false;
		DelegateUtils::call(
			'Xcore_Tag.'.$tagDirname.'.SetTags',
			new Ref($ret),
			$tagDirname,
			$obj->getDirname(),
			$this->getDataname(),
			$obj->get($this->mPrimary),
			$obj->get($this->_mClientField['posttime']),
			array()
		);
		return $ret;
	}

	/**
	 * delete workflow
	 *
	 * @param XoopsSimpleObject	$obj
	 *
	 * @return	void
	 */
	protected function _deleteWorkflow(/*** XoopsSimpleObject ***/ $obj)
	{
		DelegateUtils::call('Xcore_Workflow.DeleteItem', $obj->getDirname(), $this->getDataname(), $obj->get($this->mPrimary));
	}

	/**
	 * delete images
	 *
	 * @param XoopsSimpleObject	$obj
	 *
	 * @return	bool
	 */
	protected function _deleteImages(/*** XoopsSimpleObject ***/ $obj)
	{
		$ret = true;
		$isPost = false;
		$obj->setupImages($isPost);
		foreach($obj->mImage as $image){
			if(!($image instanceof Xcore_AbstractImageObject)){
				continue;
			}
			$result = false;
			DelegateUtils::call('Xcore_Image.DeleteImage', new Ref($result), $image);
			if($result===false){
				$ret = false;
			}
		}
		return $ret;
	}

	/**
	 * check if use Xcore_Activity
	 *
	 * @param mixed[]	$conf
	 *
	 * @return	bool
	 */
	protected function _isActivityClient(/*** mixed[] ***/ $conf)
	{
		$key ='activity';
		if(! isset($this->_mClientConfig[$key])){
			return false;
		}
		if(! isset($conf[$this->_mClientConfig[$key]])){
			return false;
		}
		return $conf[$this->_mClientConfig[$key]]==1 ? true : false;
	}

	/**
	 * check if use Xcore_Tag
	 *
	 * @param mixed[]	$conf
	 *
	 * @return	bool
	 */
	protected function _isTagClient(/*** mixed[] ***/ $conf)
	{
		$key ='tag';
		if(! isset($this->_mClientConfig[$key])){
			return false;
		}
		if(! isset($conf[$this->_mClientConfig[$key]])){
			return false;
		}
		return $conf[$this->_mClientConfig[$key]] ? true : false;
	}

	/**
	 * check if use Xcore_Workflow
	 *
	 * @param mixed[]	$conf
	 *
	 * @return	bool
	 */
	protected function _isWorkflowClient(/*** mixed[] ***/ $conf)
	{
		$key ='workflow';
		if(! isset($this->_mClientConfig[$key])){
			return false;
		}
		if(! isset($conf[$this->_mClientConfig[$key]])){
			return false;
		}
		return $conf[$this->_mClientConfig[$key]] ? true : false;
	}

	/**
	 * check if use Xcore_Image
	 *
	 * @param mixed[]	$conf
	 *
	 * @return	bool
	 */
	protected function _isImageClient(/*** mixed[] ***/ $conf)
	{
		$key ='image';
		if(! isset($this->_mClientConfig[$key])){
			return false;
		}
		if(! isset($conf[$this->_mClientConfig[$key]])){
			return false;
		}
		return $conf[$this->_mClientConfig[$key]] ? true : false;
	}

    /**
     * check if use Xcore_Map
     *
     * @param mixed[]   $conf
     *
     * @return  bool
     */
    protected function _isMapClient(/*** mixed[] ***/ $conf)
    {
		$key ='map';
		if(! isset($this->_mClientConfig[$key])){
			return false;
		}
		if(! isset($conf[$this->_mClientConfig[$key]])){
			return false;
		}
		return $conf[$this->_mClientConfig[$key]]==1 ? true : false;
	}

	/**
	 * get client field name
	 *
	 * @param string	$key
	 *
	 * @return	string
	 */
	public function getClientField(/*** string ***/ $key)
	{
		return $this->_mClientField[$key];
	}
}
