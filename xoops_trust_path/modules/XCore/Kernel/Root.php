<?php

namespace XCore\Kernel;

use RuntimeException;
use XCube_Session;
use XCube_Ref;
use XCore\Kernel\Controller;
use XCore\Kernel\LanguageManager;
use XCore\Kernel\DelegateManager;
use XCore\Kernel\ServiceManager;
use XCore\Kernel\RenderSystem;
use XCore\Kernel\AbstractPermissionProvider;
use XCore\Kernel\RoleManager;
use XCore\Kernel\TextFilter;
use XCore\Kernel\HttpContext;

/**
 * The root object which collects exchangeable managers.
 *
 * This class offers the access course same as global variable for a logic in old mechanism.
 * This class does not let you depend on a main controller class name
 * You must not succeed to this class.
 */
class Root
{
	/**
	 * @var Controller
	 */
	public $mController;

	/**
	 * @var LanguageManager
	 */
	public $mLanguageManager;

	/**
	 * @var DelegateManager
	 */
	public $mDelegateManager;

	/**
	 * @var ServiceManager
	 */
	public $mServiceManager;

	/**
	 * Caches for generated render-systems.
	 *
	 * Only the kernel system should access this member property.
	 * @var RenderSystem[]
	 */
	private $_mRenderSystems = array();

	/**
	 * @var string[]
	 */
	public $mSiteConfig = array();

	/**
	 * @internal
	 * @var AbstractPermissionProvider
	 */
	public $mPermissionManager;

	/**
	 * @readonly
	 * @var RoleManager
	 * @todo Let's implements!
	 */
	public $mRoleManager;

	/**
	 * In some cases, this member is not initialized. Use getTextFilter().
	 * @readonly
	 * @var TextFilter
	 * @see getTextFilter()
	 */
	public $mTextFilter;

	/**
	 * @var HttpContext
	 */
	public $mContext;

	/**
	 * @readonly
	 * @var XCube_Session
	 */
	public $mSession;

	/**
	 * @internal
	 */
	public function __construct()
	{
	}

	/**
	 * Gets a object of Root as singleton.
	 * @return Root
	 */
	public static function getSingleton()
	{
		static $instance;

		if (!isset($instance))
			$instance = new self();

		return $instance;
	}

	/**
	 * Loads SiteConfig from plural files, and control set and override site config.
	 *
	 * Loads the site settings from file1.
	 *
	 * ```
	 * $root->loadSiteConfig(string $file1);
	 * ```
	 *
	 * Loads the site setting from file1. After that, override file1's setting with file2's setting.
	 *
	 * ```
	 * $root->loadSiteConfig(string $file1, string $file2);
	 * ```
	 *
	 * Only a base module's boot strap should call this method.
	 *
	 * @overload
	 * @throws \RuntimeException
	 * @return void
	 */
	public function loadSiteConfig()
	{
		$n = func_num_args();
		if ($n == 0) {
			throw new RuntimeException("FETAL: open error: site setting config.");
		}

		$files = func_get_args();
		$file = array_shift($files);

		if(!file_exists($file)) {
			throw new RuntimeException("FETAL: open error: site setting config.");
		}

		$this->setSiteConfig(parse_ini_file($file, true));

		//
		// Override setting.
		//
		if ($n > 1) {
			foreach ($files as $overrideFile) {
				if (file_exists($overrideFile)) {
					$this->overrideSiteConfig(parse_ini_file($overrideFile, true));
				}
			}
		}
	}

	/**
	 * Sets site configs.
	 * @internal
	 * @param array $config
	 * @return void
	 */
	public function setSiteConfig($config)
	{
		$this->mSiteConfig = $config;
	}

	/**
	 * Overwrites the current site configs with $config.
	 *
	 * Override site config. SiteConfig is overridden by $config value. And, if
	 * $config has new key, that key is set.
	 *
	 * Only the header of the current base module should call this method.
	 *
	 * @param array $config
	 * @return void
	 */
	public function overrideSiteConfig($config)
	{
		foreach ($config as $_overKey=>$_overVal) {
			if (array_key_exists($_overKey, $this->mSiteConfig)) {
				$this->mSiteConfig[$_overKey] = array_merge($this->mSiteConfig[$_overKey], $_overVal);
			}
			else {
				$this->mSiteConfig[$_overKey] = $_overVal;
			}
		}
	}

	/**
	 * Gets a value of site config that is defined by .ini files.
	 * @overload
	 * @return mixed If the value specified by parameters is no, return null.
	 *
	 * Gets array.
	 *
	 * ```
	 * $root->getSiteConfig();
	 * ```
	 *
	 * Gets array of the group specified by $groupName.
	 *
	 * ```
	 * $root->getSiteConfig(string $groupName);
	 * ```
	 *
	 * Gets a config value specified by $groupName & $itemName.
	 *
	 * ```
	 * $root->getSiteConfig(string $groupName, string $itemName);
	 * ```
	 *
	 * If the config value is NOT defined specified by $groupName & $itemName, gets $default.
	 *
	 * ```
	 * $root->getSiteConfig(string $groupName, string $itemName, string $default);
	 * ```
	 */
	public function getSiteConfig()
	{
		//
		// TODO Check keys with using 'isset'
		//
		$m = &$this->mSiteConfig;
		$n = func_num_args();
		if ($n == 0) return $m;
		elseif ($n == 1) {
			$a = func_get_arg(0);
			if (isset($m[$a])) return $m[$a];
		}
		elseif ($n == 2) {
			list($a, $b) = func_get_args();
			if (isset($m[$a][$b])) return $m[$a][$b];
		}
		elseif ($n == 3) {
			list($a, $b, $c) = func_get_args();
			if (isset($m[$a][$b])) return $m[$a][$b];
			else return $c; //return 3rd param as a default value;
		}

		return null;
	}

	/**
	 * Creates controller with the rule.
	 *
	 * Creates controller with the rule, and call member function prepare().
	 * The class of creating controller is defined in ini.php files.
	 *
	 * Only the header of the current base module should call this method.
	 *
	 * @return void
	 */
	public function setupController()
	{
		//
		// [NOTICE]
		// We don't decide the style of SiteConfig.
		//
		$controllerName = $this->mSiteConfig['Cube']['Controller'];
		$controller =& $this->mSiteConfig[$controllerName];
		if(isset($controller['root'])) {
			$this->mController =& $this->_createInstance($controller['class'], $controller['path'], $controller['root']);
		}
		else {
			$this->mController =& $this->_createInstance($controller['class'], $controller['path']);
		}
		$this->mController->prepare($this);
	}

	/**
	 * @return Controller
	 */
	public function &getController()
	{
		return $this->mController;
	}

	/**
	 * @param LanguageManager $languageManager
	 * @return void
	 */
	public function setLanguageManager(&$languageManager)
	{
		$this->mLanguageManager =& $languageManager;
	}

	/**
	 * @return LanguageManager
	 */
	public function &getLanguageManager()
	{
		return $this->mLanguageManager;
	}

	/**
	 * Sets the DelegateManager object.
	 * @param DelegateManager $delegateManager
	 * @return void
	 */
	public function setDelegateManager(&$delegateManager)
	{
		$this->mDelegateManager =& $delegateManager;
	}

	/**
	 * Gets a DelegateManager object.
	 * @return DelegateManager
	 */
	public function &getDelegateManager()
	{
		return $this->mDelegateManager;
	}

	/**
	 * Sets the ServiceManager object.
	 * @param ServiceManager $serviceManager
	 * @return void
	 */
	public function setServiceManager(&$serviceManager)
	{
		$this->mServiceManager =& $serviceManager;
	}

	/**
	 * Gets a ServiceManager object.
	 * @return ServiceManager
	 */
	public function &getServiceManager()
	{
		return $this->mServiceManager;
	}

	/**
	 * Gets a RenderSystem object having specified name.
	 *
	 * Return the instance of the render system by the name. If the render
	 * system specified by $name doesn't exist, raise fatal error. This member
	 * function does creating the instance and calling prepare().
	 *
	 * @param string $name the registered name of the render system.
	 * @throws \RuntimeException
	 * @return RenderSystem
	 */
	public function &getRenderSystem($name)
	{
		$mRS =& $this->_mRenderSystems;
		if (isset($mRS[$name])) {
			return $mRS[$name];
		}

		//
		// create
		//
		$config =& $this->mSiteConfig;
		$chunkName = $config['RenderSystems'][$name];
		$chunk =& $config[$chunkName];
		if (isset($config[$chunkName]['root'])) {
			$mRS[$name] =& $this->_createInstance($chunk['class'], $chunk['path'], $chunk['root']);
		}
		else {
			$mRS[$name] =& $this->_createInstance($chunk['class'], $chunk['path']);
		}

		if (!is_object($mRS[$name])) {
			throw new RuntimeException(
				sprintf('Render system "%s" is not an object', $name)
			);
		}

		$mRS[$name]->prepare($this->mController);

		return $mRS[$name];
	}

	/**
	 * @internal
	 * @return void
	 */
	public function setPermissionManager(&$manager)
	{
		$this->mPermissionManager =& $manager;
	}

	/**
	 * @internal
	 * @return AbstractPermissionProvider
	 */
	public function &getPermissionManager()
	{
		return $this->mPermissionManager;
	}

	/**
	 * Sets a TextFilter object.
	 * @param TextFilter $textFilter
	 * @return void
	 */
	public function setTextFilter(&$textFilter)
	{
		$this->mTextFilter =& $textFilter;
	}

	/**
	 * Gets a TextFilter object.
	 *
	 * If mTextFilter member has been not initialized, the root object tries to
	 * generate an instance though Controller's delegate. This is a special
	 * case. Basically, a class never calls delegates of other classes directly.
	 *
	 * @return TextFilter
	 */
	public function &getTextFilter()
	{
		if (!empty($this->mTextFilter)) return $this->mTextFilter;
		if (!empty($this->mController)) { //ToDo: This case is for _XCORE_PREVENT_EXEC_COMMON_ status;
			$this->mController->mSetupTextFilter->call(new XCube_Ref($this->mTextFilter));
			return $this->mTextFilter;
		}

		// Exception
		$ret = null;
		return $ret;
	}

	/**
	 * Sets the role manager object.
	 * @param RoleManager $manager
	 * @return void
	 */
	public function setRoleManager(&$manager)
	{
		$this->mRoleManager =& $manager;
	}

	/**
	 * Sets the HTTP-context object.
	 * @param HttpContext $context
	 * @return void
	 */
	public function setContext(&$context)
	{
		$this->mContext =& $context;
	}

	/**
	 * Gets a HTTP-context object.
	 * @return HttpContext
	 */
	public function &getContext()
	{
		return $this->mContext;
	}

	/**
	 * Sets a Session object.
	 * @param XCube_Session $session
	 * @return void
	 */
	public function setSession(&$session)
	{
		$this->mSession =& $session;
	}

	/**
	 * Gets a Session object.
	 * @return XCube_Session
	 */
	public function &getSession()
	{
		return $this->mSession;
	}

	/**
	 * Create an instance.
	 *
	 * Create the instance dynamic with the rule and the string parameters.
	 * First, load the file from $classPath. The rule is XOOPS_ROOT_PATH +
	 * $classPath + $className + .class.php. Next, create the instance of the
	 * class if the class is defined rightly. This member function is called by
	 * other member functions of Root.
	 *
	 * @private
	 * @param string $className the name of class.
	 * @param string $classPath the path that $className is defined in.
	 * @param string $root      the root path instead of Cube.Root.
	 * @return object
	 * @todo If the file doesn't exist, require_once() raises fatal errors.
	 */
	function &_createInstance($className, $classPath = null, $root = null)
	{
		$ret = null;

		if (class_exists($className)) {
			$ret = new $className();
			return $ret;
		}

		if ($classPath != null) {
			if ($root == null) {
				$root = $this->mSiteConfig['Cube']['Root'];
			}

			if (is_file($root . $classPath)) {
				// [secret trick] ... Normally, $classPath has to point a directory.
				require_once $root . $classPath;
			}
			else {
				require_once $root . $classPath . '/' . $className . '.class.php';
			}
		}

		if (class_exists($className)) {
			$ret = new $className();
		}

		return $ret;
	}
}