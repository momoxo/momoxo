<?php

namespace XCore\Kernel;

use XCore\Kernel\Root;
use XCore\Kernel\LanguageManager;
use XCore\Kernel\DelegateManager;
use XCore\Kernel\ServiceManager;
use XCore\Kernel\AbstractPermissionProvider;
use XCore\Kernel\RoleManager;
use XCore\Kernel\TextFilter;
use XCore\Kernel\HttpContext;
use XCore\Kernel\Session;
use XCore\Kernel\Ref;
use XCore\Kernel\HttpRequest;
use XCore\Kernel\ActionFilter;
use XCore\Kernel\Delegate;

/**
 * Virtual or Actual front controller class.
 *
 * This is an abstract class. And, a sub-class of this class has many
 * impositions which sets up root object finally and implements many actual
 * logic.
 *
 * executeXXXXX() functions are a public member function called by an accessed
 * file. These member functions call other protected member functions.
 *
 * _setupXXXXX() functions are a protected member function overridden by a
 * sub-class controller. Most of these functions are empty. A sub-class
 * controller overrides them to set up a controller object and others.
 *
 * _createXXXXX() functions are a protected member function overridden by a
 * sub-class controller. These member functions are called in prepare() to set
 * up the root object. And, they have been exported from prepare() for a
 * sub-class controller to override easily. Most of sub-class controllers
 * doesn't need to override them, because typical code is there.
 */
class Controller
{
	/**
	 * The reference for the root object.
	 * @var Root
	 */
	public $mRoot;

	/**
	 * Array of a procedure class object.
	 * @var object[]
	 * @todo これは public でいいんだろうか？
	 */
	public $_mBlockChain = array();

	/**
	 * Vector Array of ActionFilter class object.
	 * @var ActionFilter[]
	 */
	protected $_mFilterChain = array();

	/**
	 * This is Map-Array to keep names of action filter classes which are
	 * applied as filters.
	 * @var bool[]
	 */
	protected $_mLoadedFilterNames = array();

	/**
	 * The database object which is abstract layer for the database.
	 * @var object
	 */
	public $mDB;

	/**
	 * A name of the current local.
	 * @var string
	 */
	public $mLocale;

	/**
	 * A name of the current language.
	 * @var string
	 */
	public $mLanguage;

	/**
	 * Rebuilds the principal object for the current HTTP-request.
	 * @var Delegate
	 */
	public $mSetupUser;

	/**
	 * Executes the main logic of the controller.
	 * @var Delegate
	 */
	public $mExecute;

	/**
	 * Make a instance of TextFilter.
	 * @var Delegate
	 */
	public $mSetupTextFilter;

	public function __construct()
	{
		$this->_mBlockChain = array();
		$this->_mFilterChain = array();
		$this->_mLoadedFilterNames = array();

		$this->mSetupUser = new Delegate();
		$this->mExecute = new Delegate();
		$this->mSetupTextFilter = new Delegate();
		$this->mSetupTextFilter->add('XCore\Kernel\TextFilter::getInstance', XCUBE_DELEGATE_PRIORITY_FINAL);
	}

	/**
	 * This member function is overridden. The sub-class implements the
	 * initialization process which sets up the root object finally.
	 * @param Root $root
	 */
	public function prepare(&$root)
	{
		$this->mRoot =& $root;

		$this->mRoot->setDelegateManager($this->_createDelegateManager());
		$this->mRoot->setServiceManager($this->_createServiceManager());
		$this->mRoot->setPermissionManager($this->_createPermissionManager());
		$this->mRoot->setRoleManager($this->_createRoleManager());
		$this->mRoot->setContext($this->_createContext());
	}

	/**
	 * This member function is actual initialize process of web application.
	 * Some Nuke-like bases call this function at any timing.
	 */
	public function executeCommon()
	{
		//
		// Setup Filter chain and execute the process of these filters.
		//
		$this->_setupFilterChain();
		$this->_processFilter();

		$this->_setupEnvironment();

		$this->_setupDB();

		$this->_setupLanguage();

		$this->_setupTextFilter();

		$this->_setupConfig();

		//
		// Block section
		//
		$this->_processPreBlockFilter();	// What's !?

		$this->_setupSession();

		$this->_setupUser();
	}

	/**
	 * Usually this member function is called after executeCommon(). But, some
	 * cases don't call this. Therefore, the page controller type base should
	 * not write the indispensable code here. For example, this is good to call
	 * blocks.
	 */
	public function executeHeader()
	{
		$this->_setupBlock();
		$this->_processBlock();
	}

	/**
	 * Executes the main logic.
	 */
	public function execute()
	{
		$this->mExecute->call(new Ref($this));
	}

	/**
	 * Executes the view logic. This member function is overridden.
	 */
	public function executeView()
	{
	}

	/**
	 * TODO We may change this name to forward()
	 *
	 * @param string  $url		Can't use html tags.
	 * @param int	  $time
	 * @param string  $message
	 */
	public function executeForward($url, $time = 0, $message = null)
	{
		// check header output
		header("location: " . $url);
		exit(); // need to response
	}

	/**
	 * Redirect to the specified URL with displaying message.
	 *
	 * @param string  $url		Can't use html tags.
	 * @param int	  $time
	 * @param string  $message
	 */
	public function executeRedirect($url, $time = 1, $message = null)
	{
		$this->executeForward($url, $time, $message);
	}

	/**
	 * Adds the ActionFilter instance.
	 * @param ActionFilter $filter
	 */
	public function addActionFilter(&$filter)
	{
		$this->_mFilterChain[] =& $filter;
	}

	/**
	 * Create filter chain.
	 * @protected
	 */
	protected function _setupFilterChain()
	{
	}

	/**
	 * This member function is overridden. Sets up the controller and the
	 * environment.
	 */
	protected function _setupEnvironment()
	{
	}

	/**
	 * Creates the instance of DataBase class, and sets it to member property.
	 */
	protected function _setupDB()
	{
	}

	/**
	 * Gets the DB instance.
	 * @return object
	 */
	public function &getDB()
	{
		return $this->mDB;
	}

	/**
	 * Creates the instance of Language Manager class, and sets it to member
	 * property.
	 */
	protected function _setupLanguage()
	{
		$this->mRoot->mLanguageManager = new LanguageManager();
	}


	/**
	 * Creates the instance of Text Filter class, and sets it to member
	 * property.
	 */
	protected function _setupTextFilter()
	{
		/** @var $textFilter TextFilter */
		$textFilter = null;
		$this->mSetupTextFilter->call(new Ref($textFilter));
		$this->mRoot->setTextFilter($textFilter);
	}


	/**
	 * This member function is overridden. Loads site configuration information,
	 * and sets them to the member property.
	 */
	protected function _setupConfig()
	{
	}

	/**
	 * This member function is overridden. Sets up handler for session, then
	 * starts session.
	 */
	protected function _setupSession()
	{
		$this->mRoot->setSession(new Session());
	}

	/**
	 * Sets up a principal object to the root object. In other words, restores
	 * the principal object from session or other.
	 */
	protected function _setupUser()
	{
		$this->mSetupUser->call(new Ref($this->mRoot->mContext->mUser), new Ref($this), new Ref($this->mRoot->mContext));
	}

	/**
	 * Calls the preFilter() member function of action filters which have been
	 * loaded to the list of the controller.
	 */
	protected function _processFilter()
	{
		foreach (array_keys($this->_mFilterChain) as $key) {
			$this->_mFilterChain[$key]->preFilter();
		}
	}

	/**
	 * FIXME.
	 */
	protected function _setupBlock()
	{
	}

	/**
	 * FIXME.
	 */
	protected function _processBlock()
	{
	}

	/**
	 * Calls the preBlockFilter() member function of action filters which have been
	 * loaded to the list of the controller.
	 */
	protected function _processPreBlockFilter()
	{
		foreach (array_keys($this->_mFilterChain) as $key) {
			$this->_mFilterChain[$key]->preBlockFilter();
		}
	}

	/**
	 * Calls the postFilter() member function of action filters which have been
	 * loaded to the list of the controller.
	 */
	protected function _processPostFilter()
	{
		foreach (array_reverse(array_keys($this->_mFilterChain)) as $key) {
			$this->_mFilterChain[$key]->postFilter();
		}
	}

	/**
	 * This is utility member function for the sub-class controller. Load files
	 * with the rule from $path, and add the instance of the sub-class to the
	 * chain.
	 *
	 * @protected
	 * @param string $path Absolute path.
	 * @todo 他のクラスがコールしているため protected にできない
	 */
	function _processPreload($path)
	{
		$path = $path . "/";

		if (is_dir($path)) {
			foreach (glob($path.'/*.class.php') as $file) {
				require_once $file;
				$className = basename($file, '.class.php');
				if (class_exists($className) && !isset($this->_mLoadedFilterNames[$className])) {
					$this->_mLoadedFilterNames[$className] = true;
					$instance = new $className($this);
					$this->addActionFilter($instance);
					unset($instance);
				}
			}
		}
	}

	/**
	 * Creates an instance of the delegate manager and returns it.
	 * @return DelegateManager
	 */
	protected function &_createDelegateManager()
	{
		$delegateManager = new DelegateManager();
		return $delegateManager;
	}

	/**
	 * Creates an instance of the service manager and returns it.
	 * @return ServiceManager
	 */
	protected function &_createServiceManager()
	{
		$serviceManager = new ServiceManager();
		return $serviceManager;
	}

	/**
	 * Creates an instance of the permission manager and returns it.
	 * @return AbstractPermissionProvider
	 */
	protected function &_createPermissionManager()
	{
		$chunkName = $this->mRoot->getSiteConfig('Cube', 'PermissionManager');

		//
		// FIXME: Access private method.
		//
		$manager =& $this->mRoot->_createInstance($this->mRoot->getSiteConfig($chunkName, 'class'), $this->mRoot->getSiteConfig($chunkName, 'path'));

		return $manager;
	}

	/**
	 * Creates an instance of the role manager and returns it.
	 * @return RoleManager
	 */
	protected function &_createRoleManager()
	{
		$chunkName = $this->mRoot->getSiteConfig('Cube', 'RoleManager');

		//
		// FIXME: Access private method.
		//
		$manager =& $this->mRoot->_createInstance($this->mRoot->getSiteConfig($chunkName, 'class'), $this->mRoot->getSiteConfig($chunkName, 'path'));

		return $manager;
	}

	/**
	 * Creates the context object to initial the root object, and returns it.
	 * @return HttpContext
	 */
	protected function &_createContext()
	{
		$context = new HttpContext();
		$request = new HttpRequest();
		$context->setRequest($request);

		return $context;
	}
}
