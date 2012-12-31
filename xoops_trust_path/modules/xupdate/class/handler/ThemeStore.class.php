<?php
use XCore\Kernel\Root;
use XCore\Repository\ObjectGenericRepository;
use XCore\Entity\SimpleObject;

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XUPDATE_TRUST_PATH .'/class/handler/ModuleStore.class.php';
/**
* SimpleObject
*/
class Xupdate_ThemeStore extends Xupdate_ModuleStore {

	const PRIMARY = 'id';
	const DATANAME = 'themestore';
	
	public function get_StoreUrl()
	{
		//TODO for test dirname ?
		$root = Root::getSingleton();
		$modDirname = $root->mContext->mModule->mAssetManager->mDirname;
		$ret = XOOPS_MODULE_URL .'/'.$modDirname.'/admin/index.php?action=ThemeInstall'
			.'&id='.$this->getVar('id') .'&dirname='.$this->getVar('dirname');
		return $ret;
	}
	public function get_InstallUrl()
	{
		$ret = XOOPS_MODULE_URL .'/xcore/admin/index.php?action=ThemeInstall&dirname='
			.$this->getVar('dirname') ;
		return $ret;
	}
	public function get_UpdateUrl()
	{
		$ret = XOOPS_MODULE_URL .'/xcore/admin/index.php?action=ThemeUpdate&dirname='
			.$this->getVar('dirname') ;
		return $ret;
	}

} // end class

/**
* ObjectGenericRepository extends
*/
class Xupdate_ThemeStoreHandler extends Xupdate_ModuleStoreHandler
{
	public $mClass = 'Xupdate_ThemeStore';

	/**
	 * getDataname
	 *
	 * @param void
	 *
	 * @return	string[]
	 */
	public function getDataname()
	{
		return 'themestore';
	}
} // end class

?>