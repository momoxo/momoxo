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
use XCore\Entity\Module;
use Xcore_AdminControllerStrategy;
use Xcore_PublicControllerStrategy;
use XoopsSecurity;
use Xcore_Utils;
use XCore\Database\DatabaseFactory;
use XCore\Database\CriteriaCompo;
use XCore\Database\Criteria;
use RuntimeException;
use Xcore_LanguageManager;
use Xcore_HeaderScript;
use Xcore_SearchService;
use XCore\Utils\Utils;
use XoopsTpl;
use Xoops\Experimental\UrlParser;

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
    const MODULE_MANIFESTO_FILENAME = 'xoops_version.php';

    /**
     * The reference for the root object.
     * @var Root
     */
    public $mRoot;

    /**
     * Array of a procedure class object.
     * @var \Xcore_AbstractBlockProcedure[]
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

    var $_mAdminModeFlag = false;
    var $_mStrategy = null;

    var $mDialogMode = false;

    /**
     * @var Delegate
     */
    var $mCheckLogin = null;

    /**
     * @var Delegate
     */
    var $mLogout = null;

    /**
     * @var Delegate
     */
    var $mCreateLanguageManager = null;

    /**
     * @var Delegate
     */
    var $mSetBlockCachePolicy = null;

    /**
     * @var Module[]
     */
    var $mActiveModules = null;

    /**
     * @var Delegate
     */
    var $mSetModuleCachePolicy = null;

    /**
     * @var Delegate
     */
    var $mGetLanguageName = null;

    /**
     * @var Delegate
     */
    var $mSetupDebugger = null;

    /**
     * @public
     * @var Delegate
     * [Secret Agreement] In execute_redirect(), notice the redirection which directs toward user.php.
     * @remark Only the special module should access this member property.
     */
    var $_mNotifyRedirectToUser = null;

    /**
     * @var Logger
     */
    var $mLogger = null;

    public function __construct()
    {
        $this->_mBlockChain = array();
        $this->_mFilterChain = array();
        $this->_mLoadedFilterNames = array();

        $this->mSetupUser = new Delegate();
        $this->mExecute = new Delegate();
        $this->mSetupTextFilter = new Delegate();
        $this->mSetupTextFilter->add('XCore\Kernel\TextFilter::getInstance', XCUBE_DELEGATE_PRIORITY_FINAL);

        //
        // Setup member properties as member delegates.
        //
        $this->mSetupUser->register('Controller.SetupUser');

        $this->mCheckLogin = new Delegate();
        $this->mCheckLogin->register('Site.CheckLogin');

        $this->mLogout = new Delegate();
        $this->mLogout->register('Site.Logout');

        $this->mCreateLanguageManager = new Delegate();
        $this->mCreateLanguageManager->register('Controller.CreateLanguageManager');

        $this->mGetLanguageName = new Delegate();
        $this->mGetLanguageName->register('Controller.GetLanguageName');

        $this->mSetBlockCachePolicy = new Delegate();
        $this->mSetModuleCachePolicy = new Delegate();

        $this->mSetupDebugger = new Delegate();
        $this->mSetupDebugger->add('Xcore_DebuggerManager::createInstance');

        $this->mSetupTextFilter->add('Xcore_TextFilter::getInstance', XCUBE_DELEGATE_PRIORITY_FINAL - 1);

        $this->_mNotifyRedirectToUser = new Delegate();
        if ( get_magic_quotes_runtime() ) {
            set_magic_quotes_runtime(0); // ^^;
        }
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

        //
        // Decide status. [TEST]
        //
        $this->_processHostAbstractLayer();

        $adminStateFlag = UrlParser::isAdminPage(UrlParser::parse(XOOPS_URL));

        if ($adminStateFlag) {
            $this->_mStrategy = new Xcore_AdminControllerStrategy($this);
        } else {
            $this->_mStrategy = new Xcore_PublicControllerStrategy($this);
        }
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

        if ( !defined('OH_MY_GOD_HELP_ME') ) {
//			error_reporting(0);
        }

        // ^^;
        $this->_setupErrorHandler();
        //function date_default_timezone_set() is added on PHP5.1.0
        if ( function_exists('date_default_timezone_set') ) {
            date_default_timezone_set($this->_getLocalTimezone());
        }

        $this->_setupEnvironment();

        $this->_setupLogger();
//
        $this->_setupDB();

        $this->_setupLanguage();

        $this->_setupTextFilter();

        $this->_setupConfig();

        $this->_setupScript();
//

        $this->_setupDebugger();

        $this->_loadInterfaceFiles();

        $this->_processPreBlockFilter(); // What's !?

        $this->_setupSession();

        $this->_setupUser();

        $this->setupModuleContext();

        $this->_processModule();

        $this->_processPostFilter();
    }

    /**
     * Subset of executeCommon() Method
     * It'll be used when process starts with $xoopsOption['nocommon'] and
     * This process requires connecting XOOPS Database or Legacy constant values
     * But it won't do any other initial settings
     *    (eg. Session start, Permission handling)
     *
     * @access public
     * @param bool $connectdb set false if you don't want to connetcting XOOPS Database
     *
     */
    function executeCommonSubset($connectdb = true)
    {
        $this->_setupErrorHandler();
        $this->_setupEnvironment();
        if ( $connectdb ) {
            $this->_setupLogger();
            $this->_setupDB();
        }
    }

    function _setupLogger()
    {
        $this->mLogger = Logger::instance();
        $this->mLogger->startTime();

        $GLOBALS['xoopsLogger'] = $this->mLogger;
    }

    function &getLogger()
    {
        return $this->mLogger;
    }

    function _getLocalTimezone()
    {
        $iTime = time();
        $arr = localtime($iTime);
        $arr[5] += 1900;
        $arr[4]++;
        $iTztime = gmmktime($arr[2], $arr[1], $arr[0], $arr[4], $arr[3], $arr[5]);
        $offset = doubleval(($iTztime - $iTime) / (60 * 60));
        $zonelist =
            array
            (
                'Kwajalein'                      => -12.00,
                'Pacific/Midway'                 => -11.00,
                'Pacific/Honolulu'               => -10.00,
                'America/Anchorage'              => -9.00,
                'America/Los_Angeles'            => -8.00,
                'America/Denver'                 => -7.00,
                'America/Tegucigalpa'            => -6.00,
                'America/New_York'               => -5.00,
                'America/Caracas'                => -4.30,
                'America/Halifax'                => -4.00,
                'America/St_Johns'               => -3.30,
                'America/Argentina/Buenos_Aires' => -3.00,
                'America/Sao_Paulo'              => -3.00,
                'Atlantic/South_Georgia'         => -2.00,
                'Atlantic/Azores'                => -1.00,
                'Europe/Dublin'                  => 0,
                'Europe/Belgrade'                => 1.00,
                'Europe/Minsk'                   => 2.00,
                'Asia/Kuwait'                    => 3.00,
                'Asia/Tehran'                    => 3.30,
                'Asia/Muscat'                    => 4.00,
                'Asia/Yekaterinburg'             => 5.00,
                'Asia/Kolkata'                   => 5.30,
                'Asia/Katmandu'                  => 5.45,
                'Asia/Dhaka'                     => 6.00,
                'Asia/Rangoon'                   => 6.30,
                'Asia/Krasnoyarsk'               => 7.00,
                'Asia/Brunei'                    => 8.00,
                'Asia/Seoul'                     => 9.00,
                'Australia/Darwin'               => 9.30,
                'Australia/Canberra'             => 10.00,
                'Asia/Magadan'                   => 11.00,
                'Pacific/Fiji'                   => 12.00,
                'Pacific/Tongatapu'              => 13.00
            );
        $index = array_keys($zonelist, $offset);
        if ( sizeof($index) != 1 )
            return false;

        return $index[0];
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

        //
        //	We changed a render-system class in a pure drawing system. Therefore
        // a controller should not ask him for careful work for compatibility.
        //

        //
        // The following comment-outed line is old version process.
        //
        // $this->mRenderSystem->_processStartPage();

        require_once XOOPS_ROOT_PATH.'/modules/xcore/include/old_theme_functions.php';
        $GLOBALS['xoopsTheme']['thename'] = $GLOBALS['xoopsConfig']['theme_set'];

        //
        // cache check
        //
        if ( $this->mRoot->mContext->mModule != null && $this->isEnableCacheFeature() ) {
            $cacheInfo =& $this->mRoot->mContext->mModule->createCacheInfo();

            $this->mSetModuleCachePolicy->call($cacheInfo);

            if ( $this->mRoot->mContext->mModule->isEnableCache() ) {
                //
                // Checks whether the cache file exists.
                //
                $xoopsModule =& $this->mRoot->mContext->mXoopsModule;

                $cachetime = $this->mRoot->mContext->mXoopsConfig['module_cache'][$xoopsModule->get('mid')];
                $filepath = $cacheInfo->getCacheFilePath();

                //
                // Checks whether the active cache file exists. If it's OK, load
                // cache and do display.
                //
                if ( $cacheInfo->isEnableCache() && $this->existActiveCacheFile($filepath, $cachetime) ) {
                    $renderSystem =& $this->mRoot->getRenderSystem($this->mRoot->mContext->mModule->getRenderSystemName());
                    $renderTarget =& $renderSystem->createRenderTarget(XCUBE_RENDER_TARGET_TYPE_MAIN);
                    $renderTarget->setResult($this->loadCache($filepath));

                    $this->_executeViewTheme($renderTarget);

                    exit(); // need to response
                }
            }
        }

        ob_start();
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
        if ( $this->mRoot->mContext->mModule != null ) {
            $renderSystem =& $this->mRoot->getRenderSystem($this->mRoot->mContext->mModule->getRenderSystemName());
            $renderTarget =& $this->mRoot->mContext->mModule->getRenderTarget();

            //
            //	Buffering handling of standard output for main render target is responsibility
            // of a controller. Of course all controllers do not have to implement this.
            // The following lines are movement for compatibility and the feature of
            // this controller.
            //

            // Wmm...
            if ( is_object($renderTarget) ) {
                if ( $renderTarget->getTemplateName() == null ) {
                    if ( isset($GLOBALS['xoopsOption']['template_main']) ) {
                        $renderTarget->setTemplateName($GLOBALS['xoopsOption']['template_main']);
                    }
                }

                $renderTarget->setAttribute('stdout_buffer', ob_get_contents());
            }

            ob_end_clean();

            if ( is_object($renderTarget) ) {
                $renderSystem->render($renderTarget);

                //
                // Cache Control
                //
                $module = $this->mRoot->mContext->mModule;
                if ( $this->isEnableCacheFeature() && $module->isEnableCache() && $module->mCacheInfo->isEnableCache() ) {
                    $this->cacheRenderTarget($module->mCacheInfo->getCacheFilePath(), $renderTarget);
                }
            }
        }

        $this->_executeViewTheme($renderTarget);
    }

    /**
     * TODO We may change this name to forward()
     *
     * @param string $url     Can't use html tags.
     * @param int    $time
     * @param string $message
     */
    public function executeForward($url, $time = 0, $message = null)
    {
        // check header output
        header("location: ".$url);
        exit(); // need to response
    }

    /**
     * Redirect to the specified URL with displaying message.
     *
     * @param string $url     Can't use html tags.
     * @param int    $time
     * @param string $message
     */
    public function executeRedirect($url, $time = 1, $message = null)
    {
        global $xoopsConfig, $xoopsRequestUri;

        //
        // Check the following by way of caution.
        //
        if (preg_match('/(javascript|vbscript):/si', $url)) {
            $url = XOOPS_URL;
        }

        $displayMessage = '';
        if (is_array($message)) {
            foreach (array_keys($message) as $key) {
                $message[$key] = htmlspecialchars($message[$key], ENT_QUOTES);
            }
            $displayMessage = implode('<br/>', $message);
        }
        else {
            $displayMessage = $message;
        }

        $url = htmlspecialchars($url, ENT_QUOTES);

        // XOOPS2 Compatibility
        if ($addRedirect && strstr($url, 'user.php')) {
            $this->_mNotifyRedirectToUser->call(new Ref($url));
        }

        if (defined('SID') && (! isset($_COOKIE[session_name()]) || ($xoopsConfig['use_mysession'] && $xoopsConfig['session_name'] != '' && !isset($_COOKIE[$xoopsConfig['session_name']])))) {
            if ( strpos($url, XOOPS_URL) === 0 ) {
                if (!strstr($url, '?')) {
                    $connector = '?';
                }
                else {
                    $connector = '&amp;';
                }
                if (strstr($url, '#')) {
                    $urlArray = explode( '#', $url );
                    $url = $urlArray[0] . $connector . SID;
                    if ( ! empty($urlArray[1]) ) {
                        $url .= '#' . $urlArray[1];
                    }
                }
                else {
                    $url .= $connector . SID;
                }
            }
        }

        if (!defined('XOOPS_CPFUNC_LOADED')) {
            $xoopsTpl = new XoopsTpl();
            $xoopsTpl->assign(array('xoops_sitename'=>htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES),
                                    'sitename'=>htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES),
                                    'langcode'=>_LANGCODE, 'charset'=>_CHARSET,
                                    'time'=>$time, 'url'=>$url,
                                    'message'=>$displayMessage,
                                    'lang_ifnotreload'=>sprintf(_IFNOTRELOAD, $url)));
            $GLOBALS['xoopsModuleUpdate'] = 1;
            $xoopsTpl->display('db:system_redirect.html');
        } else {
            header('Content-Type:text/html; charset='._CHARSET);
            echo '
			<html>
			<head>
			<title>'.htmlspecialchars($xoopsConfig['sitename']).'</title>
			<meta http-equiv="Content-Type" content="text/html; charset='._CHARSET.'" />
			<meta http-equiv="Refresh" content="'.$time.'; url='.$url.'" />
			<style type="text/css">
					body {background-color : #fcfcfc; font-size: 12px; font-family: Trebuchet MS,Verdana, Arial, Helvetica, sans-serif; margin: 0px;}
					.redirect {width: 70%; margin: 110px; text-align: center; padding: 15px; border: #e0e0e0 1px solid; color: #666666; background-color: #f6f6f6;}
					.redirect a:link {color: #666666; text-decoration: none; font-weight: bold;}
					.redirect a:visited {color: #666666; text-decoration: none; font-weight: bold;}
					.redirect a:hover {color: #999999; text-decoration: underline; font-weight: bold;}
			</style>
			</head>
			<body>
			<div align="center">
			<div class="redirect">
			<span style="font-size: 16px; font-weight: bold;">'.$displayMessage.'</span>
			<hr style="height: 3px; border: 3px #E18A00 solid; width: 95%;" />
			<p>'.sprintf(_IFNOTRELOAD, $url).'</p>
			</div>
			</div>
			</body>
			</html>';
        }

        exit(); // need to response
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
     *
     * [NOTICE]
     * We set up only filters that are decided to register by us. This is not
     * flexible. This is not the style fixed.
     *
     * [MEMO]
     * For test, you can use automatic loading plug-in with writing a setting
     * in site_custom.ini.php.
     *
     * site_custom.ini.php:
     *    [Xcore]
     *    AutoPreload = 1
     *
     */
    protected function _setupFilterChain()
    {
        $this->_mStrategy->_setupFilterChain();
    }

    /**
     * This member function is overridden. Sets up the controller and the
     * environment.
     */
    protected function _setupEnvironment()
    {
        require_once XOOPS_ROOT_PATH.'/modules/xcore/include/version.php';

        define('XOOPS_XCORE_PATH', XOOPS_MODULE_PATH.'/'.XOOPS_XCORE_PROC_NAME);

        require_once XOOPS_ROOT_PATH.'/modules/xcore/include/functions.php';

        $GLOBALS['xoopsSecurity'] = new XoopsSecurity();
    }

    /**
     * Creates the instance of DataBase class, and sets it to member property.
     */
    protected function _setupDB()
    {
        if ( !defined('XOOPS_XMLRPC') )
            define('XOOPS_DB_CHKREF', 1);
        else
            define('XOOPS_DB_CHKREF', 0);

        if ( $this->mRoot->getSiteConfig('Xcore', 'AllowDBProxy') == true ) {
            if ( xoops_getenv('REQUEST_METHOD') != 'POST' || !xoops_refcheck(XOOPS_DB_CHKREF) ) {
                define('XOOPS_DB_PROXY', 1);
            }
        } elseif ( xoops_getenv('REQUEST_METHOD') != 'POST' ) {
            define('XOOPS_DB_PROXY', 1);
        }

        $this->mDB =& DatabaseFactory::getDatabaseConnection();

        $GLOBALS['xoopsDB'] =& $this->mDB;
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
     *
     * [Notice]
     * Now, this member function sets a string to the member property without
     * language manager.
     */
    protected function _setupLanguage()
    {
        $language = null;

        $this->mGetLanguageName->call(new Ref($language));

        if ( $language == null ) {
            $handler = xoops_gethandler('config');
            $criteria = new CriteriaCompo(new Criteria('conf_modid', 0));
            $criteria->add(new Criteria('conf_catid', XOOPS_CONF));
            $criteria->add(new Criteria('conf_name', 'language'));
            $configs =& $handler->getConfigs($criteria);

            if ( count($configs) > 0 ) {
                $language = $configs[0]->get('conf_value', 'none');
            }
        }

        $this->mRoot->mLanguageManager =& $this->_createLanguageManager($language);
        $this->mRoot->mLanguageManager->setLanguage($language);
        $this->mRoot->mLanguageManager->prepare();

        // If you use special page, load message catalog for it.
        if ( isset($GLOBALS['xoopsOption']['pagetype']) ) {
            $this->mRoot->mLanguageManager->loadPageTypeMessageCatalog($GLOBALS['xoopsOption']['pagetype']);
        }
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
        $configHandler = xoops_gethandler('config');

        $this->mRoot->mContext->mXoopsConfig =& $configHandler->getConfigsByCat(XOOPS_CONF);

        $this->mRoot->mContext->mXoopsConfig['language'] = $this->mRoot->mLanguageManager->getLanguage();
        $GLOBALS['xoopsConfig'] =& $this->mRoot->mContext->mXoopsConfig; // Compatiblity for 2.0.x
        $GLOBALS['config_handler'] =& $configHandler;
        $GLOBALS['module_handler'] = xoops_gethandler('module');

        if ( count($this->mRoot->mContext->mXoopsConfig) == 0 ) {
            return;
        }

        $this->mRoot->mContext->setThemeName($this->mRoot->mContext->mXoopsConfig['theme_set']);

        $this->mRoot->mContext->setAttribute('xcore_sitename', $this->mRoot->mContext->mXoopsConfig['sitename']);
        $this->mRoot->mContext->setAttribute('xcore_pagetitle', $this->mRoot->mContext->mXoopsConfig['slogan']);
        $this->mRoot->mContext->setAttribute('xcore_slogan', $this->mRoot->mContext->mXoopsConfig['slogan']);
    }

    /**
     * This member function is overridden. Sets up handler for session, then
     * starts session.
     */
    protected function _setupSession()
    {
        $this->mRoot->setSession(new Session());

        $root = Root::getSingleton();
        $xoopsConfig = $root->mContext->mXoopsConfig;
        if ( $xoopsConfig['use_mysession'] ) {
            $this->mRoot->mSession->setParam($xoopsConfig['session_name'], $xoopsConfig['session_expire']);
        }
        $this->mRoot->mSession->start();
    }

    /**
     * Sets up a principal object to the root object. In other words, restores
     * the principal object from session or other.
     */
    protected function _setupUser()
    {
        $this->mSetupUser->call(new Ref($this->mRoot->mContext->mUser), new Ref($this), new Ref($this->mRoot->mContext));

        // Set instance to global variable for compatiblity with XOOPS 2.0.x
        $GLOBALS['xoopsUser'] =& $this->mRoot->mContext->mXoopsUser;
        $GLOBALS['xoopsUserIsAdmin'] = is_object($this->mRoot->mContext->mXoopsUser) ? $this->mRoot->mContext->mXoopsUser->isAdmin(1) : false; //@todo Remove '1'

        //
        // Set member handler to global variables for compatibility with XOOPS 2.0.x.
        //
        $GLOBALS['xoopsMemberHandler'] = xoops_gethandler('member');
        $GLOBALS['member_handler'] =& $GLOBALS['xoopsMemberHandler'];
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
        $this->_mStrategy->setupBlock();
    }

    /**
     * Process of Block. Fetch objects from $this->mBlockChain, render the
     * result of the object with html data, and set those result to member
     * property.
     *
     * In this member function, the cache mechanism has to be important. If the
     * object has its cache, this function loads the cache data instead of
     * calling the business logic of the block.
     *
     * @access protected
     */
    protected function _processBlock()
    {
        $i = 0;

        //
        // Create render-target for blocks. We use reset() to re-cycle this
        // object in the foreach loop.
        //
        $context =& $this->mRoot->mContext;

        foreach ($this->_mBlockChain as $blockProcedure) {
            //
            // This is a flag indicating whether the controller needs to call
            // the logic of the block.
            //
            $usedCacheFlag = false;

            $cacheInfo = null;

            if ( $this->isEnableCacheFeature() && $blockProcedure->isEnableCache() ) {
                //
                // Reset the block cache information structure, and initialize.
                //
                $cacheInfo =& $blockProcedure->createCacheInfo();

                $this->mSetBlockCachePolicy->call(new Ref($cacheInfo));
                $filepath = $cacheInfo->getCacheFilePath();

                //
                // If caching is enable and the cache file exists, load and use.
                //
                if ( $cacheInfo->isEnableCache() && $this->existActiveCacheFile($filepath, $blockProcedure->getCacheTime()) ) {
                    $content = $this->loadCache($filepath);
                    if ( $blockProcedure->isDisplay() && !empty($content) ) {
                        $blockShowFlags = $context->getAttribute('xcore_BlockShowFlags');
                        $blockShowFlags[$blockProcedure->getEntryIndex()] = true;
                        $context->setAttribute('xcore_BlockShowFlags', $blockShowFlags);

                        $blockContents = $context->getAttribute('xcore_BlockContents');
                        $blockContents[$blockProcedure->getEntryIndex()][] = array(
                            'id'      => $blockProcedure->getId(),
                            'name'    => $blockProcedure->getName(),
                            'title'   => $blockProcedure->getTitle(),
                            'content' => $content,
                            'weight'  => $blockProcedure->getWeight()
                        );
                        $context->setAttribute('xcore_BlockContents', $blockContents);
                    }

                    $usedCacheFlag = true;
                }
            }

            if ( !$usedCacheFlag ) {
                $blockProcedure->execute();

                $renderBuffer = null;
                if ( $blockProcedure->isDisplay() ) {
                    $renderBuffer =& $blockProcedure->getRenderTarget();

                    $blockShowFlags = $context->getAttribute('xcore_BlockShowFlags');
                    $blockShowFlags[$blockProcedure->getEntryIndex()] = true;
                    $context->setAttribute('xcore_BlockShowFlags', $blockShowFlags);

                    $blockContents = $context->getAttribute('xcore_BlockContents');
                    $blockContents[$blockProcedure->getEntryIndex()][] = array(
                        'name'    => $blockProcedure->getName(),
                        'title'   => $blockProcedure->getTitle(),
                        'content' => $renderBuffer->getResult(),
                        'weight'  => $blockProcedure->getWeight(),
                        'id'      => $blockProcedure->getId(),
                    );
                    $context->setAttribute('xcore_BlockContents', $blockContents);
                } else {
                    //
                    // Dummy save
                    //
                    $renderBuffer = new RenderTarget();
                }

                if ( $this->isEnableCacheFeature() && $blockProcedure->isEnableCache() && is_object($cacheInfo) && $cacheInfo->isEnableCache() ) {
                    $this->cacheRenderTarget($cacheInfo->getCacheFilePath(), $renderBuffer);
                }
            }

            unset($blockProcedure);
        }
    }

    /**
     * Calls the preBlockFilter() member function of action filters which have been
     * loaded to the list of the controller.
     */
    protected function _processPreBlockFilter()
    {
        $this->_mStrategy->_processPreBlockFilter();

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
    public function _processPreload($path)
    {
        $path = $path."/";

        if ( is_dir($path) ) {
            foreach (glob($path.'/*.class.php') as $file) {
                require_once $file;
                $className = basename($file, '.class.php');
                if ( class_exists($className) && !isset($this->_mLoadedFilterNames[$className]) ) {
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

        $delegateManager->add('Xcorepage.Notifications.Access', 'Xcore_EventFunction::notifications');
        $delegateManager->add('Xcorefunction.Notifications.Select', 'Xcore_EventFunction::notifications_select');
        $delegateManager->add('Xcorepage.Search.Access', 'Xcore_EventFunction::search');
        $delegateManager->add('Xcorepage.Imagemanager.Access', 'Xcore_EventFunction::imageManager');
        $delegateManager->add('Xcorepage.Backend.Access', 'Xcore_EventFunction::backend');
        $delegateManager->add('Xcorepage.Misc.Access', 'Xcore_EventFunction::misc');
        $delegateManager->add('User_UserViewAction.GetUserPosts', 'Xcore_EventFunction::recountPost');

        return $delegateManager;
    }

    /**
     * Creates an instance of the service manager and returns it.
     * @return ServiceManager
     */
    protected function &_createServiceManager()
    {
        $serviceManager = new ServiceManager();

        $searchService = new Xcore_SearchService();
        $searchService->prepare();

        $serviceManager->addService('XcoreSearch', $searchService);

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

    function setupModuleContext($dirname = null)
    {
        if ( $dirname == null ) {
            $dirname = UrlParser::getModuleDirname(UrlParser::parse(XOOPS_URL));
        }

        if ( $dirname == null ) {
            return;
        }

        if ( !file_exists(XOOPS_ROOT_PATH.'/modules/'.$dirname.'/'.self::MODULE_MANIFESTO_FILENAME) ) {
            return;
        }

        $this->_mStrategy->setupModuleContext($this->mRoot->mContext, $dirname);

        if ( $this->mRoot->mContext->mModule != null ) {
            $this->mRoot->mContext->setAttribute('xcore_pagetitle', $this->mRoot->mContext->mModule->mXoopsModule->get('name'));
        }
    }

    function _processModule()
    {
        if ( $this->mRoot->mContext->mModule != null ) {
            $module =& $this->mRoot->mContext->mModule;
            if ( !$module->isActive() ) {
                /**
                 * Notify that the current user accesses none-activate module
                 * controller.
                 */
                DelegateUtils::call('Xcore.Event.Exception.ModuleNotActive', $module);
                $this->executeForward(XOOPS_URL.'/');
                die(); // need to response?
            }

            if ( !$this->_mStrategy->enableAccess() ) {
                DelegateUtils::call('Xcore.Event.Exception.ModuleSecurity', $module);
                $this->executeRedirect(XOOPS_URL.'/user.php', 1, _NOPERM); // TODO Depens on const message catalog.
                die(); // need to response?
            }

            $this->_mStrategy->setupModuleLanguage();
            $module->startup();

            $GLOBALS['xoopsModule'] =& $module->mXoopsModule;
            $GLOBALS['xoopsModuleConfig'] =& $module->mModuleConfig;
        }

        Xcore_Utils::raiseUserControlEvent();
    }

    // @todo change to refer settings ini file for HostAbstractLayer.
    function _processHostAbstractLayer()
    {
        require_once XOOPS_ROOT_PATH.'/modules/xcore/include/functions.php';

        $path_translated = xoops_getenv('PATH_TRANSLATED');
        $script_filename = xoops_getenv('SCRIPT_FILENAME');
        $request_uri = xoops_getenv('REQUEST_URI');
        if ( !isset($path_translated) && isset($script_filename) ) {
            // There is this setting for CGI mode. @todo We have to confirm this.
            $_SERVER['PATH_TRANSLATED'] =& $_SERVER['SCRIPT_FILENAME'];
        } elseif ( isset($path_translated) && !isset($script_filename) ) {
            // There is this setting for IIS Win2K. Really?
            $_SERVER['SCRIPT_FILENAME'] =& $_SERVER['PATH_TRANSLATED'];
        }

        // IIS does not set REQUEST_URI. This system defines it. But...
        if ( empty($request_uri) ) {
            $query_string = xoops_getenv('QUERY_STRING');
            if ( !($_SERVER['REQUEST_URI'] = xoops_getenv('PHP_SELF')) ) {
                $_SERVER['REQUEST_URI'] = xoops_getenv('SCRIPT_NAME');
            }
            if ( isset($query_string) ) {
                $_SERVER['REQUEST_URI'] .= '?'.$query_string;
            }

            // Guard for XSS string of PHP_SELF
            // @todo I must move this logic to preload plugin.
            if ( preg_match('/[\<\>\"\'\(\)]/', xoops_getenv('REQUEST_URI')) )
                throw new RuntimeException();
        }

        // What is this!? But, old system depends this setting. We have to confirm it and modify!
        $GLOBALS['xoopsRequestUri'] = xoops_getenv('REQUEST_URI');
    }

    function _setupErrorHandler()
    {
    }

    /**
     * Factory for the language manager. At first, this member function
     * delegates to get a instance of LanguageManager. If it can't get it, do
     * the following process:
     *
     * 1) Try creating a instance of 'Xcore_LanguageManager_' . ucfirst($language)
     * 2) If the class doesn't exist, try loading  'LanguageManager.class.php'
     *      in the specified language.
     * 3) Re-try creating the instance.
     *
     * If it can't create any instances, create a instance of
     * Xcore_LanguageManager as default.
     *
     * @access protected
     * @param string $language
     * @return Xcore_LanguageManager
     */
    function &_createLanguageManager($language)
    {
        $languageManager = null;

        $this->mCreateLanguageManager->call(new Ref($languageManager), $language);

        if ( !is_object($languageManager) ) {
            $className = 'Xcore_LanguageManager_'.ucfirst(strtolower($language));

            //
            // If the class exists, create a instance. Else, load the file, and
            // try creating a instance again.
            //
            if ( class_exists($className) ) {
                $languageManager = new $className();
            } else {
                $filePath = XOOPS_ROOT_PATH.'/language/'.$language.'/LanguageManager.class.php';
                if ( file_exists($filePath) ) {
                    require_once $filePath;
                }

                if ( class_exists($className) ) {
                    $languageManager = new $className();
                } else {
                    //
                    // Default
                    //
                    $languageManager = new Xcore_LanguageManager();
                }
            }
        }

        return $languageManager;
    }

    function _setupScript()
    {
        $headerScript = new Xcore_HeaderScript();
        $this->mRoot->mContext->setAttribute('headerScript', $headerScript);
    }

    /**
     * Set debbuger object to member property.
     * @return void
     */
    function _setupDebugger()
    {
        error_reporting(0);

        $debug_mode = $this->mRoot->mContext->mXoopsConfig['debug_mode'];
        if ( defined('OH_MY_GOD_HELP_ME') ) {
            $debug_mode = XOOPS_DEBUG_PHP;
        }

        $this->mSetupDebugger->call(new Ref($this->mDebugger), $debug_mode);
        $this->mDebugger->prepare();

        $GLOBALS['xoopsDebugger'] =& $this->mDebugger;
    }

    function _processModulePreload($dirname)
    {
        //
        // Auto pre-loading for Module.
        //
        if ( $this->mRoot->getSiteConfig('Xcore', 'AutoPreload') == 1 ) {
            if ( $this->mActiveModules ) $moduleObjects = $this->mActiveModules;
            else {
                $moduleHandler = xoops_gethandler('module');
                $criteria = new Criteria('isactive', 1);
                $this->mActiveModules =
                $moduleObjects =& $moduleHandler->getObjects($criteria);
            }
            foreach ($moduleObjects as $moduleObject) {
                $mod_dir = $moduleObject->getVar('dirname');
                $dir = XOOPS_ROOT_PATH.'/modules/'.$mod_dir.$dirname.'/';
                if ( is_dir($dir) ) {
                    $files = glob($dir.'*.class.php');
                    if ( $files ) {
                        foreach ($files as $file) {
                            require_once $file;
                            $className = ucfirst($mod_dir).'_'.basename($file, '.class.php');

                            if ( class_exists($className) && !isset($this->_mLoadedFilterNames[$className]) ) {
                                $this->_mLoadedFilterNames[$className] = true;
                                $this->addActionFilter(new $className($this));
                            }
                        }
                    }
                }
            }
        }
    }

    protected function _loadInterfaceFiles()
    {
        // TODO >> Delete this method. This method is not necessary because class-autoloaing is available
    }

    /**
     * $resultRenderTarget object The render target of content's result.
     */
    function _executeViewTheme(&$resultRenderTarget)
    {
        //
        // Get the render-system through theme object.
        //
        $theme =& $this->_mStrategy->getMainThemeObject();
        if ( !is_object($theme) ) {
            throw new RuntimeException('Could not found any themes.');
        }

        $renderSystem =& $this->mRoot->getRenderSystem($theme->get('render_system'));
        $screenTarget = $renderSystem->getThemeRenderTarget($this->mDialogMode);

        if ( is_object($resultRenderTarget) ) {
            $screenTarget->setAttribute('xoops_contents', $resultRenderTarget->getResult());
        }

        $screenTarget->setTemplateName($theme->get('dirname'));

        //
        // Rendering.
        //
        $renderSystem->render($screenTarget);

        //
        // Debug Process
        //
        $isAdmin = false;
        if ( is_object($this->mRoot->mContext->mXoopsUser) ) {
            if ( $this->mRoot->mContext->mModule != null && $this->mRoot->mContext->mModule->isActive() ) {
                // @todo I depend on Legacy Module Controller.
                $mid = $this->mRoot->mContext->mXoopsModule->getVar('mid');
            } else {
                $mid = 1; ///< @todo Do not use literal directly!
            }

            $isAdmin = $this->mRoot->mContext->mXoopsUser->isAdmin($mid);
        }

        if ( $isAdmin ) {
            $this->mDebugger->displayLog();
        }
    }

    /**
     * Check the login request through delegates, and set Object to member
     * property if the login is success.
     *
     * @access public
     */
    function checkLogin()
    {
        if ( !is_object($this->mRoot->mContext->mXoopsUser) ) {
            $this->mCheckLogin->call(new Ref($this->mRoot->mContext->mXoopsUser));

            $this->mRoot->mLanguageManager->loadModuleMessageCatalog('xcore');

            if ( is_object($this->mRoot->mContext->mXoopsUser) ) {
                // If the current user doesn't bring to any groups, kick out him for XCL's security.
                $t_groups = $this->mRoot->mContext->mXoopsUser->getGroups();
                if ( !is_array($t_groups) ) {
                    // exception
                    $this->logout();

                    return;
                } else if ( count($t_groups) == 0 ) {
                    // exception, too
                    $this->logout();

                    return;
                }

                // RMV-NOTIFY
                // Perform some maintenance of notification records
                $notification_handler = xoops_gethandler('notification');
                $notification_handler->doLoginMaintenance($this->mRoot->mContext->mXoopsUser->get('uid'));

                DelegateUtils::call('Site.CheckLogin.Success', new Ref($this->mRoot->mContext->mXoopsUser));

                //
                // Fall back process for login success.
                //
                $url = XOOPS_URL;
                if ( !empty($_POST['xoops_redirect']) && !strpos(xoops_getrequest('xoops_redirect'), 'register') ) {
                    $parsed = parse_url(XOOPS_URL);
                    $url = isset($parsed['scheme']) ? $parsed['scheme'].'://' : 'http://';

                    if ( isset($parsed['host']) ) {
                        $url .= isset($parsed['port']) ? $parsed['host'].':'.$parsed['port'].trim(xoops_getrequest('xoops_redirect')) : $parsed['host'].trim(xoops_getrequest('xoops_redirect'));
                    } else {
                        $url .= xoops_getenv('HTTP_HOST').trim(xoops_getrequest('xoops_redirect'));
                    }
                }

                $this->executeRedirect($url, 1, Utils::formatMessage(_MD_XCORE_MESSAGE_LOGIN_SUCCESS, $this->mRoot->mContext->mXoopsUser->get('uname')));
            } else {
                DelegateUtils::call('Site.CheckLogin.Fail', new Ref($this->mRoot->mContext->mXoopsUser));

                //
                // Fall back process for login fail.
                //
                $this->executeRedirect(XOOPS_URL.'/user.php', 1, _MD_XCORE_ERROR_INCORRECTLOGIN);
            }
        } else {
            $this->executeForward(XOOPS_URL.'/');
        }
    }

    /**
     * The current user logout.
     *
     * @access public
     */
    function logout()
    {
        $successFlag = false;
        $xoopsUser =& $this->mRoot->mContext->mXoopsUser;

        if ( is_object($xoopsUser) ) {
            $this->mRoot->mLanguageManager->loadModuleMessageCatalog('xcore');

            $this->mLogout->call(new Ref($successFlag), $xoopsUser);
            if ( $successFlag ) {
                DelegateUtils::call('Site.Logout.Success', $xoopsUser);
                $this->executeRedirect(XOOPS_URL.'/', 1, array(
                    _MD_XCORE_MESSAGE_LOGGEDOUT,
                    _MD_XCORE_MESSAGE_THANKYOUFORVISIT
                ));
            } else {
                DelegateUtils::call('Site.Logout.Fail', $xoopsUser);
            }
        } else {
            $this->executeForward(XOOPS_URL.'/');
        }
    }

    /**
     * @deprecated
     * @see setStrategy()
     */
    function switchStateCompulsory(&$strategy)
    {
        $this->setStrategy($strategy);
    }

    /**
     * CAUTION!!
     * This method has a special mission.
     * Because this method changes state after executeCommon, this resets now property.
     * It depends on Controller steps.
     *
     * @param Xcore_AbstractControllerStrategy $strategy
     */
    function setStrategy(&$strategy)
    {
        if ( $strategy->mStatusFlag != $this->_mStrategy->mStatusFlag ) {
            $this->_mStrategy =& $strategy;

            //
            // The following line depends on Controller process of executeCommon.
            // But, There is no other method.
            //
            $this->setupModuleContext();
            $this->_processModule();
        }
    }

    /**
     * Set bool flag to dialog mode flag.
     * If you set true, executeView() will use Xcore_DialogRenderTarget class as
     * render target.
     * @param $flag bool
     */
    function setDialogMode($flag)
    {
        $this->mDialogMode = $flag;
    }

    /**
     * Return dialog mode flag.
     * @return bool
     */
    function getDialogMode()
    {
        return $this->mDialogMode;
    }

    /**
     *	Return current module object. But, it's decided by the rules of the state.
     *	Preferences page, Help page and some pages returns the specified module by
     * dirname. It's useful for controlling a theme.
     *
     * @return Module
     */
    function &getVirtualCurrentModule()
    {
        $ret =& $this->_mStrategy->getVirtualCurrentModule();
        return $ret;
    }


    /**
     * Gets a value indicating whether the controller can use a cache mechanism.
     * @return bool
     */
    function isEnableCacheFeature()
    {
        return $this->_mStrategy->isEnableCacheFeature();
    }

    /**
     * Gets a value indicating wheter a cache file keeps life time. If
     * $cachetime is 0 or the specific cache file doesn't exist, gets false.
     *
     * @param string $filepath	a file path of the specific cache file.
     * @param int	 $cachetime cache active duration. (Sec)
     * @return bool
     */
    function existActiveCacheFile($filepath, $cachetime)
    {
        if ($cachetime == 0) {
            return false;
        }

        if (!file_exists($filepath)) {
            return false;
        }

        return ((time() - filemtime($filepath)) <= $cachetime);
    }



    /**
     * Save the content of $renderTarget to $filepath.
     * @param string $filepath a file path of the cache file.
     * @param RenderTarget $renderBuffer
     * @return bool success or failure.
     */
    function cacheRenderTarget($filepath, &$renderTarget)
    {
        $fp = fopen($filepath, 'wb');
        if ($fp) {
            fwrite($fp, $renderTarget->getResult());
            fclose($fp);
            return true;
        }

        return false;
    }

    /**
     * Loads $filepath and gets the content of the file.
     * @return string the content or null.
     */
    function loadCache($filepath)
    {
        if (file_exists($filepath)) {
            return file_get_contents($filepath);
        }

        return null;
    }

    /**
     * Gets URL of preference editor by this controller.
     * @public
     * @param Module $module
     * @return string absolute URL
     */
    function getPreferenceEditUrl(&$module)
    {
        if (is_object($module)) {
            return XOOPS_MODULE_URL . '/xcore/admin/index.php?action=PreferenceEdit&confmod_id=' . $module->get('mid');
        }

        return null;
    }

    /**
     * Gets URL of help viewer by this controller.
     * @public
     * @param Module $module
     * @return string absolute URL
     */
    function getHelpViewUrl(&$module)
    {
        if (is_object($module)) {
            return XOOPS_MODULE_URL . '/xcore/admin/index.php?action=Help&dirname=' . $module->get('dirname');
        }

        return null;
    }
}
