<?php


namespace XCore\Entity;

use XoopsObject;
use Criteria;

/**
 * Class for users
 * @author    Kazumi Ono <onokazu@xoops.org>
 * @copyright copyright (c) 2000-2003 XOOPS.org
 * @package   kernel
 */
class User extends XoopsObject
{

	/**
	 * Array of groups that user belongs to
	 * @var array
	 * @access private
	 */
	var $_groups = array();
	/**
	 * @var bool is the user admin?
	 * @access private
	 */
	var $_isAdmin = null;
	/**
	 * @var string user's rank
	 * @access private
	 */
	var $_rank = null;
	/**
	 * @var bool is the user online?
	 * @access private
	 */
	var $_isOnline = null;

	/**
	 * constructor
	 * @param array|int $id Array of key-value-pairs to be assigned to the user. (for backward compatibility only)
	 * ID of the user to be loaded from the database.
	 */
	public function __construct($id = null)
	{
		static $initVars;
		if ( isset($initVars) ) {
			$this->vars = $initVars;
		} else {
			$this->initVar('uid', XOBJ_DTYPE_INT, null, false);
			$this->initVar('name', XOBJ_DTYPE_TXTBOX, null, false, 60);
			$this->initVar('uname', XOBJ_DTYPE_TXTBOX, null, true, 25);
			$this->initVar('email', XOBJ_DTYPE_TXTBOX, null, true, 256);
			$this->initVar('url', XOBJ_DTYPE_TXTBOX, null, false, 100);
			$this->initVar('user_avatar', XOBJ_DTYPE_TXTBOX, null, false, 30);
			$this->initVar('user_regdate', XOBJ_DTYPE_INT, null, false);
			$this->initVar('user_icq', XOBJ_DTYPE_TXTBOX, null, false, 15);
			$this->initVar('user_from', XOBJ_DTYPE_TXTBOX, null, false, 100);
			$this->initVar('user_sig', XOBJ_DTYPE_TXTAREA, null, false, null);
			$this->initVar('user_viewemail', XOBJ_DTYPE_INT, 0, false);
			$this->initVar('actkey', XOBJ_DTYPE_OTHER, null, false);
			$this->initVar('user_aim', XOBJ_DTYPE_TXTBOX, null, false, 18);
			$this->initVar('user_yim', XOBJ_DTYPE_TXTBOX, null, false, 25);
			$this->initVar('user_msnm', XOBJ_DTYPE_TXTBOX, null, false, 100);
			$this->initVar('pass', XOBJ_DTYPE_TXTBOX, null, false, 32);
			$this->initVar('posts', XOBJ_DTYPE_INT, null, false);
			$this->initVar('attachsig', XOBJ_DTYPE_INT, 0, false);
			$this->initVar('rank', XOBJ_DTYPE_INT, 0, false);
			$this->initVar('level', XOBJ_DTYPE_INT, 0, false);
			$this->initVar('theme', XOBJ_DTYPE_OTHER, null, false);
			$this->initVar('timezone_offset', XOBJ_DTYPE_OTHER, null, false);
			$this->initVar('last_login', XOBJ_DTYPE_INT, 0, false);
			$this->initVar('umode', XOBJ_DTYPE_OTHER, null, false);
			$this->initVar('uorder', XOBJ_DTYPE_INT, 1, false);
			// RMV-NOTIFY
			$this->initVar('notify_method', XOBJ_DTYPE_OTHER, 1, false);
			$this->initVar('notify_mode', XOBJ_DTYPE_OTHER, 0, false);
			$this->initVar('user_occ', XOBJ_DTYPE_TXTBOX, null, false, 100);
			$this->initVar('bio', XOBJ_DTYPE_TXTAREA, null, false, null);
			$this->initVar('user_intrest', XOBJ_DTYPE_TXTBOX, null, false, 150);
			$this->initVar('user_mailok', XOBJ_DTYPE_INT, 1, false);
			$initVars = $this->vars;
		}

		// for backward compatibility
		if ( isset($id) ) {
			if ( is_array($id) ) {
				$this->assignVars($id);
			} else {
				/** @var $member_handler \XoopsMemberHandler */
				$member_handler = xoops_gethandler('member');
				$user =& $member_handler->getUser($id);
				foreach ($user->vars as $k => $v) {
					$this->assignVar($k, $v['value']);
				}
			}
		}
	}

	/**
	 * check if the user is a guest user
	 *
	 * @return bool returns false
	 *
	 */
	function isGuest()
	{
		return false;
	}

	/**
	 * Updated by Catzwolf 11 Jan 2004
	 * find the username for a given ID
	 *
	 * @param int $userid  ID of the user to find
	 * @param int $usereal switch for usename or realname
	 * @return string name of the user. name for "anonymous" if not found.
	 */
	static function getUnameFromId($userid, $usereal = 0)
	{
		$userid = (int) $userid;
		$usereal = (int) $usereal;
		if ( $userid > 0 ) {
			static $nameCache;
			$field = $usereal ? 'name' : 'uname';
			if ( isset($nameCache[$field][$userid]) ) {
				return $nameCache[$field][$userid];
			}
			/** @var $member_handler \XoopsMemberHandler */
			$member_handler = xoops_gethandler('member');
			$user =& $member_handler->getUser($userid);
			if ( is_object($user) ) {
				return ($nameCache[$field][$userid] = $user->getVar($field));
			}
		}

		return $GLOBALS['xoopsConfig']['anonymous'];
	}

	/**
	 * increase the number of posts for the user
	 *
	 * @deprecated
	 */
	function incrementPost()
	{
		/** @var $member_handler \XoopsMemberHandler */
		$member_handler = xoops_gethandler('member');

		return $member_handler->updateUserByField($this, 'posts', $this->getVar('posts') + 1);
	}

	/**
	 * set the groups for the user
	 *
	 * @param array $groupsArr Array of groups that user belongs to
	 */
	function setGroups($groupsArr)
	{
		if ( is_array($groupsArr) ) {
			$this->_groups =& $groupsArr;
		}
	}

	/**
	 * get the groups that the user belongs to
	 *
	 * @param bool $bReget When this is true, this object gets group information from DB again.
	 *                This is a special method for the BASE(CMS core) functions, you should
	 *                not use this proactivity.
	 * @return array array of groups
	 */
	function getGroups($bReget = false)
	{
		if ( $bReget ) {
			unset($this->_groups);
		}

		if ( empty($this->_groups) ) {
			/** @var $member_handler \XoopsMemberHandler */
			$member_handler = xoops_gethandler('member');
			$this->_groups = $member_handler->getGroupsByUser($this->getVar('uid'));
		}

		return $this->_groups;
	}

	function getNumGroups()
	{
		if ( empty($this->_groups) ) {
			$this->getGroups();
		}

		return count($this->_groups);
	}

	/**
	 * alias for {@link getGroups()}
	 * @see getGroups()
	 * @return array array of groups
	 * @deprecated
	 */
	function groups()
	{
		return $this->getGroups();
	}

	/**
	 * Is the user admin ?
	 *
	 * This method will return true if this user has admin rights for the specified module.<br />
	 * - If you don't specify any module ID, the current module will be checked.<br />
	 * - If you set the module_id to -1, it will return true if the user has admin rights for at least one module
	 *
	 * @param int $module_id check if user is admin of this module
	 * @return bool is the user admin of that module?
	 */
	function isAdmin($module_id = null)
	{
		if ( $module_id === null ) {
			/** @var $xoopsModule \XoopsModule */
			global $xoopsModule;
			$module_id = isset($xoopsModule) ? $xoopsModule->getVar('mid', 'n') : 1;
		} elseif ( (int) $module_id < 1 ) {
			$module_id = 0;
		}
		/** @var $moduleperm_handler \XoopsGroupPermHandler */
		static $moduleperm_handler;
		isset($moduleperm_handler) || $moduleperm_handler = xoops_gethandler('groupperm');

		return $moduleperm_handler->checkRight('module_admin', $module_id, $this->getGroups());
	}

	/**
	 * get the user's rank
	 * @return array array of rank ID and title
	 */
	function rank()
	{
		if ( !isset($this->_rank) ) {
			$this->_rank = xoops_getrank($this->getVar('rank'), $this->getVar('posts'));
		}

		return $this->_rank;
	}

	/**
	 * is the user activated?
	 * @return bool
	 */
	function isActive()
	{
		if ( $this->getVar('level') == 0 ) {
			return false;
		}

		return true;
	}

	/**
	 * is the user currently logged in?
	 * @return bool
	 */
	function isOnline()
	{
		if ( !isset($this->_isOnline) ) {
			/** @var $onlinehandler \XoopsOnlineHandler */
			$onlinehandler = xoops_gethandler('online');
			$this->_isOnline = ($onlinehandler->getCount(new Criteria('online_uid', $this->getVar('uid', 'N'))) > 0) ? true : false;
		}

		return $this->_isOnline;
	}

	/**#@+
	 * specialized wrapper for {@link XoopsObject::getVar()}
	 *
	 * kept for compatibility reasons.
	 *
	 * @see XoopsObject::getVar()
	 * @deprecated
	 */
	/**
	 * get the users UID
	 * @return int
	 */
	function uid()
	{
		return $this->getVar('uid');
	}

	/**
	 * get the users name
	 * @param string $format format for the output, see {@link XoopsObject::getVar()}
	 * @return string
	 */
	function name($format = "S")
	{
		return $this->getVar("name", $format);
	}

	/**
	 * get the user's uname
	 * @param string $format format for the output, see {@link XoopsObject::getVar()}
	 * @return string
	 */
	function uname($format = "S")
	{
		return $this->getVar("uname", $format);
	}

	/**
	 * get the user's email
	 *
	 * @param string $format format for the output, see {@link XoopsObject::getVar()}
	 * @return string
	 */
	function email($format = "S")
	{
		return $this->getVar("email", $format);
	}

	function url($format = "S")
	{
		return $this->getVar("url", $format);
	}

	function user_avatar($format = "S")
	{
		return $this->getVar("user_avatar");
	}

	function user_regdate()
	{
		return $this->getVar("user_regdate");
	}

	function user_icq($format = "S")
	{
		return $this->getVar("user_icq", $format);
	}

	function user_from($format = "S")
	{
		return $this->getVar("user_from", $format);
	}

	function user_sig($format = "S")
	{
		return $this->getVar("user_sig", $format);
	}

	function user_viewemail()
	{
		return $this->getVar("user_viewemail");
	}

	function actkey()
	{
		return $this->getVar("actkey");
	}

	function user_aim($format = "S")
	{
		return $this->getVar("user_aim", $format);
	}

	function user_yim($format = "S")
	{
		return $this->getVar("user_yim", $format);
	}

	function user_msnm($format = "S")
	{
		return $this->getVar("user_msnm", $format);
	}

	function pass()
	{
		return $this->getVar("pass");
	}

	function posts()
	{
		return $this->getVar("posts");
	}

	function attachsig()
	{
		return $this->getVar("attachsig");
	}

	function level()
	{
		return $this->getVar("level");
	}

	function theme()
	{
		return $this->getVar("theme");
	}

	function timezone()
	{
		return $this->getVar("timezone_offset");
	}

	function umode()
	{
		return $this->getVar("umode");
	}

	function uorder()
	{
		return $this->getVar("uorder");
	}

	// RMV-NOTIFY
	function notify_method()
	{
		return $this->getVar("notify_method");
	}

	function notify_mode()
	{
		return $this->getVar("notify_mode");
	}

	function user_occ($format = "S")
	{
		return $this->getVar("user_occ", $format);
	}

	function bio($format = "S")
	{
		return $this->getVar("bio", $format);
	}

	function user_intrest($format = "S")
	{
		return $this->getVar("user_intrest", $format);
	}

	function last_login()
	{
		return $this->getVar("last_login");
	}

	/**
	 * This class has avatar in uploads directory.
	 * @return bool
	 */
	function hasAvatar()
	{
		$avatar = $this->getVar('user_avatar');
		if ( !$avatar || $avatar == "blank.gif" )
			return false;

		$file = XOOPS_UPLOAD_PATH."/".$avatar;

		return file_exists($file);
	}

	/**
	 *
	 * Return Abs URL for displaying avatar.
	 *
	 * @return string
	 */
	function getAvatarUrl()
	{
		if ( $this->hasAvatar() )
			return XOOPS_UPLOAD_URL."/".$this->getVar('user_avatar');

		return null;
	}
	/**#@-*/
}
